<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Equipo extends REST_Controller{      
    function __construct(){
        parent::__construct();                                          
        $this->load->model("equipomodel");
        $this->load->model("personamodel");
        $this->load->model("validacionmodel");
        $this->load->library("restclient");        
        
    }       
    /**/   
    function create_pagination($q){
        
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/paginacion/format/json/" , $q);                
        $response =  $result->response;
        return json_decode($response, true);            
    }
    /**/
    function miembros_activos_GET(){
        
        $param = $this->get();
        $total =  $this->equipomodel->get_total_usuarios($param);

        $per_page = 10;
        $param["resultados_por_pagina"] = $per_page;
        $data["miembros"] =  $this->equipomodel->get_equipo_enid_service($param);    
        /**/
        $config_paginacion["page"] = get_info_variable($param , "page" );
        $config_paginacion["totales_elementos"] =  $total;
        $config_paginacion["per_page"] = $per_page;        
        $config_paginacion["q"] = "";            
        $config_paginacion["q2"] = "";                   
        /********************/
        $paginacion =  $this->create_pagination($config_paginacion);        
        $data["paginacion"] =  $paginacion;
        $data["modo_edicion"] = 1;
        $this->load->view("equipo/miembros" , $data);                
    }
    /**/
    function usuarios_GET(){
        
        $param = $this->get();
    
        $total =  $this->equipomodel->get_total_usuarios_periodo($param);        
        $per_page = 10;
        $param["resultados_por_pagina"] = $per_page;

        $data["miembros"] =  $this->equipomodel->get_usuarios_periodo($param);            
        $config_paginacion["page"] = get_info_variable($param , "page" );
        $config_paginacion["totales_elementos"] =  $total;
        $config_paginacion["per_page"] = $per_page;        
        $config_paginacion["q"] = "";            
        $config_paginacion["q2"] = "";                   
        
        $paginacion =  $this->create_pagination($config_paginacion);        
        $data["paginacion"] =  $paginacion;        
        $data["modo_edicion"] = 0;
        $this->load->view("equipo/miembros" , $data);                
    }
    /**/
    function miembro_form_GET(){

        $param = $this->get();        
        $db_response  = $this->equipomodel->get_miembro($param);        
        $this->response($db_response);        
    }
    /**/
    function puesto_cargo_GET(){

        $param = $this->get();        
        $data["puestos"]  = $this->equipomodel->get_puesto_cargo($param); 
        $this->load->view("equipo/puesto_cargo" , $data);   
    }
    /**/
    function miembro_POST(){
        /**/
        $param = $this->post();                
        $db_response = $this->equipomodel->insert_miembro($param);
        $this->response($db_response);
    }
    /**/
    function mapa_perfiles_permisos_GET(){
        
        $param = $this->get();
        $data["recursos"] = $this->equipomodel->get_perfiles_permisos($param);
        
        $this->load->view("equipo/tabla_recursos" , $data);
    }   
    /**/
    function modifica_permisos_PUT(){

        $param = $this->put();
        $db_response = $this->equipomodel->update_perfil_permiso($param);
        $this->response($db_response);
        
    }
    /**/
    function recurso_POST(){

        $param = $this->post();
        $db_response = $this->equipomodel->registra_recurso($param);
        $this->response($db_response);        
    }
    /**/
    function prospecto_subscrito_POST(){
    
        $param =  $this->post();     
        /**/   
        $db_response =  $this->equipomodel->registrar_prospecto($param);            


        if($db_response["usuario_existe"] == 0 ){

            $param["id_usuario_enid_service"] =  $db_response["id_usuario"];
            $db_response["extra"] =  $this->equipomodel->crea_persona_subscrito($param);

        }

        $this->response($db_response);    
    }

    function afiliado_POST(){

        /**/
        $param =  $this->post();  
        $db_response =  $this->equipomodel->registrar_afiliado($param);
        /**/
        if($db_response["usuario_existe"] ==  0 && $db_response["usuario_registrado"] == 1){
            
            /*Notifica que se registro con éxitio el usuario*/
            $param["id_usuario"] =  $db_response["id_usuario"];
            $db_response["estado_noficacion_email_afiliado"]= 
                $this->notifica_registro_exitoso($param);

        }
        $this->response($db_response);                
    }
    /*Notifica registro con éxito*/
    function notifica_registro_exitoso($param){    
        $url = "msj/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");          
        $result = $this->restclient->post("emp/solicitud_afiliado/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /****************************************************/        
    function prospecto_POST(){
    
        $param =  $this->post();        
        $db_response =  $this->equipomodel->registrar_prospecto($param);            
        
        if ($db_response["usuario_registrado"] ==  1){                
            
            $param["id_usuario"] = $db_response["id_usuario"];                           
            $param["usuario_nuevo"] =1;                                        
            $orden_de_compra["siguiente"] = $this->crea_orden_de_compra($param);    
            $orden_de_compra["usuario_existe"] =0;
            $this->response($orden_de_compra);           
            
                        
        }else{
            $this->response($db_response);    
        }         
    }    
    
    /**/
    function crea_orden_de_compra($param){
           
        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");          
        $result = $this->restclient->post("cobranza/solicitud_proceso_pago/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function createsession($param){
            
            $id_usuario = $param["id_usuario"];
            $nombre =  "jomm";
            $email =  $param["email"];
            
            $info_empresa =  $this->enidmodel->get_info_empresa(1);            
            $id_perfil =  $this->enidmodel->getperfiluser($id_usuario);             
            $perfildata =  $this->enidmodel->getperfildata($id_usuario); 
            $empresa_permiso =  $this->enidmodel->get_empresa_permiso(1);            
            $empresa_recurso =  $this->enidmodel->get_empresa_recurso(1);
            $data_navegacion =  $this->enidmodel->display_recursos_by_perfiles($id_perfil); 


            $new_session = array(            
                "idusuario" => $id_usuario , 
                "nombre" => $nombre ,
                "email" => $email ,            
                "perfiles" => $id_perfil ,  
                "perfildata" => $perfildata ,
                "idempresa" => 1 ,
                "empresa_permiso" => $empresa_permiso , 
                "empresa_recurso" => $empresa_recurso , 
                "data_navegacion" =>  $data_navegacion ,            
                "info_empresa" =>  $info_empresa ,            
                'logged_in' => TRUE
            );   

            $this->session->set_userdata($new_session);                                          
            return 1;            
    } 
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }

}?>