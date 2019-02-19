<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Intento_tipo_entrega_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("intento_tipo_entrega", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function get_pediodo($param)
	{

		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];
		$query_get = "SELECT 
                        COUNT(0)intentos, 
                        SUM(CASE WHEN id_tipo_entrega  = 1 THEN 1 ELSE 0 END )punto_encuentro,
                        SUM(CASE WHEN id_tipo_entrega  = 2 THEN 1 ELSE 0 END )mensajeria,
                        SUM(CASE WHEN id_tipo_entrega  = 3 THEN 1 ELSE 0 END )visita_negocio,
                        id_servicio  
                        FROM intento_tipo_entrega  
                        WHERE DATE(fecha_registro) BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_termino . "' 
                        GROUP BY id_servicio";
		return $this->db->query($query_get)->result_array();

	}
}
	