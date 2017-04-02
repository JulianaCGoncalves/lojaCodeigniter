<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Produtos_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function detalhes_produto($id){
		$this->db->where('id',$id);
		return $this->db->get('produtos')->result();
	}

	public function destaques_home($quantos=3){
		$this->db->limit($quantos);
		$this->db->order_by('id','random');
		return $this->db->get('produtos')->result();
	}

	public function busca($busca){
		$this->db->like('titulo',$busca);
		$this->db->or_like('descricao',$busca);
		return $this->db->get('produtos')->result();
	}
}