<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Intento_compra extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("intento_compra_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "tipo,recibo")) {
			$params = [
				"id_recibo" => $param["recibo"],
				"id_forma_pago" => $param["tipo"]
			];

			$response = $this->intento_compra_model->insert($params, 1);
		}
		$this->response($response);
	}
}