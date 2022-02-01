<?php defined('BASEPATH') OR exit('No direct script access allowed');

class proyecto_persona_forma_pago_punto_encuentro_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("proyecto_persona_forma_pago_punto_encuentro", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function delete($params_where = [], $limit = 1)
	{
		$this->db->limit($limit);
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		return $this->db->delete("proyecto_persona_forma_pago_punto_encuentro", $params_where);
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
		return $this->db->get("proyecto_persona_forma_pago_punto_encuentro")->result_array();
	}
    function in($ids){

        $query_get = "SELECT * FROM proyecto_persona_forma_pago_punto_encuentro 
                      WHERE 
                      id_proyecto_persona_forma_pago  IN(".$ids.")";

        return $this->db->query($query_get)->result_array();
    }
}