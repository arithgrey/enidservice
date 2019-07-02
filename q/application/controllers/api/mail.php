<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Mail extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("q");
		$this->load->model("email_model");
		$this->load->library(lib_def());
	}

	function reporte_mail_marketing_GET()
	{


		$param = $this->get();
		$response = false;
		if (if_ext($param, 'fecha_inicio,fecha_termino')) {
			$email = $this->email_model->get_correos_enviados_accesos($param);
			$data["email"] = $this->agrega_ventas($email);
			$this->load->view("enid/actividad_mail_marketing/principal", $data);
		} else {
			$this->response($response);
		}

	}

	function agrega_ventas($email)
	{

		$response = [];
		$a = 0;
		foreach ($email as $row) {

			$response[$a] = $row;
			$fecha_registro = $row["fecha_registro"];
			$response[$a]["ventas"] = $this->get_ventas_dia($fecha_registro);
			$response[$a]["solicitudes"] = $this->get_solicitudes_ventas_dia($fecha_registro);

			$a++;
		}
		return $response;
	}

	function get_solicitudes_ventas_dia($fecha)
	{

		$q["fecha"] = $fecha;
		return $this->app->api("ganancias/solicitudes_fecha/format/json/", $q);
	}

	function get_ventas_dia($fecha)
	{
		$q["fecha"] = $fecha;
		return $this->app->api("ganancias/ganancias_fecha/format/json/", $q);
	}

}