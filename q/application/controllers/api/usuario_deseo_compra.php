<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_deseo_compra extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_deseo_compra_model");
        $this->load->library(lib_def());

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "id_servicio")) {

            $ip = $this->input->ip_address();

            $paras = [
                "id_servicio" => $param["id_servicio"],
                "ip" => $ip
            ];
            $response = $this->usuario_deseo_compra_model->insert($paras, 1);

        }
        $this->response($response);


    }

    function total_GET()
    {

        $ip = $this->input->ip_address();
        $response = $this->usuario_deseo_compra_model->total_ip($ip);
        $this->response($response);

    }

    function index_GET()
    {

        $param =  $this->get();
        $response = false;

        if (fx($param, "ip")) {

            $ip =  $param["ip"];
            $lista_deseos = $this->usuario_deseo_compra_model->compra($ip);
            $response = $this->app->add_imgs_servicio($lista_deseos);
        }
        $this->response($response);

    }

    function id_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "id,status")) {

            $response = $this->usuario_deseo_compra_model->q_up("status", 2, $param["id"]);

        }

        $this->response($response);
    }

}