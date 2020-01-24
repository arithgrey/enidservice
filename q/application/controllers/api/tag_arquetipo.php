<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tag_arquetipo extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("tag_arquetipo_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {
        $this->response($this->tag_arquetipo_model->get());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "tag,tipo,usuario")) {

            $params = [
                'tag' => $param['tag'],
                'id_tipo_tag_arquetipo' => $param['tipo'],
                'id_usuario' => $param['usuario']
            ];

            $response = $this->tag_arquetipo_model->insert($params);
        }

        $this->response($response);

    }

}