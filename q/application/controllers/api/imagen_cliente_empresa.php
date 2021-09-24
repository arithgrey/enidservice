<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Imagen_cliente_empresa extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("imagen_cliente_empresa_model");
        $this->load->library(lib_def());
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_imagen,id_empresa")) {

            $params = [
                "id_imagen" => $param["id_imagen"],
                "id_empresa" => $param["id_empresa"]
            ];

            $response = $this->imagen_cliente_empresa_model->insert($params);
        }
        $this->response($response);
    }

    function clientes_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_empresa")) {

            $id_empresa = $param["id_empresa"];
            $response = $this->imagen_cliente_empresa_model->clientes($id_empresa);
        }
        $this->response($response);
    }



}