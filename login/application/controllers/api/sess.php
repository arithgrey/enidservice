<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Sess extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library(lib_def());  
    }         
    function start_post(){
        
        
        $param          =   $this->post();            
        $url            =   $this->create_url();            
        if($this->input->is_ajax_request() || 
            ( array_key_exists("t", $param) && $param["t"] == "x=0.,!><!$#" ) 
        ){


            if (if_ext($param ,"email,secret")) {
                $usuario = $this->get_es_usuario($param);
                if (count($usuario) == 1) {

                    $usuario            = $usuario[0];
                    $id_usuario         = $usuario["idusuario"];
                    $nombre             = $usuario["nombre"];
                    $email              = $usuario["email"];
                    $fecha_registro     = $usuario["fecha_registro"];
                    $id_empresa         = $usuario["idempresa"];
                    $response           = $this->crea_session($id_usuario, $nombre, $email, $id_empresa);
                    if (array_key_exists("t", $param) && $param["t"] == "x=0.,!><!$#") {
                        $this->response($response);
                    }
                    $response           = ($response != 0) ? $url : 0;
                    $this->response($response);

                }
                $this->response(0);
            }
        }
        $this->response(false);
        
    }
    function get_es_usuario($q){    
        $api = "usuario/es";
        return $this->principal->api( $api , $q , "json",  "POST");
    }    
    /**/
    function get_perfil_user($id_usuario){

        $q["id_usuario"]    =  $id_usuario;
        $api                =  "usuario_perfil/usuario/format/json/";
        return $this->principal->api( $api , $q);
    }    
    function get_empresa($id_empresa){                        
        $q["id_empresa"]    =  $id_empresa;
        $api                =  "empresa/id/format/json/";
        return $this->principal->api( $api , $q);
    }    
    function get_perfil_data($id_usuario){
        
        $q["id_usuario"]   =  $id_usuario;
        $api                =  "perfiles/data_usuario/format/json/";
        return $this->principal->api( $api , $q);
    }
    function get_empresa_permiso($id_empresa){

        $q["id_empresa"]      =  $id_empresa;
        $api                  =  "empresa_permiso/empresa/format/json/";
        return $this->principal->api( $api , $q);   
    }
    function get_empresa_recursos($id_empresa){
        $q["id_empresa"]    =  $id_empresa;
        $api                =  "empresa_recurso/recursos/format/json/";
        return $this->principal->api( $api , $q);   
    }
    function get_recursos_perfiles($q){        
        
        $q["id_perfil"]        =  $q[0]["idperfil"];
        $api                =  "recurso/navegacion/format/json/";
        return $this->principal->api( $api , $q);      
    }
    /**/
     function crea_session($id_usuario, $nombre , $email ,$id_empresa){                            
        
        $empresa            =  $this->get_empresa($id_empresa);                    
        $perfiles           =  $this->get_perfil_user($id_usuario);
        $perfildata         =  $this->get_perfil_data($id_usuario); 
        $empresa_permiso    =  $this->get_empresa_permiso($id_empresa);
        $empresa_recurso    =  $this->get_empresa_recursos($id_empresa);       


        if (count($perfiles) > 0) {            
            $navegacion                     =  $this->get_recursos_perfiles($perfiles);                     
            if (count($navegacion)> 0) {                
               
                $session = [            
                        "idusuario"         => $id_usuario , 
                        "nombre"            => $nombre ,
                        "email"             => $email ,            
                        "perfiles"          => $perfiles ,  
                        "perfildata"        => $perfildata ,
                        "idempresa"         => $empresa[0]["idempresa"],
                        "empresa_permiso"   => $empresa_permiso , 
                        "empresa_recurso"   => $empresa_recurso , 
                        "data_navegacion"   => $navegacion ,            
                        "info_empresa"      => $empresa ,            
                        'logged_in'         => TRUE
                ];               
                $this->principal->set_userdata($session);
                return $session;

            }
            return 0;        
        } 
        return 0;                                    
    } 
    function servicio_POST(){

        $param =  $this->post();
        $this->principal->set_userdata($param);
        $this->response(1);
    }
    private function create_url(){

        if ($this->principal->get_session("plan") >0 ) {
            $plan               = $this->principal->get_session("plan"); 
            $extension_dominio  = $this->principal->get_session("extension_dominio"); 
            $ciclo_facturacion  = $this->principal->get_session("ciclo_facturacion"); 
            $is_servicio        = $this->principal->get_session("is_servicio"); 
            $q2                 = $this->principal->get_session("q2"); 
            $num_ciclos         = $this->principal->get_session("num_ciclos"); 
            
            $url =  
            "../procesar/?plan=".$plan."&extension_dominio=".$extension_dominio."&ciclo_facturacion=".$ciclo_facturacion."&is_servicio=".$is_servicio."&q2=".$q2."&num_ciclos=".$num_ciclos;    

        }else{
            $url =  "../login";
        }
        return $url;    
    }
}