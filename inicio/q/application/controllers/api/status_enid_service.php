<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Status_enid_service extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("status_enid_service_model");
		$this->load->library(lib_def());
	}

	function servicio_GET()
	{


		$params = ["id_estatus_enid_service", "nombre", "text_cliente", "text_vendedor"];
		$response = $this->status_enid_service_model->get($params, ["pago" => 1], 10);
		$this->response($response);

	}

	function nombre_GET($param)
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_estatus")) {
			$response = $this->status_enid_service_model->q_get(["nombre"], $param["id_estatus"])[0]["nombre"];
		}
		$this->response($response);
	}

	function index_GET()
	{
		$this->response($this->status_enid_service_model->get([], [], 100));
	}

}