<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Empresa_permiso extends REST_Controller
{
	public $option;

	function __construct()
	{
		parent::__construct();
		$this->load->model("empresa_permiso_model");
		$this->load->library(lib_def());
	}

	function empresa_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_empresa")) {

			$params_where = ["idempresa" => $param["id_empresa"] ];
			$response = $this->empresa_permiso_model->get(["idpermiso"], $params_where, 15, 1);
		}
		$this->response($response);
	}

}