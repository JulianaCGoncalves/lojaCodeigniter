<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cadastro extends CI_Controller{
	private $categorias;

	public function __construct(){
		parent::__construct();
		$this->load->model('categorias_model','modelcategorias');
		$this->categorias=$this->modelcategorias->listar_categorias();
		$this->load->model('cadastro_model','modelcadastro');
	}

	public function index(){
		$data_header['categorias']=$this->categorias;
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('novo_cadastro');
		$this->load->view('footer');
		$this->load->view('html-footer');
	}

	public function adicionar(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nome','Nome','required');
		$this->form_validation->set_rules('cpf','CPF','required');
		$this->form_validation->set_rules('email','E-mail','required|valid_email|is_unique[clientes.email]');
		if($this->form_validation->run() == false){
			$this->index();
		}else{
			$dados['nome']=$this->input->post('nome');
			$dados['sobrenome']=$this->input->post('sobrenome');
			$dados['rg']=$this->input->post('rg');
			$dados['cpf']=$this->input->post('cpf');
			$dados['data_nascimento']=dataBr_to_dataMySQL($this->input->post('data_nascimento'));
			$dados['sexo']=$this->input->post('sexo');
			$dados['cep']=$this->input->post('cep');
			$dados['rua']=$this->input->post('rua');
			$dados['bairro']=$this->input->post('bairro');
			$dados['cidade']=$this->input->post('cidade');
			$dados['estado']=$this->input->post('estado');
			$dados['numero']=$this->input->post('numero');
			$dados['telefone']=$this->input->post('telefone');
			$dados['celular']=$this->input->post('celular');
			$dados['email']=$this->input->post('email');
			$dados['senha']=$this->input->post('senha');
			if($this->db->insert('clientes',$dados)){
				$this->enviar_email_confirmacao($dados);
			}else{
				echo "Houve um erro ao processar seu cadastro";
			}
		}
	}

	public function enviar_email_confirmacao($dados){
		//$mensagem=$this->load->view('emails/confirmar_cadastro.php',$dados,TRUE);
		//$this->load->library('email');
		//$this->email->from('loja@TheGroceryStoreBrazil',"The Grocery Store Brazil");
		//$this->email->to($dados['email']);
		//$this->email->subject('The Crocery Brazil - Confirmação de cadastro');
		//$this->email->message($mensagem);
		//if($this->email->send()){
		$data_header['categorias']=$this->categorias;
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('cadastro_enviado');
		$this->load->view('footer');
		$this->load->view('html-footer');
		//}else{
		//  print_r($this->email->print_debugger());
		//}
	}

	public function confirmar($hashEmail){
		$dados['status']=1;
		if($this->modelcadastro->confirmar('clientes',$hashEmail,$dados)){
			$data_header['categorias']=$this->categorias;
			$this->load->view('html-header');
			$this->load->view('header',$data_header);
			$this->load->view('cadastro_liberado');
			$this->load->view('footer');
			$this->load->view('html-footer');
		}else{
			echo "Houve um erro ao confirmar seu cadastro";
		}
	}

	public function form_login(){
		$data_header['categorias']=$this->categorias;
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('login');
		$this->load->view('footer');
		$this->load->view('html-footer');
	}

	public function login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','E-mail','required|valid_email');
		$this->form_validation->set_rules('senha','Senha','required|min_length[5]');
		if($this->form_validation->run() == false){
			$this->form_login();
		}else{
			//$dados['email']=$this->input->post('email');
			//$dados['senha']=$this->input->post('senha');
			//$cliente=$this->modelcadastro->validar('clientes',$dados);
			$this->db->where('email',$this->input->post('email'));
			$this->db->where('senha',$this->input->post('senha'));
			$this->db->where('status',1);
			$cliente=$this->db->get('clientes')->result();
			if(count($cliente) == 1){
				$dadosSessao['cliente']=$cliente[0];
				$dadosSessao['logado']=TRUE;
				$this->session->set_userdata($dadosSessao);
				redirect(base_url('produtos'));
			}else{
				$dadosSessao['cliente']=NULL;
				$dadosSessao['logado']=FALSE;
				$this->session->set_userdata($dadosSessao);
				redirect(base_url('login'));
			}

		}
	}

	public function logout(){
		$dadosSessao['cliente']=NULL;
		$dadosSessao['logado']=FALSE;
		$this->session->set_userdata($dadosSessao);
		redirect(base_url('login'));
	}

	public function esqueci_minha_senha(){
		$data_header['categorias']=$this->categorias;
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('form_recupera_login');
		$this->load->view('footer');
		$this->load->view('html-footer');
	}

	public function recuperar_login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','E-mail','required|valid_email');
		$this->form_validation->set_rules('cpf','CPF','required');
		if($this->form_validation->run() == false){
			$this->esqueci_minha_senha();
		}else{
			$this->db->where('email',$this->input->post('email'));
			$this->db->where('cpf',$this->input->post('cpf'));
			$this->db->where('status',1);
			$cliente=$this->db->get('clientes')->result();
			if(count($cliente) == 1){
				$dados=$cliente[0];
				$mensagem=$this->load->view('emails/recuperar_senha.php',$dados,TRUE);
				$this->load->library('email');
				$this->email->from('loja#loja','The loja');
				$this->email->to($dados->email);
				$this->email->subject('The Crocery Store Brazil - Recuperação de cadastro');
				$this->email->message($mensagem);
				if($this->email->send()){
					$data_header['categorias']=$this->categorias;
					$this->load->view('html-header');
					$this->load->view('header',$data_header);
					$this->load->view('senha_enviada');
					$this->load->view('footer');
					$this->load->view('html-footer');
				}else{
					print_r($this->email->print_debugger());
				}
			}else{
				redirect(base_url('esqueci-minha-senha'));
			}

		}
	}

	public function alterar_cadastro($id){
		if(null != $this->session->userdata('logado')){
			$this->db->where('md5(id)',$id);
			$this->db->where('id',$this->session->userdata('cliente')->id);
			$this->db->where('status',1);
			$data_pagina['cliente']=$this->db->get('clientes')->result();
			if(count($data_pagina['cliente']) == 1){
				$data_header['categorias']=$this->categorias;
				$this->load->view('html-header');
				$this->load->view('header',$data_header);
				$this->load->view('alterar_cadastro',$data_pagina);
				$this->load->view('footer');
				$this->load->view('html-footer');
			}else{
				redirect(base_url('login'));
			}
		}
	}

	public function salvar_alteracao_cadastro(){
		if(null != $this->session->userdata('logado')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nome','Nome','required|min_length[5]');
			$this->form_validation->set_rules('cpf','CPF','required|min_length[14]');
			$this->form_validation->set_rules('email','E-mail','required|valid_email');
			if($this->form_validation->run() == false){
				$this->alterar_cadastro($this->input->post('id'));
			}else{
				$dados['nome']=$this->input->post('nome');
				$dados['sobrenome']=$this->input->post('sobrenome');
				$dados['rg']=$this->input->post('rg');
				$dados['cpf']=$this->input->post('cpf');
				$dados['data_nascimento']=dataBr_to_dataMySQL($this->input->post('data_nascimento'));
				$dados['sexo']=$this->input->post('sexo');
				$dados['cep']=$this->input->post('cep');
				$dados['rua']=$this->input->post('rua');
				$dados['bairro']=$this->input->post('bairro');
				$dados['cidade']=$this->input->post('cidade');
				$dados['estado']=$this->input->post('estado');
				$dados['numero']=$this->input->post('numero');
				$dados['telefone']=$this->input->post('telefone');
				$dados['celular']=$this->input->post('celular');
				$dados['email']=$this->input->post('email');
				$dados['senha']=$this->input->post('senha');
				$dados['status']=0;
				$this->db->query("insert into clientes_log select * from clientes where md5(id)='".$this->input->post('id')."'");
				$this->db->where('md5(id)',$this->input->post('id'));
				if($this->db->update('clientes',$dados)){
				//$this->enviar_email_confirmacao($dados);
					echo "Envio de e-mail";
				}else{
					echo "Houve um erro ao processar o cadastro";
				}
			}
		}else{
			redirect(base_url('login'));
		}
	}
}

