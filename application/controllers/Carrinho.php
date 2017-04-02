<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Carrinho extends CI_Controller{
	private $categorias;

	public function __construct(){
		parent::__construct();
		$this->load->model('categorias_model','modelcategorias');
		$this->categorias=$this->modelcategorias->listar_categorias();
	}

	public function index(){
		$data_header['categorias']=$this->categorias;
		if(null != $this->session->userdata('logado')){
			$sessao=$this->session->userdata();
			$cep=str_replace("-","",$sessao['cliente']->cep);
			$data['frete']=$this->calcular_frete($cep);
		}else{
			$data['frete']=null;
		}
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('carrinho',$data);
		$this->load->view('footer');
		$this->load->view('html-footer');
	}

	public function adicionar(){
		$data=array('id'=>$this->input->post('id'),
			'qty'=>$this->input->post('quantidade'),
			'price'=>$this->input->post('preco'),
			'name'=>$this->input->post('nome'),
			'altura'=>$this->input->post('altura'),
			'largura'=>$this->input->post('largura'),
			'comprimento'=>$this->input->post('comprimento'),
			'peso'=>$this->input->post('peso'),
			'option'=>null,
			'url'=>$this->input->post('url'),
			'foto'=>$this->input->post('foto'));
		$this->cart->insert($data);
		redirect(base_url('carrinho'));
	}

	public function atualizar(){
		foreach ($this->input->post() as $item) {
			if(isset($item['rowid'])){
				$data=array('rowid'=>$item['rowid'],'qty'=>$item['qty']);
				$this->cart->update($data);
			}
		}
		redirect(base_url('carrinho'));
	}

	public function remover($rowid){
		$data=array('rowid'=>$rowid,'qty'=>0);
		$this->cart->update($data);
		redirect(base_url('carrinho'));
	}

	public function calcular_frete($cep_destino){
		$maior_alt=$maior_lar=$maior_comp=$cm_cub=$peso=0;
		foreach($this->cart->contents() as $item){
			if($item['altura']>$maior_alt){
				$maior_alt=$item['altura'];
			}
			if($item['largura']> $maior_lar){
				$maior_lar=$item['largura'];
			}
			if($item['comprimento']>$maior_comp){
				$maior_comp=$item['comprimento'];
			}
			$cm_cub+=((($item['altura']/10)*($item['largura']/10)
				*($item['comprimento']/10))/100)
			*$item['qty'];
			$peso+=($item['peso']*$item['qty']);
		}
		$maiores_dimensoes=array('alt'=>$maior_alt,'lar'=>$maior_lar,'comp'=>$maior_comp);
		arsort($maiores_dimensoes);
		foreach ($maiores_dimensoes as $chave => $valor) {
			$caixa[]=$valor;
		}
		$dimensao1=$caixa[0];
		$dimensao2=$caixa[1];
		$dimensao3=1;
		$caixas=1;
		while(((($dimensao1/10)*($dimensao2/10)*($dimensao3/10))/100)<$cm_cub){
			$dimensao3++;
			if($dimensao3 %1000 ==0){
				$caixas++;
			}
		}
		if($caixas >1){
			$dimensao3=$dimensao3-(($caixas-1)*1000);
		}
		$cep_origem=80060160;
		$preco_correio=0;
		if($caixas==1){
			$preco_correio=$this->correio($cep_origem,$cep_destino,($dimensao1/10),($dimensao2/10),($dimensao3/10),($peso/1000));
		}else if($caixas>1){
			$peso=($peso/$caixas);
			for($i=$caixas;$i>0;$i--){
				if($i>1){
					$preco_correio+=$this->correio($cep_origem,$cep_destino,($dimensao1/10),($dimensao2/10),100,($peso/1000));
				}else{
					$preco_correio+=$this->correio($cep_origem,$cep_destino,($dimensao1/10),($dimensao2/10),($dimensao3/10),($peso/1000));
				}
			}
		}
		return $preco_correio;
	}

	public function correio($cep_origem,$cep_destino,$comprimeto,$altura,$largura,$peso){
		if($altura<2){
			$altura=2;//-18 A altura não pode ser inferior a 2cm
		}
		if($largura<11){
			$altura=11;//-20 A largura não pode ser inferior a 11cm
		}
		if($comprimeto<16){
			$comprimeto=16;//-22 O comprimento não pode ser inferior a 16 cm
		}
		$data['nCdEmpresa']='';
		$data['sDsSenha']='';
		$data['sCepOrigem']=$cep_origem;
		$data['sCepDestino']=$cep_destino;
		$data['nVlPeso']=$peso;
		$data['nCdFormato']='1';
		$data['nVlComprimento']=$comprimeto;
		$data['nVlAltura']=$altura;
		$data['nVlLargura']=$largura;
		$data['nVlDiametro']='0';
		$data['sCdMaoPropria']='s';
		$data['nVlValorDeclarado']='0';
		$data['sCdAvisoRecebimento']='n';
		$data['StrRetorno']='xml';
		$data['nCdServico']='40010';//41106 PAC,40010 SEDEX,40045 SEDEX a 
									//cobrar,40215 SEDEX 10
		$data=http_build_query($data);
		$url='http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
		$curl=curl_init($url.'?'.$data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result=curl_exec($curl);
		$result=simplexml_load_string($result);
		foreach($result->cServico as $row){
			if($row->Erro==0){
				return $row->Valor;
			}else{
				echo"<pre>";
				print_r($row);
			}
		}
	}
	public function form_pagamento(){
		$data_header['categorias']=$this->categorias;
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('formulario_pagamento');
		$this->load->view('footer');
		$this->load->view('html-footer');
	}

}