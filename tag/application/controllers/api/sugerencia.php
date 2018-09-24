<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class sugerencia extends REST_Controller{
    public      $options;          
    function __construct($options=[]){
        parent::__construct();                                              
        //$this->load->model("clasificacion_model");              
        $this->options["is_mobile"] = ($this->agent->is_mobile() )?1:0;
        $this->load->library(lib_def());
    }   
    /**/
    function get_option($key){
        return $this->options[$key];
    }    
    /**/
    function set_option($key , $value){
        $this->options[$key] = $value;
    }
    function get_servicios_lista_deseos($q){
        $api  =  "usuario/lista_deseos_sugerencias/format/json/";
        return $this->principal->api(  $api , $q );         
    }

    function completa_servicios_sugeridos($servicios, $param){

        $in_session     =  $this->principal->is_logged_in();
        $n_servicios    = [];
        $existentes     =  count($servicios);
        if ($existentes>0) {
            $n_servicios = $servicios;
        }
        $limit =  "";
        
        if ($existentes<7 ){
            $limit =  7 - $existentes;
            $param["limit"]         = $limit;
            if ($in_session  !=  false   ) {                                                
                $param["id_usuario"]    = $this->principal->get_session("idusuario");
                $sugerencias            = $this->get_servicios_lista_deseos($param);
                            
                foreach ($sugerencias as $row){
                    array_push($n_servicios, $row);
                }   
            }
            else{

                $sugerencias =  $this->busqueda_producto_por_palabra_clave($param);
                if ($sugerencias !=  NULL ) {
                    foreach ($sugerencias as $row) {
                        array_push($n_servicios, $row);
                    }                  
                }
                
            }                     

        }
        return $n_servicios;        
    }
    /*Busqueda de un producto por palabra clave*/
    private function busqueda_producto_por_palabra_clave($q){

        $api  =  "servicio/qmetakeyword/format/json/";
        return $this->principal->api(  $api , $q );             
    }
    function get_clasificaciones_por_id_servicio($q){

        $api  =  "servicio/clasificaciones_por_id_servicio/format/json/";
        return $this->principal->api(  $api , $q );                
    }
    /**/
    function servicio_GET(){

        $param                      =  $this->get();
        $clasificaciones            =  $this->get_clasificaciones_por_id_servicio($param);
        $servicios_clasificaciones  =  $this->get_servicios_por_clasificaciones($clasificaciones);     

        $servicios                  =  
        $this->completa_servicios_sugeridos($servicios_clasificaciones , $param);         

        if (count($servicios) >0){           

            $data["servicios"] =  $servicios;
            $data["url_request"]=  get_url_request("");
            $data["is_mobile"]  = $this->get_option("is_mobile");
            $this->load->view("producto/sugeridos" , $data);
        }else{            
            $data_response["sugerencias"] =0;
            $this->response($data_response);
        } 
        
    }
    /**/
    function agrega_vistas_servicios($servicios){
        
        $nueva_data = [];
        $a =0;
        foreach($servicios as $row){                        
            $nueva_data[$a]= $this->get_vista_servicio($row);
            $a ++;
        }
        return $nueva_data;
    }
    /**/
    function get_vista_servicio($q){
        
        $q["in_session"] =  $this->get_option("in_session");
        $api  =  "servicio/crea_vista_producto/format/html/";
        return $this->principal->api(  $api , $q  , "html");         
    }
    /**/
    function get_servicios_por_clasificaciones($q){          
        
        $param = $q[0];        
        $api  =  "servicio/por_clasificacion/format/json/";
        return $this->principal->api(  $api , $param );                 
    }    
   
}?>
