<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Valoracion extends REST_Controller{      
    function __construct(){
        parent::__construct(); 
        $this->load->model("valoracion_model");    
        $this->load->helper("proyectos");            
        $this->load->library('restclient');                            
        $this->load->library("sessionclass");
    }
    /**/
    function usuario_GET(){

        $param =  $this->get();
        $valoraciones = $this->valoracion_model->get_valoraciones_usuario($param);    
        if(count($valoraciones) > 0){
            $info_valoraciones =  crea_resumen_valoracion($valoraciones , 1);
            $this->response($info_valoraciones);
        }else{
            $this->response("");    
        }
        
    }
    /**/
    function articulo_GET(){
            
        $param =  $this->get();
        $valoraciones = $this->valoracion_model->get_valoraciones_articulo($param);    
        $data["servicio"] =$param["servicio"];
        
        if($valoraciones[0]["num_valoraciones"] > 0){
            /*Cargamos los comentarios*/
            $data["comentarios"]=  $this->valoracion_model->get_valoraciones($param);    
            $data["numero_valoraciones"] = $valoraciones;
            $data["respuesta_valorada"]=  $param["respuesta_valorada"];
            $this->load->view("valoraciones/articulo", $data);        
        }else{
            $this->load->view("valoraciones/se_el_primero", $data);        
        }
        
    }
    /**/
    function valoracion_form_GET(){

        $param =  $this->get();              
        $data["id_servicio"] =  $param["id_servicio"];
        $data["nombre_servicio"]=  $this->get_nombre_servicio($param);
        $this->load->view("valoraciones/form_servicio" , $data);

    }
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function get_nombre_servicio($param){
        
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/nombre_servicio/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function nueva_POST(){
        
        /**/
        $param = $this->post();        
        $db_response =  $this->valoracion_model->registrar($param);             
        $data_complete["id_servicio"] =  $param["id_servicio"];        
        /**/
        $prm["key"] =  "email";
        $prm["value"] =  $param["email"];        
        $data_complete["existencia_usuario"] =  $this->valida_existencia_usuario($prm);        
        $this->response($data_complete);        
    }
    /**/
    function valida_existencia_usuario($param){
        
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/usuario_existencia/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function utilidad_PUT(){
        
        $param = $this->put();
        $db_response = $this->valoracion_model->utilidad($param);
        $this->response($db_response);
    }
    /**/
    function pregunta_consumudor_form_GET(){
        /**/     
        $param =  $this->get();              
        $data["id_servicio"] =  $param["id_servicio"];
        $data["nombre_servicio"]=  $this->get_nombre_servicio($param);                
        $data["in_session"]=  $param["in_session"];
        $data["id_usuario"] = $param["id_usuario"];
        $this->load->view("valoraciones/pregunta_consumudor" , $data);
    }
    /**/
    function pregunta_POST(){

        $param =  $this->post();
        $db_response =  $this->valoracion_model->registra_pregunta($param);
        $this->response($db_response);
    }
    /**/
    function preguntas_GET(){

        $param =  $this->get();
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $nombre_usuario_actual =  $this->sessionclass->getnombre();
        $data_complete["modalidad"] = $param["modalidad"];
        /*Consulta preguntas hechas con proposito de compras*/
        if($param["modalidad"] ==  1){             
            /**/
            $preguntas =  $this->valoracion_model->get_preguntas_realizadas_a_vendedor($param); 
            $data_complete["preguntas"] = $preguntas;            
        }else{
            /***************************************/
            $preguntas =  $this->valoracion_model->get_preguntas_realizadas($param);
            $data_complete["preguntas"] = $preguntas;                                    
        }   
        $this->load->view("valoraciones/preguntas" ,  $data_complete);                 
    }
    /**/
    function respuesta_pregunta_GET(){
        
        $param =  $this->get();
        $data_complete["data_send"] = $param;  
        /*Pasamos a visto la pregunta*/
        $this->valoracion_model->set_visto_pregunta($param);
        $data_complete["respuestas"] = $this->valoracion_model->get_respuestas_pregunta($param);
        $this->load->view("valoraciones/form_respuesta" , $data_complete);        
    }
    /**/
    function respuesta_pregunta_POST(){        
        $param =  $this->post();
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $db_response =  $this->valoracion_model->registra_respuesta($param);
        $this->response($db_response);
    }
    /**/ 
}?>