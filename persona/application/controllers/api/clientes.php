<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class clientes extends REST_Controller{      
    function __construct(){
        
        parent::__construct();                                              
        $this->load->model("posiblesclientesmodel");
        $this->load->model("clientemodel");
        $this->load->helper("persona");
        $this->load->library('sessionclass');
    }    
    /**/
    function usuario_campo_GET(){
        $param =  $this->get();
        $data =  $this->clientemodel->get_clientes_usuario_campo($param);
        $data["info_recibida"] = $param;
        $this->load->view("clientes/resumen_clientes", $data);  
    }
    /**/
    function posibles_clientes_GET(){
        $param =  $this->get();
        $data =  $this->posiblesclientesmodel->get_posibles_clientes($param);
        $this->load->view("clientes/resumen", $data);        
    }    
    /**/
    function posibles_clientes_validacion_GET(){        
        /**/
        $param =  $this->get();
        $data =  $this->posiblesclientesmodel->get_posibles_clientes($param);
        //$this->load->view("clientes/resumen_validacion", $data);        
        $this->load->view("clientes/resumen", $data);             
    }
    
    /**/    
    function cliente_GET(){
        
        $param =  $this->get();

        if (!isset($param["contactos_efectivos"]) ) {
            $param["contactos_efectivos"]=0;
        }
        
        /************************/    
        if ($param["contactos_efectivos"] ==  1) {                
              $this->carga_contactos_efectivos($param);           
        }else{

            /* AQUÍ SON PUROS POSIBLES CLIENTES */
            if ($param["tipo"] > 7) {                
                
                $param["mensual"]=0;
                $param["servicio"]=1;
                $this->carga_lista_posibles_clientes($param);
            }           
        }    
    }        
    /**/
    function clientes_validacion_GET(){

        $param =  $this->get();
        $data =  $this->clientemodel->get_clientes_enid_service($param);
    
        if(count($data) > 0){
            $data["info_recibida"] = $param;
                $this->load->view("clientes/resumen", $data);     
        }else{            
            $this->response("0 Resultados encontrados");
        }
    
    }
    /***/
    function carga_contactos_efectivos($param){
        $data =  $this->clientemodel->get_clientes_por_tipificacion($param);
        $data["info_recibida"] = $param;
        $this->load->view("clientes/resumen", $data); 
    }
    /**/
    function persona_GET(){

        $param =  $this->get();
        $data["info"] =  $this->posiblesclientesmodel->get_info_persona($param);
        $data["tipificacion"]  =   $this->clientemodel->get_tipificacion();
        $data["info_comentarios"] =  $this->posiblesclientesmodel->get_comentarios_persona($param);
        $this->load->view("persona/info", $data);   
        
        
    }
    /**/
    function convertir_PUT(){

        $param =  $this->put();
        $db_response =  $this->clientemodel->convertir($param);
        $this->response($db_response);        
    }
    
    /**/
}?>
