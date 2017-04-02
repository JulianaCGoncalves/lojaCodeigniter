<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller{
	private $categorias;

	public function __construct(){
		parent::__construct();
		$this->load->model('categorias_model','modelcategorias');
		$this->categorias=$this->modelcategorias->listar_categorias();
	}

	public function index(){
		$this->load->view('administracao/html_header');
		$this->load->view('administracao/header');
		$this->load->view('administracao/home');
		$this->load->view('administracao/footer');
		$this->load->view('administracao/html_footer');
	}
}