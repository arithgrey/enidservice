<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Solicitud_pago_usuario extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("solicitud_pago_usuario_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "id_usuario,id_solicitud", 1)) {
			$params = [
				"id_usuario" => $param["id_usuario"],
				"id_solicitud" => $param["id_solicitud"]
			];
			$response = $this->solicitud_pago_usuario_model->insert($params);
		}
		$this->response($response);
	}
}