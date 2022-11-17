<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Servicio_sorteo extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("servicio_sorteo_model");
        $this->load->helper("servicio_sorteo");
        $this->load->library(lib_def());
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "id_servicio,boletos,fecha_inicio,fecha_termino")) {

            $response = true;
            $id_servicio = $param["id_servicio"];
            $boletos = $param["boletos"];
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];

            $params = [
                "id_servicio" => $id_servicio,
                "boletos" => $boletos,
                "fecha_registro" => $fecha_inicio,
                "fecha_termino" => $fecha_termino
            ];
        
            $response = $this->servicio_sorteo_model->insert($params, 1);
            $this->servicio_sorteo($id_servicio);
        }
        $this->response($response);

    }
    function index_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_servicio")) {

            $id_servicio = $param["id_servicio"];
            $response = $this->servicio_sorteo_model->get(
                [],
                [
                    "id_servicio" => $id_servicio,
                ],1
            );
            
        }
        $this->response($response);
    }   
    function usuario_boleto_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "boleto,sorteo")) {

            $id_servicio = $param["sorteo"];
            $boleto = $param["boleto"];
            
            $recibo  = $this->servicio_sorteo_model->usuario_boleto($id_servicio, $boleto);
            
            $id_usuario = pr($recibo,"id_usuario");
            $response = $this->app->usuario($id_usuario);            
            

            
        }
        $this->response($response);
    }   

    private function servicio_sorteo($id_servicio)
    {

        return $this->app->api("servicio/sorteo", ["id_servicio"=> $id_servicio], "json", "PUT");
    }   


    
}
