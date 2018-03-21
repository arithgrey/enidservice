<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Afiliacion extends REST_Controller{      
    public $options; 
    function __construct($options=[]){
        parent::__construct();                  
        $this->load->helper("enid");    
        $this->load->helper("afiliados");             
        $this->load->model("afiliacion_model");  
        $this->load->model("afiliados_model");  
        $this->load->library('restclient');                 
        $this->load->library('sessionclass');                    
    }
    /**/    
    /**/
    function set_option($key , $value){
        $this->options[$key] = $value;        
    }
    /**/
    function get_option($key){
        return $this->options[$key];
    }
    /**/
    function afiliados_GET(){
        $param =  $this->get();
        $data["afiliados"]=  $this->afiliados_model->get_pendiente_asesoria($param);
        $this->load->view("afiliados/lista" , $data);
    }
    /**/
    function afiliados_productividad_GET(){

        $param =  $this->get();        
        $usuarios =  $this->afiliados_model->get_usuarios_productivos($param);    
        $this->set_option("usuarios_afiliados" , $usuarios);        
        /**/
        $this->agrega_ganancias_afiliado();
        /**/        
        $data["info_usuarios"] =   $this->get_option("usuarios_afiliados");
        $this->load->view("afiliados/productividad"  , $data);
        
    }    
    /**/
    function agrega_ganancias_afiliado(){

        $usuarios =  $this->get_option("usuarios_afiliados");
        $x = 0;
        $afiliados =[];
        foreach($usuarios as $row){
                            
            $id_usuario = $row["id_usuario"];                
            $afiliados[$x] = $row; 
            $ganancia =  $this->carga_ganancias_pendientes_por_pagar($id_usuario);            
            $monto_a_pagar =  $ganancia["ganancias"];
            $monto_a_pagar =  ($monto_a_pagar > 0) ? $monto_a_pagar : 0;
            $afiliados[$x]["comision_venta"] =  $monto_a_pagar;
            
            $x ++;

        }
        $this->set_option("usuarios_afiliados" , $afiliados);
    }    
    /**/
    function carga_ganancias_pendientes_por_pagar($id_usuario){
        
        $q["id_usuario"] =  $id_usuario;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("afiliados/ganancias_afiliado/format/json/" , $q);
        $info =  $result->response;        
        return json_decode($info, true);
        
    }
    /**/
    function get_ventas_afiliados($param){

        
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("afiliados/ventas_periodo_dia" , $param);        
        $precio_publico =  $result->response;
        return json_decode($precio_publico , true);
    }
    /**/
    function get_accesos($param){
        
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("accesos/afiliados_periodo" , $param);        
        $precio_publico =  $result->response;
        return json_decode($precio_publico , true);
    }
    /**/
    function metricas_GET(){        

        $param = $this->get();        
        $data["info_afiliaciones"] = $this->afiliacion_model->repo_afiliaciones($param);
        $data["ventas"] =  $this->get_ventas_afiliados($param);  
        $data["accesos"] =  $this->get_accesos($param);        
        $this->load->view("afiliados/principal" , $data);

    }
    /**/ 
    function reporte_global_GET(){

        $param = $this->get();        
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $data  = $this->afiliados_model->get_reporte_global($param);
        $this->response($data);        
    }    
    function ventas_GET(){

        $param=  $this->get(); 
        $param["id_usuario"] = $this->sessionclass->getidusuario();        
        $info_ventas =  $this->afiliados_model->get_resumen_ventas($param);          
        $data["info_ventas"]  =  $this->agrega_precio_publico($info_ventas);
        $this->load->view("afiliados/ventas_afiliado" , $data);                        
        
    }
    /**/
    function agrega_precio_publico($data){

        $nueva_data = [];
        $z =0;
        foreach($data as $row){            
            
            $costo =  floatval($row["costo"]);
            $nueva_data[$z] =  $row;
            $nueva_data[$z]["precio_publico"] =  $this->get_precio_venta($costo);
            
    
            $z ++;            

        }
        /**/
        return  $nueva_data;    
    }
    /***/
    function get_precio_venta($costo){

        $q["costo"] =  $costo;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "xml");        
        $result = $this->restclient->get("cobranza/calcula_precio_producto" , $q);        
        $response =  $result->response;
        return json_decode($response , true);
            
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }

}?>