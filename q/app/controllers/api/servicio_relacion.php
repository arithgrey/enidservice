<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Servicio_relacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("servicio_relacion_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "id_servicio_dominante,id_servicio_relacion")) {

            $response = true;
            $id_servicio_dominante = $param["id_servicio_dominante"];
            $id_servicio_relacion = $param["id_servicio_relacion"];

            $lista = $this->servicio_relacion_model->get(
                [],
                [
                    "id_servicio_dominante" => $id_servicio_dominante,
                    "id_servicio_relacion" => $id_servicio_relacion
                ]
            );

            if (!es_data($lista)){

                $params = [
                    "id_servicio_dominante" => $id_servicio_dominante,
                    "id_servicio_relacion" => $id_servicio_relacion,
                ];
                $response = $this->servicio_relacion_model->insert($params, 1);
            }


        }
        $this->response($response);
    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_servicio")) {

            $id_servicio_dominante = $param["id_servicio"];
            $response = $this->servicio_relacion_model->get(
                [],
                [
                    "id_servicio_dominante" => $id_servicio_dominante,
                    "status" => 1
                ],10
            );

        }
        $this->response($response);
    }

    function index_DELETE()
    {


        $param = $this->delete();
        $response = false;

        if (fx($param, "id_servicio_dominante,id_servicio_relacion")) {

            $id_servicio_dominante = $param["id_servicio_dominante"];
            $id_servicio_relacion = $param["id_servicio_relacion"];

            $response = $this->servicio_relacion_model->delete(
                [
                    "id_servicio_dominante" => $id_servicio_dominante,
                    "id_servicio_relacion" => $id_servicio_relacion
                ]
            );

        }
        $this->response($response);
    }
    function usuario_recibo_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_usuario")) {


            $response = $this->servicio_relacion_model->usuario_recibo($param["id_usuario"]);

        }
        $this->response($response);
    }



}