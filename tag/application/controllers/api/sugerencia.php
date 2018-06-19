<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class sugerencia extends REST_Controller{
    public $options;      
    function __construct($options=[]){
        parent::__construct();                                              
        $this->load->model("clasificacion_model");      
        $this->load->model('sugerencia_model');
        $this->load->library('restclient');
        $this->load->library('sessionclass');
    }   
    /**/
    function get_option($key){
        return $this->options[$key];
    }    
    /**/
    function set_option($key , $value){
        $this->options[$key] = $value;
    }
    function get_servicios_lista_deseos($param){
        
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result =
        $this->restclient->get("producto/lista_deseos_sugerencias/format/json/", $param);
        $response =  $result->response;                
        return  json_decode($response , true);
    }
    function completa_servicios_sugeridos($servicios, $param){
        
        $in_session     =  $this->sessionclass->is_logged_in();
        $n_servicios    = [];
        $existentes     =  count($servicios);
        if ($existentes>0) {
            $n_servicios = $servicios;
        }
        $limit =  "";
        
        if ($existentes<6 ){
            $limit =  6 - $existentes;
            $param["limit"]         = $limit;
            if ($in_session  !=  false   ) {                                                
                $param["id_usuario"]    = $this->sessionclass->getidusuario();
                $sugerencias            = $this->get_servicios_lista_deseos($param);            
                foreach ($sugerencias as $row) {
                    array_push($n_servicios, $row);
                }   
            }
            else{

                $sugerencias =  $this->busqueda_producto_por_palabra_clave($param);
                foreach ($sugerencias as $row) {
                    array_push($n_servicios, $row);
                }              
            }                     

        }
        return $n_servicios;        
    }
    private function busqueda_producto_por_palabra_clave($q){

        /****************************/
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/qmetakeyword/format/json/" , $q);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function servicio_GET(){

        $param =  $this->get();
        $servicio =  $param["servicio"];
        $clasificaciones =  
        $this->clasificacion_model->get_clasificaciones_por_id_servicio($servicio);

        $servicios =  $this->get_servicios_por_clasificaciones($clasificaciones);
        $servicios = $this->completa_servicios_sugeridos($servicios , $param); 
        
        
        if (count($servicios) >0){

            /*
            $this->set_option("in_session" , 0);
            $servicios_html=  $this->agrega_vistas_servicios($servicios);

            $data["lista_productos"] = $servicios_html;
            $this->load->view("producto/sugerencias" , $data);              
            */
            $data["servicios"] =  $servicios;
            $data["url_request"]=  $this->get_url_request("");
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
    function get_vista_servicio($servicio){

        $servicio =  $servicio;
        $servicio["in_session"] =  $this->get_option("in_session");
        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result=$this->restclient->get("producto/crea_vista_producto/format/html/" , $servicio);
        $response =  $result->response;                
        return $response;
    }
    /**/
    function get_servicios_por_clasificaciones($param){

        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = 
        $this->restclient->get("producto/producto_por_clasificacion/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }

    /**/
}?>
