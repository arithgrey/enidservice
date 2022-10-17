<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class propuesta extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("propuesta_model");        
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $response = [];
        $param = $this->post();
        if (fx($param, "id_servicio,propuesta")) {


            $params = [
                'id_servicio' => $param["id_servicio"],
                'propuesta' => $param['propuesta'],
            ];

            $response = $this->propuesta_model->insert($params, 1);
            
        }
        $this->response($response);

    }

    function index_DELETE()
    {

        $response = [];
        $param = $this->delete();
        if (fx($param, "id")) {


            $params = ['id' => $param["id"]];
            $response = $this->propuesta_model->delete($params);
            
        }
        $this->response($response);

    }
    function servicio_GET()
    {

        $response = [];
        $param = $this->get();
        if (fx($param, "id_servicio")) {

            $params = ['id_servicio' => $param["id_servicio"]];
            $response = $this->propuesta_model->get([],$params,100);
            
        }
        $this->response($response);

    }

}