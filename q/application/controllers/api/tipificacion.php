<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class tipificacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("tipificacion_model");
        $this->load->helper("tipificacion");
        $this->load->library(lib_def());
    }

    function index_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "tipo")) {

            $in = ["tipo" => $param["tipo"]];

            $response = $this->tipificacion_model->get([], $in, 100, 'nombre_tipificacion');

        } else {
            $response = $this->tipificacion_model->get([], [], 100);
        }
        if (array_key_exists("v", $param) && $param["v"] == 1) {

            $extra = (array_key_exists("text", $param)) ? d(strong($param["text"]), 1) : "";
            $response =
                $extra . create_select($response,
                    "tipificacion",
                    "tipificacion form-control",
                    "tipificacion",
                    "nombre_tipificacion",
                    "id_tipificacion",
                    0,
                    1,
                    0,
                    "-");
        }

        $this->response($response);

    }

    function recuperacion_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "tipo,id_usuario,recibo")) {

            $in = ["tipo" => $param["tipo"]];
            $response = $this->tipificacion_model->get([], $in, 100, 'nombre_tipificacion');

            $es_form = (prm_def($param, 'v') > 0);
            if ($es_form) {

                $response = form_recuperacion($param, $response);
            }
        }

        $this->response($response);

    }
}