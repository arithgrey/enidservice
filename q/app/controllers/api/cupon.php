<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';

class Cupon extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("cupon_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {


        $this->response($this->cupon_model->get([], [], 100));

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_recibo,valor")) {


            $id_recibo = $param['id_recibo'];
            $response = $this->cupon_model->get([], ["id_recibo" => $id_recibo]);
            if (count($response) < 1) {

                $cupon = [
                        'valor' => $param['valor'],
                        'id_recibo' => $param['id_recibo'],
                        'cupon' => random_string(),
                ];

                if ($this->cupon_model->insert($cupon, 1) > 0) {

                    $response = $this->cupon_model->get([], ["id_recibo" => $id_recibo]);
                }
            }

        }
        $this->response($response);

    }
}