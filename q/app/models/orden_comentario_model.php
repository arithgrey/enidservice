<?php

use PhpParser\Node\Stmt\Return_;

 defined('BASEPATH') OR exit('No direct script access allowed');

class Orden_comentario_model extends CI_Model
{	
	private $table;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table = 'orden_comentarios';
	}

	function q_up($q, $q2, $id)
	{
		return $this->update([$q => $q2], ["id" => $id]);
	}

	function update($data = [], $params_where = [], $limit = 1)
	{
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->limit($limit);
		return $this->db->update($this->table, $data);
	}

	function get($params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
	{
		$params = implode(",", $params);
		$this->db->limit($limit);
		$this->db->select($params);
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		if ($order != '') {
			$this->db->order_by($order, $type_order);
		}
		return $this->db->get($this->table)->result_array();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert($this->table, $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["id" => $id]);
	}

	function in($ids)
	{
		$query_get = "SELECT * FROM orden_comentarios 
			WHERE id_orden_compra IN($ids) ORDER BY fecha_registro DESC";
		return $this->db->query($query_get)->result_array();
		

	}


}