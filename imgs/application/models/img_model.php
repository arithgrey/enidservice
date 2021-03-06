<?php defined('BASEPATH') OR exit('No direct script access allowed');

class img_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get($params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
	{
		$params = implode(",", $params);
		$this->db->limit($limit);
		$this->db->select($params);
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		return $this->db->get("imagen")->result_array();
	}
	function q_get($params = [], $id)
	{

		return $this->get($params, ["idimagen" => $id]);

	}

}