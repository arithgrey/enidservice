<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class nicho extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("nicho_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {

        $response = $this->nicho_model->get([], [], 100);
        $this->response($response);
    }
    function id_GET()
    {
        $param = $this->get();
        
        $response = $this->nicho_model->q_get($param["id"]);

        $this->response($response);
    }

}
