<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class productividad extends REST_Controller{      
    function __construct(){
        parent::__construct();                                      
        $this->load->helper("enid");
       	$this->load->model("productividad_model");
        $this->load->model("productividad_usuario_model");
          $this->load->library('restclient');  
        $this->load->library('sessionclass');
    }   
    /**/
    function accesos_afiliados_GET(){        


        $param =  $this->get();
        $id_usuario =  $this->sessionclass->getidusuario();
        $enlace_afiliado = 'http://'.$_SERVER['HTTP_HOST']."/inicio/nosotros/?q=".$id_usuario;
        $param["url"] =  $enlace_afiliado;
        $param["id_usuario"] =  $id_usuario;

        /****************Accesos*******************/
        $num_accesos_por_afiliado=  $this->productividad_model->get_accesos_afiliado($param);  
        $data["num_accesos"] =  $num_accesos_por_afiliado;

        /**************************contactos*****************/
        $num_contactos_por_afiliado= 
        $this->productividad_model->get_contactos_por_usuario($param);  
        $data["num_contactos"] =  $num_contactos_por_afiliado;
        
        $num_ventas_por_recomendacion = 
        $this->productividad_model->get_ventas_por_usuario($param);  
        $data["num_ventas_por_recomendacion"] =  $num_ventas_por_recomendacion;    
        
        /**/
        $num_efectivo = $this->productividad_model->get_comisiones_por_usuario($param);  
        $data["num_efectivo"] =  $num_efectivo;        
        $this->response($data);
        
    }
    /**/
    function faq_GET(){
        
        $param = $this->get();
        $data["info_preguntas"] = $this->productividad_model->get_faqs($param);
        $this->load->view("productividad/preguntas_frecuentes" , $data);
        
    }
	/**/
    function usuario_GET(){        

        $param = $this->get();
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $data["productividad_usuario"] =  $this->productividad_model->get_productividad_usuario($param);
        $this->load->view("productividad/usuario" , $data);
    }
    /**/ 
    function usuarios_GET(){                
        
        $param = $this->get();        
        $param["id_usuario"] =  $this->sessionclass->getidusuario();        
        $data["productividad_usuario"] =  $this->productividad_model->get_productividad_usuarios($param);
        $this->load->view("productividad/productividad_por_usuario" , $data);
        
    }
    /**/
    function notificaciones_GET(){

        $param = $this->get();  
        $id_usuario =  $this->sessionclass->getidusuario();              
        $param["id_usuario"] =  $id_usuario;

        $db_response["info_notificaciones"] = 
        $this->productividad_usuario_model->get_notificaciones_usuario_perfil($param);        
        /**/
        $id_perfil =  $db_response["info_notificaciones"]["perfil"]; 

        $prm["modalidad"]=1;
        $prm["id_usuario"] =  $id_usuario;                
        
        /**/            
        $mensajes=  $this->carga_mensajes_sin_leer($prm);                    
        $db_response["info_notificaciones"]["mensajes_sin_leer"]=
        $mensajes["modo_vendedor"];
        $db_response["info_notificaciones"]["respuestas"]=$mensajes["modo_cliente"];
        /**/

        /**/

        $db_response["id_usuario"] = $id_usuario;
        /**/    
        switch ($id_perfil) {
            
            case 3:                
                $this->response(get_tareas_pendienetes_usuario($db_response));        
                break;            
            case 4:                
                $this->response(get_tareas_pendienetes_usuario($db_response));
                break;
            case 5:                
                $this->response(get_tareas_pendienetes_usuario_soporte($db_response));
                break;                
            case 6:                                        
                $this->response(get_tareas_pendientes_vendedor($db_response));                
                break;                        
            case 20:                   
                /**/
                $this->response(get_tareas_pendienetes_usuario_cliente($db_response));
               
                
                break;    
            default:
                $this->response("");    
                break;
        }    
        /**/        
    }
    /**/
    function num_clientes_GET(){

        $param =  $this->get();
        $data["clientes"] = $this->productividad_model->get_num_clientes($param);
        $this->load->view("resumen/principal" , $data);
    }
    /**/
    function num_clientes_sistema_GET(){

        $param =  $this->get();
        $data["clientes"] = $this->productividad_model->get_num_clientes_sistema($param);
        $this->load->view("resumen/principal" , $data);   
        
    }
    /**/
    function num_afiliados_GET(){

        $param =  $this->get();
        $data["afiliados"] = $this->productividad_model->get_historia_afiliados($param);
        $this->load->view("resumen/afiliados" , $data);   
    }
    /**/
        /**/
    function contactos_lead_GET(){
    
        $param =  $this->get();
        $data["cotizaciones"]=  $this->productividad_model->get_contactos_lead($param);
        $this->load->view("cotizador/contactos_dia", $data);
    }
    /**/
    function social_media_GET(){

        $param =  $this->get();
        $id_usuario =  $this->sessionclass->getidusuario();
        $param["id_usuario"] =  $id_usuario;
        $data["info"]=  $this->productividad_model->get_productividad_social_media($param);
        $this->load->view("cotizador/social_media", $data);
    }
    /**/
    private function carga_mensajes_sin_leer($param){
                
        $url = "portafolio/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("valoracion/preguntas_sin_leer/format/json/" , $param);
        $info =  $result->response;        
        return json_decode($info, true);
        
    }
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
}?>
