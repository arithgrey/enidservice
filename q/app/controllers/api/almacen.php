<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class almacen extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("almacen_model");
        $this->load->library(lib_def());
    }
    function index_GET()
    {

        $almacenes = $this->almacen_model->get([], [], 20);
        $this->response($almacenes);
    }
}
