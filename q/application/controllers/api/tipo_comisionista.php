<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tipo_comisionista extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("tipo_comisionista_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {

        $this->response($this->tipo_comisionista_model->get([], [], 10));

    }

}