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
    /**/
    function servicio_GET(){

        $param =  $this->get();
        $clasificaciones =  
        $this->clasificacion_model->get_clasificaciones_por_id_servicio($param["servicio"]);
        $servicios =  $this->get_servicios_por_clasificaciones($clasificaciones);    
       
        if (count($servicios) >0){

            $this->set_option("in_session" , 0);
            $servicios_html=  $this->agrega_vistas_servicios($servicios);
            $data["lista_productos"] = $servicios_html;
            $this->load->view("producto/sugerencias" , $data);    
          
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
        $result = $this->restclient->get("producto/crea_vista_producto/format/html/" , $servicio);
        $response =  $result->response;                
        return $response;
    }
    /**/
    function get_servicios_por_clasificaciones($param){

        $url = "tag/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("producto/producto_por_clasificacion/format/json/" , $param);
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
