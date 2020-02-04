<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Ventas_encuentro extends REST_Controller
{


    function __construct()
    {
        parent::__construct();

        $this->load->helper("ventas_encuentro");
        $this->load->model("ventas_encuentro_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function periodo_GET()
    {

        $param = $this->get();
        $response = [];
        $es_usuario = ($this->id_usuario > 0);
        if (fx($param, "fecha_inicio,fecha_termino") && $es_usuario) {

            $param['id_usuario'] = $this->id_usuario;
            $response = $this->ventas_encuentro_model->get_periodo($param);
            $response = format_linea_tiempo($response);

        }
        $this->response($response);
    }

}
