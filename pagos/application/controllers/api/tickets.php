<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Tickets extends REST_Controller{      
    function __construct(){
        parent::__construct();                                                  
        $this->load->library("restclient");             
        $this->load->model("tickets_model");                       
        $this->load->library("sessionclass");            
    } 
    /**/
    function compras_GET(){

        $param =  $this->get();        
        $db_response =  $this->tickets_model->get_compras_tipo_periodo($param);
        $data["compras"]=  $db_response;
        $data["tipo"] =  $param["tipo"];
        $data["status_enid_service"] =  $this->tickets_model->get_status_enid_service($param);
        $this->load->view("ventas/compras" , $data);

    }
    /**/
    function costos_envios_por_recibo_GET(){
        
        $param =  $this->get();
        $id_servicio =  $this->tickets_model->get_id_servicio_por_id_recibo($param);        
        $flag_envio_gratis = $this->tickets_model->get_flag_envio_gratis_por_id_recibo($param);
        $this->response($flag_envio_gratis);
    }
    /**/
    function servicio_recibo_GET(){
        /**/
        $param =  $this->get();
        $db_response =  $this->tickets_model->get_servicio_por_recibo($param);        
        $this->response($db_response );
    }
    /**/
    function en_proceso_GET(){
        /**********************/        
        $param =  $this->get();
        $db_response =  $this->tickets_model->carga_actividad_pendiente($param);        
        $this->response($db_response);
    } 
    /**/
    function verifica_anteriores_GET(){
        /**/
        $param =  $this->get();        
        $db_response = $this->tickets_model->num_compras_efectivas_usuario($param);        
        $this->response($db_response);        
    }
    /**/
    function compras_efectivas_GET(){
        /**/
        /**/
        $param =  $this->get();           
        $data_complete["total"] = 
        $this->tickets_model->total_compras_ventas_efectivas_usuario($param);        
        
        if($data_complete["total"] > 0 ){
            $data_complete["compras"] 
            = $this->tickets_model->compras_ventas_efectivas_usuario($param);
        }
        $this->response($data_complete);  
    }
    /**/
    function cancelar_form_GET(){
        
        $param =  $this->get();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $data["modalidad"] =  $param["modalidad"];
        if($param["modalidad"] ==1){

            $data["recibo"] = $this->get_recibo_por_enviar($param);        
        }else{
            $data["recibo"] = $this->get_recibo_por_pagar($param);        
        }
        $this->load->view("cobranza/form_cancelar_compra" , $data);            
        
    }
    /**/
    function cancelar_PUT(){
        
        $param = $this->put();
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        
        $data_complete["registro"] =0;
        if ($param["modalidad"]== 0){
            $data["recibo"] = $this->get_recibo_por_pagar($param);                   
            if ($data["recibo"]["cuenta_correcta"] ==  1 ){            
                $param["cancela_cliente"] = ($data["recibo"]["id_usuario"] ==  $param["id_usuario"] )? 1:0;                
                /*Si la cuenta pertenece 
                hay que realizar la cancelación del la órden de pago*/
                $data_complete["registro"] = $this->cancelar_orden_compra($param);
            }
        }else{
            $data["recibo"] = $this->get_recibo_por_enviar($param);
            if ($data["recibo"]["cuenta_correcta"] ==  1 ){
                $param["cancela_cliente"] = ($data["recibo"]["id_usuario_venta"] ==  $param["id_usuario"] )? 0:1;
                /*Si la cuenta pertenece hay que realizar la cancelación del la órden de pago*/
                $data_complete["registro"] = $this->cancelar_orden_compra($param);
            }
        }
        $this->response($data_complete);
    }
    /*Se cancela la órden de compra*/
    private function cancelar_orden_compra($param){
        return $this->tickets_model->cancela_orden_compra($param);
    }
    /**/
    private function get_recibo_por_pagar($param){
      
      $url = "pagos/index.php/api/";         
      $url_request=  $this->get_url_request($url);
      $this->restclient->set_option('base_url', $url_request);
      $this->restclient->set_option('format', "json");        
      $result = $this->restclient->get("cobranza/recibo_por_pagar_usuario/format/json/", $param);
      $response =  $result->response;        
      return json_decode($response , true); 
    }
    /**/
    
    private function get_recibo_por_enviar($param){
      
      $url = "pagos/index.php/api/";         
      $url_request=  $this->get_url_request($url);
      $this->restclient->set_option('base_url', $url_request);
      $this->restclient->set_option('format', "json");        
      $result =
      $this->restclient->get("cobranza/recibo_por_enviar_usuario/format/json/", $param);
      $response =  $result->response;        
      return json_decode($response , true); 
    }
    /**/
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function solicitud_amigo_POST(){

        $param =  $this->post();
        $param["id_usuario"] =   $this->sessionclass->getidusuario();
        $db_response =  $this->tickets_model->registra_solicitud_pago_amigo($param);
        $this->response($db_response);        
    }
    /**/
    function movimientos_usuario_GET(){
        
        $param =  $this->get();
        $param["id_usuario"] =   $this->sessionclass->getidusuario();
        $response["solicitud_saldo"] =  $this->tickets_model->get_solicitudes_saldo($param);
        $this->load->view("tickets/solicitudes_saldo" , $response);               
    }
    
}?>