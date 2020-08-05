<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Puntuacion extends REST_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->model("puntuacion_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {


        $param = $this->post();
        $response = false;
        if (fx($param, "cantidad,tipo_puntuacion,id_usuario,comentario,id_usuario_califica")) {

            $id_usuario = $param["id_usuario"];
            $insert = [
                "cantidad" => $param["cantidad"],
                "tipo_puntuacion" => $param["tipo_puntuacion"],
                "id_usuario" => $id_usuario,
                "comentario" => $param["comentario"],
                "id_usuario_califica" => $param["id_usuario_califica"]
            ];
            $response = $this->puntuacion_model->insert($insert, 1);
            $this->asigna_puntuacion_usuario($id_usuario);
        }
        $this->response($response);
    }


    private function asigna_puntuacion_usuario($id_usuario)
    {
        
        return $this->app->api("usuario/puntuacion",
            [
                "id_usuario" => $id_usuario,
                "puntuacion" => $this->promedio($id_usuario)
            ], "json", "PUT");
    }

    private function promedio($id_usuario)
    {

        $response = $this->puntuacion_model->avg($id_usuario);
        $promedio = pr($response, 'promedio');
        return (is_null($promedio)) ? 0 : $promedio;

    }

    function general_GET()
    {
        $response = false;
        $param = $this->get();
        if (fx($param, "id_usuario")) {

            $response = $this->promedio($param['id_usuario']);

        }
        $this->response($response);
    }
}