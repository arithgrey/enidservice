<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orden_comentario_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
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
		return $this->db->update("orden_comentario", $data);
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
		return $this->db->get("orden_comentario")->result_array();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("orden_comentario", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["id_orden_comentario" => $id]);
	}

}