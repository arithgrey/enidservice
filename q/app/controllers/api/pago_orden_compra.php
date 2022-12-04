<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Pago_orden_compra extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("pago_orden_compra_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $pago_orden_compra = false;
        
        if (fx($param, "id_intento_pago,id_orden_compra")) {
            
            $id_orden_compra  = $param["id_orden_compra"];
            
            $pago_orden_compra = $this->pago_orden_compra_model->get(
                    [],
                    ["id_orden_compra" => $id_orden_compra]
                );
            
            if (!es_data($pago_orden_compra)) {

                $params = [                    
                    "id_intento_pago" => $param["id_intento_pago"],
                    "id_orden_compra" => $param["id_orden_compra"],
                ];
                
                $pago_orden_compra = $this->pago_orden_compra_model->insert($params, 1);
            }
            $this->response($pago_orden_compra );    

        }
        $this->response($pago_orden_compra);
    }
}
