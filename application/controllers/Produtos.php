<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Produtos extends CI_Controller{
	public $categorias;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('categorias_model','modelcategorias');
		$this->load->model('produtos_model','modelprodutos');
		$this->categorias=$this->modelcategorias->listar_categorias();
	}

	public function index(){
		$this->load->helper('text');
		$data_header['categorias']=$this->categorias;
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('categorias',$data_header);
		$this->load->view('footer');
		$this->load->view('html-footer');
	}

	public function produto($id,$slug=null){
		$this->load->helper('text');
		$data_header['categorias']=$this->categorias;
		$data_pagina['produtos']=$this->modelprodutos->detalhes_produto($id);
		$this->load->view('html-header');
		$this->load->view('header',$data_header);
		$this->load->view('produto',$data_pagina);
		$this->load->view('footer');
		$this->load->view('html-footer');
	}
}