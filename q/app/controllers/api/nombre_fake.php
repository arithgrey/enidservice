<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class nombre_fake extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("nombre_fake_model");
		$this->load->library(lib_def());
	}

	
    function index_GET()
    {        
        $this->response($this->response($this->nombre_fake_model->get([],[],1000)));
    }

    

}