<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Recordatorio_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function update($data = [], $params_where = [], $limit = 1)
	{
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->limit($limit);
		return $this->db->update("recordatorio", $data);
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("recordatorio", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
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
		return $this->db->get("recordatorio")->result_array();
	}

	function get_complete($id_orden_compra)
	{

		$sql = "SELECT r.* , t.tipo FROM recordatorio r  INNER JOIN tipo_recordatorio t ON
              r.id_tipo = t.idtipo_recordatorio 
            WHERE id_orden_compra = $id_orden_compra  ORDER BY id_recordatorio DESC LIMIT 10";

		return $this->db->query($sql)->result_array();


	}

	function q_up($q, $q2, $id)
	{
		return $this->update([$q => $q2], ["id_recordatorio" => $id]);
	}

}
