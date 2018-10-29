<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Equipo extends REST_Controller{      
    function __construct(){
        parent::__construct();                                          
        $this->load->model("equipomodel");
        $this->load->model("personamodel");        
        $this->load->library(lib_def());        
    }   
    /**/
    /**/
    function calificacion_cancelacion_compra_PUT(){

        $param      =  $this->put(); 
        $response   =  $this->personamodel->calificacion_cancelacion_compra($param);
        $this->response($response);
    }
    /**/   
    function create_pagination($q){
        
        $api = "producto/paginacion/format/json/"; 
        return  $this->principal->api($api , $q);

    }
    /*
    function get_num_total_usuarios($q){

        $api = "usuario/num_total/format/json/"; 
        return  $this->principal->api( $api , $q);
    }
    */
    /**/
    function get_num_registros_periodo($q){
        $api =  "usuario/num_registros_preriodo/format/json/";
        return $this->principal->api( $api , $q);
    }
    function get_registros_periodo($q){
        $api =  "usuario/registros_preriodo/format/json/";
        return $this->principal->api( $api , $q);
    }
    /**/
    
    /**/
    function usuarios_GET(){
        
        $param                                  =   $this->get();
        $total                                  =   $this->get_num_registros_periodo($param);        
        $per_page                               =   10;
        $param["resultados_por_pagina"]         =   $per_page;
        $data["miembros"]                       =   $this->get_registros_periodo($param);    
        $config_paginacion["page"]              =   get_info_variable($param , "page" );
        $config_paginacion["totales_elementos"] =   $total;
        $config_paginacion["per_page"]          =   $per_page;        
        $config_paginacion["q"]                 =   "";            
        $config_paginacion["q2"]                =   "";                   
        
        $paginacion =  $this->create_pagination($config_paginacion);        
        $data["paginacion"] =  $paginacion;        
        $data["modo_edicion"] = 0;
        $this->load->view("equipo/miembros" , $data);                
    }
    /**/
    
    /*
    */
    /**/
    
    /**/
    
    /**/
    function recurso_POST(){

        $param = $this->post();
        $response = $this->equipomodel->registra_recurso($param);
        $this->response($response);        
    }
    /*Se registra prospecto desde el buzón de noticias*/
    
   
    /****************************************************/        
    
    /**/
    
    /**/
    private function crea_orden_de_compra($q){
        
        $api =  "cobranza/solicitud_proceso_pago"; 
        return  $this->principal->api($api , $q , "json" , "POST");
    }
    /**/
    

}?>