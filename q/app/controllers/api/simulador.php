<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class simulador extends REST_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->helper("simulador_utilidad");
        $this->load->library(lib_def());
    }

    function index_GET()
    {

        $param = $this->get();
        if (fx($param, "precio,costo,venta,entrega,otro,cantidad_venta")) {

            
            $response = simular($param);
        }
        $this->response($response);
    }
}
