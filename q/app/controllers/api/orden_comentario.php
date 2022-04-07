<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Orden_comentario extends REST_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->model("orden_comentario_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "orden_compra,comentarios")) {

            $params =
                [
                    "id_orden_compra" => $param["orden_compra"],
                    "comentario" => strip_tags_content($param["comentarios"])
                ];
            $response = $this->orden_comentario_model->insert($params, 1);
        }
        $this->response($response);
    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "orden_compra")) {
            $response = $this->orden_comentario_model->get(
                [], ["id_orden_compra" => $param["orden_compra"]], 10, "fecha_registro");
        }
        $this->response($response);
    }
    function ids_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "ids")) {
                        
            $response = $this->orden_comentario_model->in($param["ids"]);
        }
        $this->response($response);
    }


}