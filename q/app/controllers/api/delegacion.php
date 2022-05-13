<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class delegacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("delegacion_model");
        $this->load->library(lib_def());
    }

    function cobertura_GET($param)
    {


        $response = $this->delegacion_model->cobertura();

        $this->response($response);
    }
}
