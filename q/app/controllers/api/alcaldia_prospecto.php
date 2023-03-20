<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Alcaldia_prospecto extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("alcaldia_prospecto_model");
		$this->load->library(lib_def());
	}

	function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_alcaldia,alcaldia,ip")) {

            $params =
                [
                    "alcaldia" => $param["alcaldia"],
                    "id_alcaldia" => $param["id_alcaldia"],
                    "ip" => $param["ip"],
                ];
            $response = $this->alcaldia_prospecto_model->insert($params, 1);
        }
        $this->response($response);
    }
    function index_GET()
    {
       
        $this->response(222);
    }

}