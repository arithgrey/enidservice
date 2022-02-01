<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Producto_orden_compra extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("producto_orden_compra_model");
        $this->load->library(lib_def());
    }


    function index_POST()
    {
        $response = false;
        $param = $this->post();

        if (fx($param, "id_producto,id_orden_compra")) {


            $params = [
                "id_orden_compra" => $param["id_orden_compra"],
                "id_proyecto_persona_forma_pago" => $param["id_producto"]
            ];

            $response = $this->producto_orden_compra_model->insert($params, 1);

        }
        $this->response($response);
    }

    function index_GET()
    {
        $response = false;
        $param = $this->get();

        if (fx($param, "id")) {

            $id = $param["id"];
            $ids = $this->producto_orden_compra_model->q_get([], $id);
            $response = $this->productos($ids);


        }
        $this->response($response);

    }

    function recibo_GET()
    {
        $response = false;
        $param = $this->get();

        if (fx($param, "id")) {

            $id = $param["id"];
            $response = $this->producto_orden_compra_model->get([], ["id_proyecto_persona_forma_pago" => $id]);


        }
        $this->response($response);

    }

    function orden_compra_GET()
    {

        $response = false;
        $param = $this->get();

        if (fx($param, "id")) {

            $id = $param["id"];
            $ids = $this->producto_orden_compra_model->get([], ["id_orden_compra" => $id], 50);
            $response = $this->productos($ids);


        }
        $this->response($response);

    }

    private function productos($producto_orden_compra)
    {

        $response = [];
        if (es_data($producto_orden_compra)) {

            $ids = array_column($producto_orden_compra, "id_proyecto_persona_forma_pago");
            $response = $this->app->api("recibo/ids", ["ids" => $ids]);
        }
        return $response;

    }


}