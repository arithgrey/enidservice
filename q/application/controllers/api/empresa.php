<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Empresa extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("empresa_model");
		$this->load->library(lib_def());
	}

	function id_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_empresa")) {

			$response = $this->empresa_model->q_get([], $param["id_empresa"]);
		}

		$this->response($response);
	}

}