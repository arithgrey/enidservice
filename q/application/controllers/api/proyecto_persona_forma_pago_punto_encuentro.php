<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Proyecto_persona_forma_pago_punto_encuentro extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->model("proyecto_persona_forma_pago_punto_encuentro_model");
        $this->load->library(lib_def());                      
    }
    function index_POST(){

      
      $param    =  $this->post();
      $response = false;
      if (if_ext($param , "id_recibo,punto_encuentro")) {

        $params = [
          "id_proyecto_persona_forma_pago" =>  $param["id_recibo"],
          "id_punto_encuentro"             => $param["punto_encuentro"]
        ];
        
        $response = 
        $this->proyecto_persona_forma_pago_punto_encuentro_model->insert($params);  
      }
      $this->response($response);
    }

}?>
