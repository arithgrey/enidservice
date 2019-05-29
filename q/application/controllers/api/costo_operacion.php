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
        if (if_ext($param, "recibo")) {
            $response = $this->costo_operacion_model->get_recibo($param["recibo"]);
        }
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        $num = 0;
        if (if_ext($param, "recibo,costo,tipo")) {


            $num = $this->costo_operacion_model->get_num_type($param["recibo"], $param["tipo"]);
            $status = false;

            if ($num < 1) {

                $params = [
                    "monto" => $param["costo"],
                    "id_recibo" => $param["recibo"],
                    "id_tipo_costo" => $param["tipo"]
                ];

                $status = $this->costo_operacion_model->insert($params);

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
        if (if_ext($param, "id")) {

            $response = $this->costo_operacion_model->q_delete($param["id"]);

        }
        $this->response($response);

    }
    function qsum_GET(){

        $param = $this->get();
        $response = false;
        if (if_ext($param, "in")) {

            $response = $this->costo_operacion_model->get_qsum($param["in"]);

        }
        $this->response($response);

    }
    /*recibos sin costos de operación*/
    function scostos_GET(){

        $param = $this->get();
        $response = false;
        if (if_ext($param, "id_usuario")) {

           $response =  $this->costo_operacion_model->get_recibos_sin_costos($param["id_usuario"]);
        }

        $this->response($response);

    }

}
