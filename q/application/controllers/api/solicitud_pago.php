<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Solicitud_pago extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("solicitud_pago_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;

		if (if_ext($param, "monto,email_amigo")) {
			$params = [
				"email_solicitado" => $param["email_amigo"],
				"monto_solicitado" => $param["monto"]

			];
			$id_solicitud = $this->solicitud_pago_model->insert($params, 1);
			if ($id_solicitud > 0) {

				$param["id_solicitud"] = $id_solicitud;
				$param["id_usuario"] = $this->principal->get_session("idusuario");
				$response = $this->registra_solicitud_usuario($param);
			}
		}
		$this->response($response);
	}

	private function registra_solicitud_usuario($q)
	{
		$api = "solicitud_pago_usuario/index";
		return $this->principal->api($api, $q, "json", "POST");
	}
}