<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tipo_tag_arquetipo extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("tipo_tag_arquetipo_model");
        $this->load->helper("tipo_tag_arquetipo");
        $this->load->library(lib_def());
    }

    function index_GET()
    {
        $this->response($this->tipo_tag_arquetipo_model->get([], [], 100));
    }

    function reventa_GET()
    {

        $param = $this->get();
        if (fx($param, "id_usuario,recibo,v")) {

            $this->response(form_reventa($param));

        }
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

            $response = $this->tipo_tag_arquetipo_model->insert($params);
        }

        $this->response($response);

    }


}