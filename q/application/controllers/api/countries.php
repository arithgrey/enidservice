<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class countries extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("countries_model");
		$this->load->library(lib_def());
	}

	function pais_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id")) {

			$response = $this->countries_model->get([], ["idCountry" => $param["id"] ]);

		}

		$this->response($response);
	}

}