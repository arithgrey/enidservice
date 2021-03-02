<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class orden_compra extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("orden_compra_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {
        $this->response($this->orden_compra_model->get([], [], 1000));
    }

    function index_POST()
    {
        $response = false;
        $param = $this->post();

        if (fx($param, "id")) {

            $params = ["status" => 1];
            $response = $this->orden_compra_model->insert($params, 1);

            if ($response > 0) {

                $this->producto_orden_compra($response, $param["id"]);
            }


        }
        $this->response($response);
    }

    private function producto_orden_compra($id_orden_compra, $id_producto)
    {

        $q = [
            "id_producto" => $id_producto,
            "id_orden_compra" => $id_orden_compra
        ];
        return $this->app->api("producto_orden_compra/index", $q, "json", "POST");
    }

}