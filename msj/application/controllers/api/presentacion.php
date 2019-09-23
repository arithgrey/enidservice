<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Presentacion extends REST_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper("pregunta");
		$this->load->library(lib_def());
	}

	function notificacion_duda_vendedor_GET()
	{

		$param = $this->get();
		$response = get_notificacion_interes_compra($param);
		$this->response($response);
	}

	function notificacion_respuesta_a_cliente_GET()
	{

		$param = $this->get();
		$resposne = get_notificacion_respuesta_cliente($param);
		$this->response($resposne);
	}

	function bienvenida_enid_service_usuario_subscrito_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "q")) {

			$response = get_accesos($param["q"]);

		}
		$this->response($response);
	}
}