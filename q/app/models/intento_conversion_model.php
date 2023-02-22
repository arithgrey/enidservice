<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Intento_conversion_model extends CI_Model
{
    private $tabla;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->tabla = 'intento_conversion';
	}

	function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert($this->tabla, $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function get($params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
    {

        $this->db->limit($limit);
        $this->db->select(implode(",", $params));
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        if ($order != '') {
            $this->db->order_by($order, $type_order);
        }
        return $this->db->get($this->tabla)->result_array();
    }
    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->tabla, $data);
        
    }
    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->tabla, $params_where);
    }
    function intentos($ip)
	{
		$query_get = "SELECT intentos FROM intento_conversion 
                    WHERE ip = '".$ip."'";
		return $this->db->query($query_get)->result_array();
		
	}
    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id_intento_conversion" => $id]);
    }
    function intento_conversion($ip)
	{
		$query_get = "SELECT * FROM intento_conversion 
                    WHERE ip = '".$ip."' AND se_muestra_cupon < 4 LIMIT 1";
		return $this->db->query($query_get)->result_array();
		
	}


}