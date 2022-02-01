<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tipo_entrega extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("tipo_entrega_model");
		$this->load->library(lib_def());
	}

	function index_GET()
	{
		$this->response($this->tipo_entrega_model->get([], [], 1000));
	}

}