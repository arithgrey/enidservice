<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $option;
    function __construct(){        
        parent::__construct();                            
        $this->load->library("principal");        
        $this->load->library('restclient'); 
        $this->load->library('sessionclass');     
    }   
    /**/
    private function get_option($key)
    {
        return $this->option[$key];
    }
    /**/
    private function set_option($key , $val){
        $this->option[$key] =  $val;
    }
    private function crea_data_costo_envio($servicio){        
        $param["flag_envio_gratis"]=  $servicio[0]["flag_envio_gratis"];   
        return $param;
    }
    /**/    
    function index(){

        $param =  $this->input->get();
        if( array_key_exists("num_ciclos", $param)&&ctype_digit($param["num_ciclos"])
            &&$param["num_ciclos"] >0&&array_key_exists("ciclo_facturacion", $param)
            &&$param["num_ciclos"] >0 && $param["num_ciclos"] < 10
            &&ctype_digit($param["plan"])&& $param["plan"] >0){
                $this->crea_orden_compra($param);            
        }else{
            redirect("../../");
        }
    }
    /**/
    private function crea_orden_compra($param){
        /**/
        $data = 
        $this->val_session("Registra tu cuenta en nuestro sistema y recibe asistencia 
            al momento.");         

        $data["meta_keywords"] = '';
        $data["desc_web"] = "Registra tu cuenta  y recibe  asistencia al momento.";
        $data["url_img_post"] = create_url_preview("recomendacion.jpg");
        $num_hist= get_info_usuario( $this->input->get("q"));   
        $num_usuario_referencia= get_info_usuario( $this->input->get("q2"));                    
        $data["q2"]= $num_usuario_referencia;
        
        $data["servicio"]  =  
        $this->principal->resumen_servicio($param);                 

        $data["costo_envio"] ="";
        if($data["servicio"][0]["flag_servicio"] ==  0) {
            $data["costo_envio"] = 
            $this->calcula_costo_envio($this->crea_data_costo_envio($data["servicio"]));
        }   
        /**/
        $data["info_solicitud_extra"] =  $param;         
        $data["clasificaciones_departamentos"] = "";
        $this->principal->crea_historico( 2892 , 0, 0 );                 
        $data["vendedor"] ="";        
        if($data["servicio"][0]["telefono_visible"]==1){
            $data["vendedor"] =
            $this->get_contacto_usuario($data["servicio"][0]["id_usuario"]);            
        }
        $data["js"]     =  ["../js_tema/js/direccion.js" ,  
                            base_url('application/js/principal.js'),
                            base_url('application/js/sha1.js')];
        $this->principal->show_data_page($data, 'home');                          
    }
    /**/
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    function logout(){                      
        $this->sessionclass->logout();      
    }   
    /**/
    function val_session($titulo_dinamico_page ){

        $data["is_mobile"] = ($this->agent->is_mobile() == FALSE)?0:1;
        if( $this->sessionclass->is_logged_in() == 1){

            $menu = $this->sessionclass->generadinamymenu();
            $nombre = $this->sessionclass->getnombre();                                         
            $data['titulo']= $titulo_dinamico_page;              
            $data["menu"] = $menu;              
            $data["nombre"]= $nombre;                                               
            $data["email"]= $this->sessionclass->getemailuser();                                               
            $data["perfilactual"] =  $this->sessionclass->getnameperfilactual();                
            $data["in_session"] = 1;
            $data["no_publics"] =1;
            $data["meta_keywords"] =  "";
            $data["url_img_post"]= "";
            $data["id_usuario"] = $this->sessionclass->getidusuario();                     
            $data["id_empresa"] =  $this->sessionclass->getidempresa();
            $data["desc_web"] =  "";
            return $data;                

        }else{            
            $data['titulo']=$titulo_dinamico_page;              
            $data["in_session"] = 0;     
            $data["id_usuario"] = "";       
            $data["email"]= "";                       
            return $data;
        }   
    }    
    /**/
    private function calcula_costo_envio($param){

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_costo_envio/format/json/", $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    private function get_contacto_usuario($id_usuario){

        $param["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/contacto/format/json/" , $param);        
        $data =  $result->response;
        return json_decode($data , true);  
    }  
}