<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Empresa extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("empresa_model");
        $this->load->library(lib_def());
    }

    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_empresa")) {

            $response = $this->empresa_model->q_get([], $param["id_empresa"]);
        }

        $this->response($response);
    }

    function orden_productos_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "orden,id_empresa")) {


            $orden = $param["orden"];
            $id_empresa = $param["id_empresa"];
            $response = $this->empresa_model->q_up("orden_producto", $orden, $id_empresa);

        }

        $this->response($response);
    }


}