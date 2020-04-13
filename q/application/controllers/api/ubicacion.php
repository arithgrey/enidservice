<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class ubicacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("ubicacion_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, 'id_recibo,ubicacion,fecha_entrega,horario_entrega')) {

            $id_recibo = $param['id_recibo'];
            $fecha_entrega = $param['fecha_entrega'];
            $horario_entrega = $param['horario_entrega'];
            $params =
                [
                    'ubicacion' => $param['ubicacion'],
                    'id_recibo' => $id_recibo,
                ];
            $response = $this->ubicacion_model->insert($params, 1);
            if ($response > 0) {

                $id = $this->cambio_fecha_entrega($id_recibo, $fecha_entrega, $horario_entrega);
            }


        }
        $this->response($response);
    }

    function index_GET()
    {

        $param = $this->GET();
        $response = false;

        if (fx($param, 'id_recibo')) {

            $id_recibo = $param['id_recibo'];
            $in = [
                'id_recibo' => $id_recibo,
            ];
            $response = $this->ubicacion_model->get([], $in, 1, 'id_ubicacion');

        }
        $this->response($response);
    }

    private function cambio_fecha_entrega($id_recibo, $fecha_entrega, $horario_engrega)
    {
        $q = [
            'fecha_entrega' => $fecha_entrega,
            'horario_entrega' => $horario_engrega,
            'recibo' => $id_recibo,
            'contra_entrega_domicilio' => 1,
            'tipo_entrega' => 2,
            'ubicacion' => 1
        ];
        $this->app->api("recibo/fecha_entrega", $q, "json", "PUT");
    }


}