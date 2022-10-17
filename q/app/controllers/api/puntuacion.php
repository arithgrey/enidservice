<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Puntuacion extends REST_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->model("puntuacion_model");
        $this->load->helper("puntuacion");
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
            if (prm_def($param, 'id_servicio')) {
                $insert["id_servicio"] = $param["id_servicio"];
            }
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
        $promedio = (!is_null($response)) ? pr($response, 'promedio') : 0;
        return (is_null($promedio)) ? 0 : $promedio;

    }

    private function encuestas($id_usuario)
    {

        return $this->puntuacion_model->get(
            ["COUNT(0)total"],
            ["id_usuario" => $id_usuario])[0]["total"];

    }

    function general_GET()
    {
        $response = false;
        $param = $this->get();
        if (fx($param, "id_usuario")) {

            $id_usuario = $param['id_usuario'];
            $response = [
                'promedio' => $this->promedio($id_usuario),
                'encuestas' => $this->encuestas($id_usuario)
            ];

        }
        $this->response($response);
    }

    function recibos_GET()
    {
        $response = false;
        $param = $this->get();
        if (fx($param, "fecha_inicio,fecha_termino,v")) {

            $response = $this->puntuacion_model->promedio_recibos(
                $param['fecha_inicio'],
                $param['fecha_termino']
            );

            if ($param['v'] > 0) {

                $response = recibos_evaluaciones($response);
            }

        }
        $this->response($response);
    }
}