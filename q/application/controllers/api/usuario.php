<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class usuario extends REST_Controller{      
    function __construct(){
        parent::__construct();  
        $this->load->model('usuario_model');    
        $this->load->library('sessionclass');
    }   
    /**/
    function usuario_por_pregunta_GET(){

        $param = $this->get();                        
        $usuario = $this->usuario_model->get_usuario_por_id_pregunta($param);
        $id_usuario =  $usuario[0]["id_usuario"];     
        $prm["id_usuario"] = $id_usuario;        
        $this->response($this->usuario_model->get_usuario_cliente($prm));        
    }
    /**/
    function usuario_servicio_GET(){
        $param = $this->get();                        
        $usuario = $this->usuario_model->get_usuario_por_servicio($param);
        $id_usuario =  $usuario[0]["id_usuario"]; 
        /***/
        $prm["id_usuario"] = $id_usuario;        
        $this->response($this->usuario_model->get_usuario_cliente($prm));        
    }
    /**/
    function q_GET(){

        $param = $this->get();                        
        $usuario= $this->usuario_model->get_usuario_cliente($param);
        $this->response($usuario);
    }
    /**/
    function contacto_GET(){

        $param = $this->get();                        
        $usuario= $this->usuario_model->get_contacto_usuario($param);
        $this->response($usuario);
    }
    /**/
    function usuario_cobranza_GET(){

        $param = $this->get();                        
        $usuario = $this->usuario_model->get_usuario_cobranza($param);
        $this->response($usuario);        
    }   
    /**/
    function usuario_existencia_GET(){
        /*verificamos si es que existe un usuario por algún criterio*/
        $param =  $this->get(); 
        $db_response =$this->usuario_model->existencia_q($param);
        $this->response($db_response);
    } 
    /**/
    function nombre_usuario_GET(){
        
        $param = $this->get();
        $db_response =$this->usuario_model->nombre_usuario($param);
        $this->response($db_response);
    }
    /**/
    function id_usuario_por_id_servicio_GET(){
        $param = $this->get();
        $db_response = $this->usuario_model->get_usuario_por_servicio($param);
        $this->response($db_response);
    }    
    /**/
    function entregas_en_casa_GET(){
        $param = $this->get();
        $db_response=  $this->usuario_model->get_tipo_entregas($param);
        $this->response($db_response);        
    }
    /**/
    
}?>
