<?php defined('BASEPATH') OR exit('No direct script access allowed');

class productividad_usuario_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function accesos_inicio_termino($fecha_inicio, $fecha_termino){

		$query_get = _text_("SELECT count(0)total from acceso
		WHERE 
		id_servicio  > 0 
		AND 
		DATE(fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'");

		return $this->db->query($query_get)->result_array()[0]["total"];

	}
	function usuarios_deseo_compra_it($fecha_inicio, $fecha_termino){

		$query_get = _text_("SELECT count(0) total FROM usuario_deseo_compra
		WHERE 
		DATE(fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'");

		return $this->db->query($query_get)->result_array()[0]["total"];

	}

	function usuarios_deseo_compra_vendedor_it($fecha_inicio, $fecha_termino){

		$query_get = _text_("SELECT count(0) total FROM usuario_deseo
		WHERE 
		DATE(fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'");

		return $this->db->query($query_get)->result_array()[0]["total"];

	}
	function recibos_it($fecha_inicio, $fecha_termino){

		$query_get = _text_("SELECT count(0) total FROM proyecto_persona_forma_pagos
		WHERE 
		DATE(fecha_registro ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'");

		return $this->db->query($query_get)->result_array()[0]["total"];
	}
	function ventas_it($fecha_inicio, $fecha_termino){

		$query_get = _text_("SELECT count(0) total FROM proyecto_persona_forma_pagos
		WHERE 
			 se_cancela < 1 
            AND cancela_cliente < 1  
            AND saldo_cubierto > 0 
			AND
		DATE(fecha_entrega ) BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "'");

		return $this->db->query($query_get)->result_array()[0]["total"];
	}


}