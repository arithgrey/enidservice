<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Portafolio extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->helper("proyectos");
        $this->load->model("empresamodel");                                          
        $this->load->model("proyectomodel");
        $this->load->library("restclient");
        $this->load->library('sessionclass');                                           
    }
    function direccion_principal_usuario_GET(){

        $this->response("ok");
    }
    /**/
    function cp_GET(){        

        $param = $this->get();
        $codigos_postales  =  $this->proyectomodel->get_colonia_delegacion($param);

        $num_resultados = count($codigos_postales);
        $data_complete["resultados"] =$num_resultados;        

        if( $num_resultados > 0 ){
                

                    
                    if (count($codigos_postales) > 1 ) {
                        
                        $select =  create_select_colonia(
                            $codigos_postales , 
                            "asentamiento" , 
                            "asentamiento" ,
                            "asentamiento" ,
                            "asentamiento" ,
                            "asentamiento");
                        $data_complete["colonias"] =$select;
    
                    }else{

                            $select =  create_select(
                            $codigos_postales , 
                            "asentamiento" , 
                            "asentamiento" ,
                            "asentamiento" ,
                            "asentamiento" ,
                            "asentamiento");
                            $data_complete["colonias"] =$select;                    
                    }

                    

                    $municipios =  unique_multidim_array($codigos_postales, "municipio");
                    if (count($municipios) > 1 ) {                   
                                $select_delegacion =  create_select_colonia(
                                $municipios  , 
                                "municipio" , 
                                "municipio" ,
                                "municipio" ,
                                "municipio" ,
                                "municipio");
                                
                    }else{

                                $select_delegacion =  create_select(
                                $municipios  , 
                                "municipio" , 
                                "municipio" ,
                                "municipio" ,
                                "municipio" ,
                                "municipio");
                                
                    }            
                    
                    $data_complete["delegaciones"] = $select_delegacion;




                    $estados =  unique_multidim_array($codigos_postales, "estado");
                    if (count($estados) > 1 ){  
                                $select_estado =  create_select_colonia(
                                $estados , 
                                "estado" , 
                                "estado" ,
                                "estado" ,
                                "estado" ,
                                "id_estado_republica");
                    }else{

                                $select_estado =  create_select(
                                $estados , 
                                "estado" , 
                                "estado" ,
                                "estado" ,
                                "estado" ,
                                "id_estado_republica");
                    }
                    $data_complete["estados"] = $select_estado;





                    $pais =  unique_multidim_array($codigos_postales, "pais");

                    if (count($pais) > 1 ){  

                        $select_pais =  create_select_colonia(
                                $pais, 
                                "pais" , 
                                "pais" ,
                                "pais" ,
                                "pais" ,
                                "id_pais");
                    }else{
                        $select_pais =  create_select(
                                $pais, 
                                "pais" , 
                                "pais" ,
                                "pais" ,
                                "pais" ,
                                "id_pais");
                    }
                    $data_complete["pais"] = $select_pais;
                    
                
        }
        /**/
        $this->response($data_complete);
        
    }

    
    /**/
    function get_pais($id_pais){

        $pais =  $this->proyectomodel->get_pais($id_pais);
        
        $num_resultados_pais = count($pais);
        $data_complete["resultados_pais"] =  $num_resultados_pais;

        
        if($num_resultados_pais > 0 ){

            if ($num_resultados_pais == 1){
                        
                $select =  create_select(
                            $pais , 
                            "countryName" , 
                            "countryName form-comtrol" ,
                            "countryName" ,
                            "countryName" ,
                            "idCountry" );
                $data_complete["pais"] = $select;
                
            
            }else{
            
                $select =  create_select_seleccionar_opcion(
                            $pais , 
                            "countryName" , 
                            "countryName form-comtrol" ,
                            "countryName" ,
                            "countryName" ,
                            "idCountry" );
                    $data_complete["pais"] = $select;                
            }                
        }
        return $data_complete;  
        

    }
    /**/
    function direccion_usuario_GET(){

        $param = $this->get();             
        $param["id_usuario"] = $this->sessionclass->getidusuario();                        
        $domicilio =  $this->proyectomodel->get_domicilio_cliente($param["id_usuario"]);            
        $data["info_envio_direccion"] =  $domicilio;
        $data["param"] =$param;
        switch($param["v"]){
            /*json*/
            case 0:
                $this->response($data);
                break;
            /*Texto*/                        
            case 1:
                if(count($domicilio)>0){
                    $this->load->view("proyecto/domicilio_resumen" , $data);                            
                }else{
                    /*Mandamos el editable para que registre su info*/
                    $this->load->view("proyecto/domicilio" , $data);                            
                }                
                break;                        
            case 2:
                $this->load->view("proyecto/domicilio" , $data);                        
                break;                        
            default:
                $this->load->view("proyecto/domicilio" , $data);                        
                break;
        }        
    }
    /**/
    function direccion_envio_pedido_GET(){

        /**/
        $param = $this->get();             
        $id_usuario =  $this->get_id_usuario($param);
        $data["id_usuario"] = $id_usuario;        

        /**/
        $domicilio = 
        $this->proyectomodel->verifica_direccion_envio_proyecto_persona_forma_pago($param);
        
        if(count($domicilio) == 0 ){                
            $domicilio =  $this->proyectomodel->get_domicilio_cliente($id_usuario);            
        }
        $data["data_saldo_pendiente"] = 
        $this->get_recibo_saldo_pendiente($param["id_recibo"]);

        $data["info_envio_direccion"] =  $domicilio;
        $data["param"] =$param;
        $this->load->view("proyecto/domicilio_envio" , $data);        
        
    }
    /**/
    function get_recibo_saldo_pendiente($id_recibo){               
        $extra = array('id_recibo' =>  $id_recibo);
        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $result = $this->restclient->get("cobranza/saldo_pendiente_recibo/format/json/" , $extra);
        $response =  $result->response;
        return $response;
    }
    /**/
    function direccion_envio_pedido_POST(){

        $param =  $this->post();
        /*Primero la registramos*/
        $id_direccion = $this->proyectomodel->registra_direccion_envio($param);                 
        
        $param["id_direccion"] = $id_direccion;        
        $data_complete["id_direccion"] = $id_direccion;
        if($id_direccion > 0 ){            

            if ($param["direccion_principal"] ==  1 ){
                
                $id_usuario =  $this->get_id_usuario($param);
                $data_complete["registro_direccion_usuario"] =  
                $this->proyectomodel->actualiza_direcciones_usuario($id_usuario ,  $id_direccion);
            }            
        }        
        $data_complete["externo"] =  get_valor_variable($param , "externo");
        $this->response($data_complete);
        
    }
    /**/
    function direccion_usuario_POST(){

        $param =  $this->post();
        /*Primero la registramos*/    
        $id_direccion = $this->proyectomodel->registra_direccion_usuario($param);                 
        
        $param["id_direccion"] = $id_direccion;        
        $data_complete["id_direccion"] = $id_direccion;
        if($id_direccion > 0 ){            
            if ($param["direccion_principal"] ==  1 ){

                $id_usuario =  $this->get_id_usuario($param);
                $data_complete["registro_direccion_usuario"] =  
                $this->proyectomodel->actualiza_direcciones_usuario($id_usuario ,  $id_direccion);
            }            
        }        
        $data_complete["externo"] =  get_valor_variable($param , "externo");
        $this->response($data_complete);        
    }    
    /**/
    function get_id_usuario($param){

        $id_usuario =0;        
        $in_session = $this->sessionclass->is_logged_in();                
        if($in_session == 1){
            $id_usuario =  $this->sessionclass->getidusuario();                        
        }else{
            $id_usuario =  $param["id_usuario"];
        }
        return  $id_usuario;
    }
    /**/
    function proyecto_GET(){

        $param =  $this->get();                
        $data["proyectos"]=   $this->empresamodel->q($param);
        $this->load->view("ventas/principal" , $data);    
    }
    /**/
    function agrega_estados_direcciones_a_pedidos($ordenes_compra){

        $nuevas_ordenes_compra = [];
        $a =0;
        foreach($ordenes_compra as $row){
            /**/
            $nuevas_ordenes_compra[$a] =  $row;
            if ($row["status"] == 6) {
                /*Se verifica que ya esté registrada la dirección*/
                $nuevas_ordenes_compra[$a]["direccion_registrada"] = 0;
            }else{
                /*Se indica que ya está refitrada la direccion*/
                $nuevas_ordenes_compra[$a]["direccion_registrada"] =  1;
            }
            $a ++;
        }
        return $nuevas_ordenes_compra;
    }
    /**/
    private function verifica_direccion_registrada($id_recibo){ 
    }    
    /*Cargamos ordenes de compra hechas por el usuario*/
    function carga_compras_usuario($param){

        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");
        $result = 
        $this->restclient->get("cobranza/resumen_compras_usuario/format/json/", $param);
        $response =  $result->response;
        return json_decode($response , true);
    }       
    /**/
    function get_compras_efectivas($param){

        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $result = $this->restclient->get("tickets/compras_efectivas/format/json/" , 
        $param);
        $response =  $result->response;
        return json_decode($response , true);
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
    function compras_efectivas_GET(){
        
        $param =  $this->get();      
        $id_usuario =  $this->sessionclass->getidusuario();                
        $param["id_usuario"]=  $id_usuario;

        $per_page = 10;
        $param["resultados_por_pagina"] =  $per_page;
        $compras =  $this->get_compras_efectivas($param);                
        $data_complete["compras"] =  $compras;
        $data_complete["paginacion"] ="";
        $data_complete["modalidad"] =  $param["modalidad"];
        if($compras["total"]> 10){            
            
            /*Paginación necesita*/
            $param_paginacion["totales_elementos"] = $compras["total"];
            $param_paginacion["per_page"]=$per_page; 

            $param_paginacion["q"]="";
            $param_paginacion["q2"]="";           
            $data_complete["paginacion"] =$this->create_pagination($param_paginacion);
        }
        //$this->response($data_complete);
        $this->load->view("proyecto/compras_efectivas" , $data_complete);
    }
    /*Aquí cargamos las ordenes de compras del usuario*/
    function proyecto_persona_info_GET(){        
                
        $param =  $this->get();      
        
        $id_usuario =  $this->sessionclass->getidusuario();                
        $param["id_usuario"] = $id_usuario;
        $data_ventas_compras["id_usuario"] = $id_usuario;

        $data_ventas_compras = $this->carga_compras_usuario($param);                                 
        /**/
        $data_ventas_compras["id_usuario"] =  $id_usuario;
        $data_ventas_compras["modalidad"]  = $param["modalidad"];
        /**/    
        $ordenes =0;    
        $compras_anteriores =0;
        $data_ventas_compras["ordenes"] =$ordenes;

            if(isset($data_ventas_compras["data"]) && count($data_ventas_compras["data"]) >0 ){        
                
                $compras_ordenes =  
                $this->agrega_estados_direcciones_a_pedidos($data_ventas_compras["data"]);
                $data_ventas_compras["ordenes"] =  $compras_ordenes;                            
                $ordenes ++;
            }                     
            /*Aquí prm necesario para no enviar toda la data*/
            $prm["modalidad"] =  $param["modalidad"];
            $prm["id_usuario"] =  $id_usuario;
            $data_ventas_compras["en_proceso"] =  $this->en_proceso($prm);            
            /*Actividades que están en proceso por ejemplo envios y pagos pedientes*/            
            if($param["modalidad"] == 1){
                $data_ventas_compras["numero_articulos_en_venta"] = 
                $this->carga_productos_en_venta($param);                    
            }   
            $data_ventas_compras["status"] =  $param["status"];
            $data_ventas_compras["anteriores"] = $this->verifica_anteriores($prm);
            $this->load->view("proyecto/lista_version_cliente" , $data_ventas_compras);
    } 
    /**/
    function solicitudes_GET(){

        $this->response("ok");
    }  
    /**/
    function verifica_anteriores($param){

        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $result = $this->restclient->get("tickets/verifica_anteriores/format/json/" , $param);
        $response =  $result->response;
        return json_decode($response , true);
    }
    /**/
    function en_proceso($param){

        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $url = "pagos/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $result = $this->restclient->get("tickets/en_proceso/format/json/" , $param);
        $response =  $result->response;
        return json_decode($response , true);
    }
    /*
    function proyecto_persona_ventas_GET(){        
                
        $param =  $this->get();                                    
        $param["id_usuario"] =  $this->sessionclass->getidusuario();                        
        $ventas_usuario["id_usuario"]  =  $param["id_usuario"];
        $ventas_usuario = $this->carga_ventas_usuario($param);                        
        $ventas_usuario["tipo"] =  $param["tipo"];
        $ventas_usuario["modalidad_ventas"]  = 1;            

        
        if (count($ventas_usuario["data"])>0){
        
            $ordenes 
            =  
            $this->agrega_estados_direcciones_a_pedidos($ventas_usuario["data"]);            
        
            
            $ventas_usuario["ordenes"] =  $ordenes;
            
            $this->load->view("proyecto/lista_version_cliente" , $ventas_usuario);    
        
        }else{
                       

            $data["info"] =  $ventas_usuario;
            $this->load->view("proyecto/impulsar_ventas" , $data);
        }                
    }   
    Aquí cargamos las ventas del usuario*/     
    /**/
    function carga_productos_en_venta($param){
        
        $url = "tag/index.php/api/";    
        $url_request=  $this->get_url_request($url);
            $this->restclient->set_option('base_url', $url_request);
            $this->restclient->set_option('format', "json");
        $result = 
        $this->restclient->get("producto/productos_en_venta/format/json/" , $param);
        $response =  $result->response;
        return json_decode($response , true);
    }
    /**/
    function q_GET(){
        $param =  $this->get();        
        $data["proyectos"]=   $this->empresamodel->get_portafolio($param);
        $data["config"] =  0;
        $this->load->view("proyecto/principal" , $data);
        
    }
    /**/
    function proyecto_POST(){
        
        $param =  $this->post();
        $db_response  =  $this->empresamodel->inserta_proyecto($param);
        $this->response($db_response);                    
        

    }
    function proyecto_PUT(){
        
        $param =  $this->put();
        $db_response  =  $this->empresamodel->update_proyecto($param);
        $this->response($db_response);                    
    }
    /**/
    function proyectos_GET(){
        
        $param =  $this->get();        
        $data["proyectos"]  =  $this->empresamodel->get_proyectos($param);
        
        $this->load->view("proyecto/list" , $data);                    
    }
    /**/
    function info_proyectos_fecha_GET(){

        /*************/
        $param =  $this->get();         
        $data["proyectos"]  =  $this->empresamodel->get_proyectos_fecha($param);
        $this->load->view("proyecto/list" , $data);                    
        
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function videos_disponibles_GET(){

        $param =  $this->get();
        /**/        
        $data["param"] =  $param;
        $data["id_usuario"] =  $id_usuario =  $this->sessionclass->getidusuario();                        
        $data["videos"]  =  $this->proyectomodel->get_videos($param);
        $this->load->view("videos/videos" , $data);
        
    }
    /**/
}?>