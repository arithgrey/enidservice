<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class categoria extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("categoria_model");
		$this->load->library(lib_def());
	}

	function categorias_por_tipo_GET()
	{

		$param = $this->get();
		$response = [];
		if (if_ext($param, "tipo")) {

			$response = $this->categoria_model->get_categorias_por_tipo($param["tipo"]);
		}

		$this->response($response);
	}

	function id_GET()
	{

		$param = $this->get();
		$response = [];
		if (if_ext($param, "id")) {

			$response = $this->categoria_model->q_get([], $param["id"]);
		}
		$this->response($response);

	}

}