<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banco_model extends CI_Model
{	
	private $table; 
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table = 'bancos';
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


}
	