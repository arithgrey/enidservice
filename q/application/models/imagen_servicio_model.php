<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Imagen_servicio_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("imagen_servicio", $params);
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
		return $this->db->get("imagen_servicio")->result_array();
	}

	function get_imagenes_por_servicio($param)
	{
		$id_servicio = $param["id_servicio"];
		return $this->get(["id_imagen"], ["id_servicio" => $id_servicio], 10);
	}

	function delete($params_where = [], $limit = 1)
	{
		$this->db->limit($limit);
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		return $this->db->delete("imagen_servicio", $params_where);
	}

	function get_num_servicio($id_servicio)
	{
		return $this->get(["COUNT(0)num"], ["id_servicio" => $id_servicio])[0]["num"];
	}

	function update($data = [], $params_where = [], $limit = 1)
	{

		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->limit($limit);
		return $this->db->update("imagen_servicio", $data);
	}
	function  get_imagen_servicio($id_servicio, $limit){

		$query_get =  "SELECT i.nombre_imagen , iss.* FROM  
							imagen_servicio  iss 
							INNER JOIN imagen i 
							ON  
							iss.id_imagen =  i.idimagen
							WHERE iss.id_servicio =  $id_servicio 
							ORDER BY iss.principal DESC LIMIT $limit ";

		return  $this->db->query($query_get)->result_array();


	}
}