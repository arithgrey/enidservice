<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tipo_punto_encuentro extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("tipo_punto_encuentro_model");
		$this->load->library(lib_def());
	}

	function index_GET()
	{

		$this->response($this->tipo_punto_encuentro_model->get([], ["status" => 1], 10));

	}

}