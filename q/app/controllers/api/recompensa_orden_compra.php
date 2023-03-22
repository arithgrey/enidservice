<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Recompensa_orden_compra extends REST_Controller
{
    public $option;
    private $id_usuario;
    function __construct()
    {
        parent::__construct();
        $this->load->model("recompensa_orden_compra_model");        
        $this->load->library(lib_def());    

    }

    function index_POST(){

        $param = $this->post();
        $response = false;
        if (fx($param, "id_recompensa,id_orden_compra")) {
    

                $response = $this->recompensa_orden_compra_model->insert(
                    [
                        "id_recompensa" =>  $id_recompensa,
                        "id_orden_compra" => $id_orden_compra
                    ]
                );
            

        }
        $this->response($response);   
    }
    function ids_POST(){

        $param = $this->post();
        $id_orden_compra = $param["id_orden_compra"];
        $ids = $param["ids"];
            
        foreach($ids as $row){
            if ($row > 0) {
            
                $this->recompensa_orden_compra_model->insert(
                    [
                        "id_recompensa" =>  $row,
                        "id_orden_compra" => $id_orden_compra
                    ]
                );    
            }
            
        }
            

    }
    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {


            $response = $this->recompensa_orden_compra_model->id($param["id"]);
        }
        
        $this->response($response);
    }

    
}