<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class codigo_postal extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();         
        $this->load->helper("codigo_postal");
        $this->load->model("codigo_postal_model");
        $this->load->library(lib_def());                      
        $this->id_usuario = $this->principal->get_session("idusuario");                 
    }
    function direccion_usuario_POST(){

        $param      =  $this->post();
        /*Primero la registramos*/    
        $response   = false;
        $param["id_codigo_postal"] = 
        $this->codigo_postal_model->get_id_codigo_postal_por_patron($param);
        $id_direccion              =  $this->crea_direccion($param);                    
        if ($id_direccion > 0 && $this->id_usuario > 0  ) {
            $response    =  
            $this->registra_direccion_usuario($this->id_usuario , $id_direccion);
            
        }
        $this->response($response);
        
    }  
    function direccion_envio_pedido_POST(){

        $param                          =   $this->post();                        
        $id_direccion                   =   $this->registra_direccion_envio($param);        
        if ($id_direccion == 0) {
            $this->response(-1);
        }
        
        $param["id_direccion"]          =   $id_direccion;        
        $data_complete["id_direccion"]  =   $id_direccion;

        if($id_direccion > 0 ){                
            if($param["direccion_principal"] ==  1 ){                
                $id_usuario    =  $this->get_id_usuario($param);
                $data_complete["registro_direccion_usuario"] =  
                $this->set_direcciones_usuario($id_usuario ,$id_direccion);
            }            
        }        
        $data_complete["externo"] =  get_info_variable($param , "externo");
        $this->response($data_complete);        
    }

    function registra_direccion_envio($param){

        
        $param["id_codigo_postal"] =  $this->codigo_postal_model->get_id_codigo_postal_por_patron($param);
        if ($param["id_codigo_postal"] > 0 ){

            $param["id_direccion"]          =  $this->crea_direccion($param);
            $this->elimina_direccion_previa_envio($param);    
            $this->agrega_direccion_a_compra($param);
            return  $param["id_direccion"];    
        }   
        return 0; 
    }
    /**/
    function id_por_patron_GET(){

        $param      = $this->get(); 
        $response   = $this->codigo_postal_model->get_id_codigo_postal_por_patron($param); 
        $this->response($response);
    }
    function colonia_delegacion_GET(){
        $param      = $this->get(); 
        $response   = $this->codigo_postal_model->get_colonia_delegacion($param); 
        $this->response($response);   
    }
    function cp_GET(){        

        $param              = $this->get();        
        $codigos_postales   =  $this->get_colonia_delegacion($param);        
        $num_resultados     = count($codigos_postales);
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
        $this->response($data_complete);        
    }
    function get_colonia_delegacion($q){
        $api    =  "codigo_postal/colonia_delegacion/format/json";
        return $this->principal->api( $api, $q);
    }
    /**/
    function get_pais_por_id($q)
    {
        $api = "contries/pais/format/json";
        return $this->principal->api( $api , $q);
    }
    function get_data_direccion($q){

        $api    =  "direccion/data_direccion/format/json";
        return  $this->principal->api(  $api, $q);
    }
    function get_id_codigo_postal_por_patron($q){

        $api    = "codigo_postal/id_por_patron/format/json";
        return  $this->principal->api( $api , $q );
    }
    function crea_direccion($q){

        $api    = "direccion/index";
        return  $this->principal->api( $api , $q , "json", "POST");
    }    
    private function elimina_direccion_previa_envio($q){

        $api    = "proyecto_persona_forma_pago_direccion/index";
        return  $this->principal->api($api , $q , "json", "DELETE" );
    }    
    function agrega_direccion_a_compra($q){

        $api    =  "proyecto_persona_forma_pago_direccion/index";
        return $this->principal->api( $api, $q, "json" , "POST");
    }
    function get_id_usuario($param){        

        $id_usuario = ($this->principal->is_logged_in() == 1) ?  $this->id_usuario :  $param["id_usuario"];
        return  $id_usuario;
    }
    function set_direcciones_usuario($id_usuario ,$id_direccion){

        $q["id_usuario"]        = $id_usuario;
        $q["id_direccion"]      = $id_direccion;        
        $api                    =  "usuario_direccion/index";
        return $this->principal->api( $api, $q, "json" , "PUT");
    }
    /**/
    function registra_direccion_usuario($id_usuario , $id_direccion){

        $q["id_usuario"]        =   $id_usuario;
        $q["id_direccion"]      =   $id_direccion;        
        $api                    =   "usuario_direccion/index";
        return $this->principal->api( $api, $q, "json" , "POST");
    }
    function set_direccion_principal($id_usuario , $id_direccion){
        
        $q["id_usuario"]        =   $id_usuario;
        $q["id_direccion"]      =   $id_direccion;        
        $api                    =   "usuario_direccion/principal";
        return $this->principal->api( $api, $q, "json" , "PUT");   
    }
}?>
