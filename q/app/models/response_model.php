<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Response_model extends CI_Model
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
		return $this->db->update("response", $data);
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("response", $params);
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
		return $this->db->get("response")->result_array();
	}

	function get_respuestas_pregunta($id_pregunta)
	{


		$query_get = "SELECT 
                      r.respuesta     
                      ,r.fecha_registro
                      ,r.id_usuario    
                      ,r. id_pregunta
                      ,u.nombre 
                      ,u.apellido_paterno
                      FROM 
                        response r 
                        INNER JOIN  
                        users u 
                        ON r.id_usuario = u.id
                      WHERE 
                        r.id_pregunta =  '" . $id_pregunta . "'
                      ORDER BY 
                      fecha_registro ASC
                      LIMIT 20";

		return $this->db->query($query_get)->result_array();
	}

}
