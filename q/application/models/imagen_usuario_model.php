<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Imagen_usuario_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("imagen_usuario", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function delete($params_where = [], $limit = 1)
	{
		$this->db->limit($limit);
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		return $this->db->delete("imagen_usuario", $params_where);
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
		return $this->db->get("imagen_usuario")->result_array();
	}

	function get_img_usuario($id_usuario)
	{
		return $this->get(["id_imagen"], ["idusuario" => $id_usuario]);
	}

	function img_perfil($param)
	{

		$query_get = "SELECT COUNT(0)num FROM imagen_usuario
                        WHERE 
                            DATE(fecha_registro) 
                        BETWEEN 
                          '" . $param["fecha_inicio"] . "' 
                        AND  
                          '" . $param["fecha_termino"] . "'";

		return $this->db->query($query_get)->result_array()[0]["num"];

	}

	function insert_imgen_usuario($param)
	{

		$this->elimina_pre_img_usuario($param);
		$id_usuario = $param["id_usuario"];
		$id_empresa = $param["id_empresa"];
		$id_imagen = $this->insert_img($param, 1);
		$params = ["id_imagen" => $id_imagen, "idusuario" => $id_usuario];
		return $this->insert("imagen_usuario", $params);
	}
}