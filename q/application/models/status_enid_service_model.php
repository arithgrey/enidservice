<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Status_enid_service_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/*
	function get_status_enid_service($param){
		return $this->get(["id_estatus_enid_service", "nombre"], [], 100);
	}
	*/
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
		return $this->db->get("status_enid_service")->result_array();
	}

}
