<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Costo_operacion_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["id" => $id]);
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
		return $this->db->get("costo_operacion")->result_array();
	}

	function insert($params, $return_id = 0, $debug = 0)
	{
		$insert = $this->db->insert("costo_operacion", $params, $debug);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}


	function get_recibo($id_recibo){

		$query_get =
			"SELECT c.* , t.tipo  FROM costo_operacion c INNER JOIN tipo_costo t ON t.id_tipo_costo = c.id_tipo_costo 
			WHERE c.id_recibo =  $id_recibo";
		return $this->db->query($query_get)->result_array();
	}

}
