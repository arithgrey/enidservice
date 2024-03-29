<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Respuesta_model extends CI_Model
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
		return $this->db->update("respuesta", $data);
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert('respuesta', $params);
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
		return $this->db->get("respuesta")->result_array();
	}

	function get_num_respuestas($param)
	{
		return $this->get(["COUNT(0)num"], ["id_tarea" => $param["tarea"]])[0]["num"];
	}

	function get_num_respuestas_sin_leer($id_pregunta)
	{
		return $this->get(["COUNT(0)respuestas"], ["id_pregunta" => $id_pregunta]);
	}

	function q_up($q, $q2, $id)
	{
		return $this->update([$q => $q2], ["id_servicio" => $id]);
	}

	function get_respuestas($param)
	{


		$query_get = "SELECT 
                     r.*, 
                     u.name , 
                     u.apellido_paterno ,
                     u.apellido_materno ,
                     up.idperfil
                   FROM 
                    respuesta  r
                   INNER JOIN
                    users u                    
                   ON 
                    r.id_usuario =  u.id                  
                   INNER JOIN usuario_perfil up 
                    ON u.id = up.idusuario                    
                   WHERE 
                    r.id_tarea = '" . $param["tarea"] . "' 
                   ORDER BY 
                   r.fecha_registro DESC 
                   ";
		$result = $this->db->query($query_get);
		return $result->result_array();
	}
	

}
