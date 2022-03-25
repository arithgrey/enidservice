<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Material extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("material");
        $this->load->model("material_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function index_POST()
    {
        $param = $this->post();
        $response = false;
        if (fx($param, "nombre")) {
            $params = ["nombre" => $param["nombre"],];
            $response = $this->material_model->insert($params, 1);
        }
        $this->response($response);
    }

    function index_GET()
    {

        $this->response($this->material_model->get([],[],100));

    }


}