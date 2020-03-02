<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class lista_negra extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("lista_negra_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario,id_motivo")) {

            $params = [
                "id_usuario" => $param['id_usuario'],
                "id_motivo" => $param['id_motivo']

            ];
            $response = $this->lista_negra_model->insert($params, 1);

        }
        $this->response($response);

    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $in = ["id_usuario" => $param['id_usuario']];
            $response = $this->response($this->lista_negra_model->get([], $in, 100));
        }
        $this->response($response);

    }

    function q_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "usuarios")) {

            $response = $this->lista_negra_model->q($param['usuarios']);

        }
        $this->response($response);

    }


}