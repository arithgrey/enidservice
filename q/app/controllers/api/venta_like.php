<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Venta_like extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("venta_like_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        $id_usuario = $this->id_usuario;

        if (fx($param, "id_recibo")) {

            $id_recibo = $param["id_recibo"];
            $paras = [
                "id_usuario" => $id_usuario,
                "id_recibo" => $id_recibo
            ];

            $registros = $this->venta_like_model->get([], $paras, 10);

            if (es_data($registros)) {

                $response = $this->venta_like_model->delete($paras, 10);
                $response = $this->total_like($id_recibo,0);

            } else {

                $this->venta_like_model->insert($paras, 1);
                $response = $this->total_like($id_recibo,1);
            }



        }
        $this->response($response);

    }

    function total_like($id_recibo, $tipo)
    {
        return $this->app->api("recibo/total_like", ["id" => $id_recibo, "tipo" =>  $tipo], "json", "PUT");
    }


}