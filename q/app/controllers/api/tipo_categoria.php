<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class tipo_categoria extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("tipo_categoria_model");
		$this->load->library(lib_def());
	}

	function index_GET()
	{

		$param = $this->get();
		$this->response($this->tipo_categoria_model->get([],[] , 100));

	}

}