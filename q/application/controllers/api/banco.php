<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Banco extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("banco_model");
		$this->load->library(lib_def());
	}

	function index_GET()
	{

		$this->response($this->banco_model->get([], ["status" => 1], 100));

	}

}