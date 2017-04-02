<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cadastro_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function inserir($table,$dados){
		if($this->db->insert($table,$dados)){
			return true;
		}else{
			return false;
		}
	}

	public function confirmar($table,$hashEmail,$dados){
		$this->db->where('md5(email)',$hashEmail);
		if($this->db->update($table,$dados)){
			return true;
		}else{
			return false;
		}
	}

	public function validar($table,$dados){
		$this->db->where('email',$dados['email']);
		$this->db->where('senha',$dados['senha']);
		$this->db->where('status',1);
		if($cliente=$this->db->get($table)->result()){
			return $cliente;
		}else{
			return $cliente=null;
		}
	}
}