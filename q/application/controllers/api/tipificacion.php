<?php defined('BASEPATH') or exit('No direct script access allowed');
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

    function index_POST()
    {

        $response = [];
        $param = $this->post();
        if (fx($param, "tipificacion,tipo")) {


            $params = [
                'nombre_tipificacion' => $param["tipificacion"],
                'tipo' => $param['tipo'],
            ];
            if (prm_def($param, "status") > 0) {
                $params["status"] = $param["status"];
            }
            $response = $this->tipificacion_model->insert($params, 1);
            $response = $this->cancela_recibo($response, $param);


        }
        $this->response($response);

    }

    function index_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "tipo")) {

            $in = ["tipo" => $param["tipo"], "status" => 1];

            $response = $this->tipificacion_model->get([], $in, 100, 'nombre_tipificacion');

        } else {

            $response = $this->tipificacion_model->get([], [], 100);
        }
        if (array_key_exists("v", $param) && $param["v"] == 1) {

            $extra = (array_key_exists("text", $param)) ? d(strong($param["text"]), 1) : "";
            $select = create_select(
                $response,
                "tipificacion",
                "tipificacion form-control",
                "tipificacion",
                "nombre_tipificacion",
                "id_tipificacion",
                0,
                1,
                0,
                "-",
                [],
                1
            );

            $response = _text($extra, $select);
        }

        $this->response($response);

    }

    function recuperacion_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "tipo,id_usuario,recibo,dias")) {

            $in = ["tipo" => $param["tipo"]];
            $response = $this->tipificacion_model->get([], $in, 100, 'nombre_tipificacion');

            $es_form = (prm_def($param, 'v') > 0);
            if ($es_form) {

                $response = form_recuperacion($param, $response);
            }
        }

        $this->response($response);

    }

    private function cancela_recibo($id_tipificacion, $param)
    {

        $id_recibo = prm_def($param, 'recibo');
        $cancelacion = prm_def($param, 'cancelacion');
        $tipificar = ($id_tipificacion > 0 && $id_recibo > 0 && $cancelacion > 0);
        $response = $id_recibo;

        if ($tipificar) {

            $q = [
                "recibo" => $id_recibo,
                "status" => 10,
                "tipificacion" => $id_tipificacion,
                "cancelacion" => $cancelacion
            ];
            $response = $this->app->api("recibo/status", $q, "json", "PUT");

        }
        $this->response($response);

    }
}