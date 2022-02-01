<?php defined('BASEPATH') OR exit('No direct script access allowed');

class faqsmodel extends CI_Model
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
		return $this->db->update("faq", $data);
	}

	function q_up($q, $q2, $id_usuario)
	{
		return $this->update([$q => $q2], ["idusuario" => $id_usuario]);
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["id_faq" => $id]);
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
		return $this->db->get("faq")->result_array();
	}

	function search($param)
	{
		$extra = "AND status = 1";
		$query_get = "SELECT * FROM faq 
                        WHERE 
                        titulo 
                        like '%" . $param["q"] . "%' 
                        " . $extra . "
                        LIMIT 25";
		$result = $this->db->query($query_get);
		return $result->result_array();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("faq", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function qsearch($param)
	{

		$query_get = "SELECT 
        titulo, 
        id_faq  
        FROM 
        faq 
        WHERE 
        id_categoria = '" .  $param["id_categoria"] . "'   " . $param["extra"] . "  ";

		return $this->db->query($query_get)->result_array();

	}
}