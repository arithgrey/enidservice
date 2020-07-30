<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tipo_puntuacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("tipo_puntuacion_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {
        $this->response($this->tipo_puntuacion_model->get([], [], 100));
    }

    function tipo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "in_session")) {

            $this->response($this->tipo_puntuacion_model->get(
                [],
                [
                    "tipo" => $param['in_session']
                ], 100)
            );
        }
        $this->response($response);
    }

}