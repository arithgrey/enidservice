<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class experiencia extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("experiencia_model");
		$this->load->library(lib_def());
	}

	
    function index_GET()
    {
        $response = $this->response($this->experiencia_model->get([],[],100));
        $this->response($response);
    }

    

}