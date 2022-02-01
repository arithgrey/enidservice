<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_servicio_propuesta extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_servicio_propuesta_model");
        $this->load->library(lib_def());

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, 'id_usuario,id_servicio')) {

            $id_usuario = $param["id_usuario"];
            $id_servicio = $param["id_servicio"];
            $response = $this->usuario_servicio_propuesta_model->insert(
                [
                    "id_usuario" => $id_usuario,
                    "id_servicio" => $id_servicio,
                ],
                1
            );


        }
        $this->response($response);
    }

    function ids_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, 'id_usuario')) {

            $id_usuario = $param["id_usuario"];
            $ids = $param["ids"];


            if (es_data($ids)){

                foreach ($ids as $row){

                    $response = $this->usuario_servicio_propuesta_model->insert(
                        [
                            "id_usuario" => $id_usuario,
                            "id_servicio" => $row,
                        ],
                        1
                    );
                }
            }



        }
        $this->response($response);
    }

    function intentos_GET(){

        $response = $this->usuario_servicio_propuesta_model->intentos();
        $this->response($response);

    }

}