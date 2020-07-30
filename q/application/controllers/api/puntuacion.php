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

            $insert = [
                "cantidad" => $param["cantidad"],
                "tipo_puntuacion" => $param["tipo_puntuacion"],
                "id_usuario" => $param["id_usuario"],
                "comentario" => $param["comentario"],
                "id_usuario_califica" => $param["id_usuario_califica"]
            ];
            $response = $this->puntuacion_model->insert($insert, 1);
        }
        $this->response($response);
    }

    function general_GET()
    {
        $response = false;
        $param = $this->get();
        if (fx($param, "id_usuario")) {

            $id_usuario = $param['id_usuario'];
            $response = $this->puntuacion_model->avg($id_usuario);
            $promedio = pr($response, 'promedio');
            $response = (is_null($promedio)) ? 0 : $promedio;

        }
        $this->response($response);
    }
}