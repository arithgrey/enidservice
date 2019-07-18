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

    }

    function periodo_GET(){

        $param  = $this->get();
        $response =  [];
        if(fx($param , "fecha_inicio,fecha_termino")){

            $response = $this->ventas_encuentro_model->get_periodo($param);
            $response =  format_linea_tiempo($response);

        }
        $this->response($response);
    }

}
