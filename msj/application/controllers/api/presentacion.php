<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Presentacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper("pregunta");
        $this->load->library(lib_def());
    }

    function notificacion_duda_vendedor_GET()
    {

        $param = $this->get();
        $response =get_notificacion_interes_compra($param);
        $this->response($response);
    }

    function notificacion_respuesta_a_cliente_GET()
    {

        $param = $this->get();
        $data["cliente"] = $param;
        $this->load->view("ventas/notificacion_respuesta", $data);
    }

    function bienvenida_enid_service_usuario_subscrito_GET()
    {

        $param["info"] = $this->get();
        $this->load->view("registro/subscrito", $param);
    }
}