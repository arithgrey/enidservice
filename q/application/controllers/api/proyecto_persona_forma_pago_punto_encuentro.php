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

        $in     = ["id_proyecto_persona_forma_pago" =>   $param["id_recibo"] ];            
        if ($this->proyecto_persona_forma_pago_punto_encuentro_model->delete($in , 10)) {

            $params = [
              "id_proyecto_persona_forma_pago" =>   $param["id_recibo"],
              "id_punto_encuentro"             =>   $param["punto_encuentro"]
            ];
          
            $response = 
            $this->proyecto_persona_forma_pago_punto_encuentro_model->insert($params);    
        }
      }
      $this->response($response);
    }
    function punto_encuentro_recibo_GET(){

      $param    =  $this->get();
      $response = false;

      if (if_ext($param , "id_recibo")) {
        $response = $this->get_id_proyecto_persona_forma_pago($param["id_recibo"]);
      }
      $this->response($response);
    }
    
    function complete_GET(){

      $param    =   $this->get();
      $response =   false;

      if (if_ext($param , "id_recibo")) {
        
        $punto_encuentro          = $this->get_id_proyecto_persona_forma_pago($param["id_recibo"]);
        if (count($punto_encuentro) > 0 && $punto_encuentro[0]["id_punto_encuentro"]) {
            
            $id_punto_encuentro   =  $punto_encuentro[0]["id_punto_encuentro"];
            $response             =  $this->get_punto_encuentro($id_punto_encuentro);            
            
        }
      }
      $this->response($response);
    }
    private function get_punto_encuentro($id_recibo){
        $q["id"] =  $id_recibo;
        $api     = "punto_encuentro/id/format/json/"; 
        return $this->principal->api( $api , $q );
    }
    private function get_id_proyecto_persona_forma_pago($id_recibo){
        
        $in   =  ["id_proyecto_persona_forma_pago" => $id_recibo ];                    
        return  $this->proyecto_persona_forma_pago_punto_encuentro_model->get(["id_punto_encuentro"], $in );
    }

}