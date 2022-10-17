<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Usuario_tipo_negocio extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_tipo_negocio_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "tipo_negocio,id_usuario")) {

            $id_usuario = $param["id_usuario"];
            $id_tipo_negocio = $param["tipo_negocio"];
            $params = [
                "id_tipo_negocio" => $id_tipo_negocio,
                "id_usuario" => $id_usuario,
            ];


            if ($this->usuario_tipo_negocio_model->delete(['id_usuario' => $id_usuario], 10)) {
                $response = $this->usuario_tipo_negocio_model->insert($params);
            }

        }
        $this->response($response);
    }

    function usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response =
                $this->usuario_tipo_negocio_model->get_usuario($param["id_usuario"]);
        }
        $this->response($response);
    }

    function quitar_PUT()
    {

        $param = $this->put();
        $response = [];

        if (fx($param, "id_tipo_negocio,id_usuario")) {

            $in = [
                "id_tipo_negocio" => $param['id_tipo_negocio'],
                "id_usuario" => $param['id_usuario'],
            ];
            $set = ["status" => 0];
            $response = $this->usuario_tipo_negocio_model->update($set, $in, 10);
        }
        $this->response($response);

    }


}