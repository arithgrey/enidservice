<?php defined('BASEPATH') OR exit('No direct script access allowed');

class valoracion_model extends CI_Model
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
		return $this->db->update("valoracion", $data);
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
		return $this->db->get("valoracion")->result_array();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("valoracion", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function set_gamificacion($param, $positivo = 1, $valor = 1)
	{
		$val = ($positivo == 1) ? "valoracion + " . $valor : "valoracion - " . $valor;
		return $this->q_up("valoracion", $val, $param["id_servicio"]);
	}

	function get_valoraciones($param)
	{
		return $this->get([], ["id_servicio" => $param["id_servicio"]], 6, 'id_valoracion');
	}

	function get_valoraciones_usuario($param)
	{
		$_num = mt_rand();
		$this->create_tmp_servicios_usuario($_num, 1, $param);
		$id_usuario = $param["id_usuario"];
		$query_get = "SELECT 
            COUNT(0)num_valoraciones,
              AVG(valoracion) promedio ,
              SUM(CASE WHEN recomendaria = 1 
              THEN 1 
              ELSE 0 
              END 
              )personas_recomendarian
            FROM 
              valoracion v 
            INNER JOIN 
              tmp_servicios_usuario_$_num s 
            ON 
              v.id_servicio= s.id_servicio
            WHERE 
              s.id_usuario =  $id_usuario";

		$data_complete = $this->db->query($query_get)->result_array();
		$this->create_tmp_servicios_usuario($_num, 0, $param);
		return $data_complete;
	}

	private function get_where_valoracion($param, $tipo)
	{

		$query_get = "";
		switch ($tipo) {
			case 1:
				$query_get = " AND DATE(fecha_registro) 
                          BETWEEN  
                          '" . $param["fecha_inicio"] . "' 
                          AND  
                          '" . $param["fecha_termino"] . "' 
                          ";
				break;

			default:

				break;
		}
		return $query_get;
	}

	function lectura_usuario($param)
	{

		$id_usuario = $param["id_usuario"];
		$query_update =
			"UPDATE valoracion , servicio  
                        SET 
                        valoracion.leido_vendedor = 1
                        WHERE 
                        servicio.id_usuario =  $id_usuario
                        AND
                        servicio.id_servicio =  valoracion.id_servicio";
		return $this->db->query($query_update);
	}

	function get_productos_distinctos_valorados($param)
	{

		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];

		$query_get = "SELECT 
                    DISTINCT(id_servicio) 
                  FROM  valoracion 
                  WHERE 
                    DATE(fecha_registro) 
                  BETWEEN  
                    '" . $fecha_inicio . "' 
                  AND  
                    '" . $fecha_termino . "' ";

		$result = $this->db->query($query_get);
		return $result->result_array();
	}

	function get_numero_valoraciones_servicio($id_servicio)
	{

		$params = [
			"COUNT(0)num_valoraciones",
			"AVG(valoracion) promedio",
			"SUM(CASE WHEN recomendaria = 1 THEN 1 ELSE 0 END )personas_recomendarian"
		];

		$params_where = ["id_servicio" => $id_servicio];
		return $this->get($params, $params_where);
	}
	function get_valoraciones_articulo($param)
	{
		$id_servicio = $param["id_servicio"];
		return $this->get_numero_valoraciones_servicio($id_servicio);
	}
	function get_desglose_valoraciones_periodo($param)
	{

		$where = $this->get_where_valoracion($param, 1);
		$query_get = "SELECT 
                          * 
                        FROM                          
                      valoracion 
                      WHERE 1= 1
                      " . $where . "
                      ORDER BY 
                      valoracion 
                      DESC";
		$result = $this->db->query($query_get);
		$data_complete["data"] = $result->result_array();
		$data_complete["sql"] = $result->result_array();
		return $data_complete;

	}

	private function create_tmp_servicios_usuario($_num, $flag, $param)
	{


		$this->db->query(get_drop("tmp_servicios_usuario_$_num"));
		if ($flag == 1) {
			$id_usuario = $param["id_usuario"];
			$query_create = "CREATE TABLE tmp_servicios_usuario_$_num 
                AS 
                SELECT id_usuario , id_servicio   
                FROM 
                  servicio 
                WHERE 
                  id_usuario =$id_usuario";
			$this->db->query($query_create);
		}
	}

	function utilidad($param)
	{

		$id_valoracion = $param["valoracion"];
		$campo_a_actualizar = " num_no_util = num_no_util + 1 ";
		if ($param["utilidad"] == 1) {
			$campo_a_actualizar = " num_util = num_util + 1 ";
		}

		$query_update = "UPDATE 
            valoracion 
            SET " . $campo_a_actualizar . " WHERE 
            id_valoracion = $id_valoracion LIMIT 1";
		return $this->db->query($query_update);
	}

	private function get_limit($param)
	{

		$page = (isset($param['page']) && !empty($param['page'])) ?
			$param['page'] : 1;
		$per_page = $param["resultados_por_pagina"]; //la cantidad de registros que desea mostrar
		$adjacents = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		return " LIMIT $offset , $per_page ";
	}

	function get_desglose_valoraciones_vendedor($param)
	{

		$_num = mt_rand();
		$this->create_tmp_servicios_usuario($_num, 1, $param);
		$limit = $this->get_limit($param);
		$query_get = "SELECT v.* FROM  valoracion v 
                            INNER JOIN tmp_servicios_usuario_$_num u 
                            ON v.id_servicio =  u.id_servicio
                            ORDER BY valoracion DESC $limit";
		$result = $this->db->query($query_get);
		$data_complete["data"] = $result->result_array();
		$data_complete["sql"] = $result->result_array();
		$this->create_tmp_servicios_usuario($_num, 0, $param);
		return $data_complete;

	}

}