<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class proyecto_persona_forma_pago_direccion extends REST_Controller{      
    function __construct(){
        parent::__construct();                            
        $this->load->model("proyecto_persona_forma_pago_direccion_model");        
        $this->load->library(lib_def());                    
    }    
    function index_DELETE(){
    	
    	$param 		=  $this->delete();   
    	$response 	= 
    	$this->proyecto_persona_forma_pago_direccion_model->delete_por_id_recibo($param["id_recibo"]);
    	$this->response($response);    
    }
    function recibo_GET(){

        $param      =   $this->get();
        $response   = false;
        if (if_ext($param , 'id_recibo')) {
            $response   =  
            $this->proyecto_persona_forma_pago_direccion_model->get([], 
            [ "id_proyecto_persona_forma_pago" => $param["id_recibo"]]);            
        }        
        $this->response($response);
    }
    function index_POST(){

        $param      =   $this->post();                
        $response   =   false;        
        
        if (if_ext($param , 'id_recibo, id_direccion') ) {
            $params = [
                "id_proyecto_persona_forma_pago"  => $param["id_recibo"],
                "id_direccion"                    => $param["id_direccion"]
            ];
            $response =  $this->proyecto_persona_forma_pago_direccion->insert($params);    
        }
        $this->response($response);
    }

}?>
