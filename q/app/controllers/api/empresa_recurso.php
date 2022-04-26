<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class empresa_recurso extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("empresa_recurso_model");
		$this->load->library(lib_def());
	}

	function recursos_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_empresa")) {

			$params_where = ["id_empresa" => $param["id_empresa"] ];
			$response = $this->empresa_recurso_model->get(["idrecurso"], $params_where, 25);
		}
		$this->response($response);
	}
}