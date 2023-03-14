<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Referencia extends REST_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->model("referencia_model");
        $this->load->library(lib_def());
    }

    function servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            $id_servicio = $param["id_servicio"];
            $response = $this->referencia_model->get_imagen_servicio_referencia($id_servicio);
        }
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_servicio,id_imagen")) {
            $response = true;
            $id_servicio = $param["id_servicio"];
            $id_imagen = $param["id_imagen"];

            $params = [
                "id_servicio" => $id_servicio,
                "id_imagen" => $id_imagen,
            ];
            $imagenes = $this->referencia_model->get([], $params);

            if (!es_data($imagenes)) {
                $response = $this->referencia_model->insert($params);
            }
        }
        $this->response($response);
    }
    function auto_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_servicio")) {

            $response = true;
            $id_servicio = $param["id_servicio"];

            $imagenes = $this->app->api(
                "imagen_cliente_empresa/servicio",
                [
                    "id_servicio" => $id_servicio
                ]
            );

            $total = count($imagenes) - 1;

            for ($a = 0; $a < 6; $a++) {
                $rand_id_imagen = rand(1, $total);

                $params = [
                    "id_servicio" => $id_servicio,
                    "id_imagen" => $imagenes[$rand_id_imagen]["id_imagen"]

                ];
                $response = $this->referencia_model->insert($params);
            }
        }
        $this->response($response);
    }

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id_servicio,id_imagen")) {
            $id_servicio = $param["id_servicio"];
            $id_imagen = $param["id_imagen"];

            $params = [
                "id_servicio" => $id_servicio,
                "id_imagen" => $id_imagen,
            ];
            $response = $this->referencia_model->delete($params);
        }
        $this->response($response);
    }
}
