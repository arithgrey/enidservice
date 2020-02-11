<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class costo_operacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("costo_operacion_model");
        $this->load->library(lib_def());
    }

    function recibo_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "recibo")) {
            $response = $this->costo_operacion_model->get_recibo($param["recibo"]);
        }
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        $num = 0;
        if (fx($param, "recibo,costo,tipo")) {


            $num = $this->costo_operacion_model->get_num_type($param["recibo"], $param["tipo"]);
            $status = false;

            $tipo = $param["tipo"];
            $id_recibo = $param["recibo"];
            $monto = $param["costo"];

            if ($num < 1) {

                $params = [
                    "monto" => $monto,
                    "id_recibo" => $id_recibo,
                    "id_tipo_costo" => $tipo
                ];

                $status = $this->costo_operacion_model->insert($params);
                if ($tipo == 12) {

                    $this->notifica_pago_comision_a_vendedor($id_recibo, $monto);

                }

            }

        }

        $response = array(
            "status" => $status,
            "num" => $num
        );

        $this->response($response);

    }

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->costo_operacion_model->q_delete($param["id"]);

        }
        $this->response($response);

    }

    function qsum_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "in")) {

            $response = $this->costo_operacion_model->get_qsum($param["in"]);

        }
        $this->response($response);

    }

    /*recibos sin costos de operación*/
    function scostos_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->costo_operacion_model->get_recibos_sin_costos($param["id_usuario"]);
        }

        $this->response($response);

    }

    private function notifica_pago_comision_a_vendedor($id_recibo, $monto)
    {
        return $this->app->api("recibo/pago_comision/format/json/",
            [
                "id" => $id_recibo, 'monto' => $monto
            ]
            , 'json', 'PUT'
        );
    }


}
