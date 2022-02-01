<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tipo_negocio extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("tipo_negocio_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {

        $this->response($this->tipo_negocio_model->get([], [], 1000,'nombre'));
    }


}