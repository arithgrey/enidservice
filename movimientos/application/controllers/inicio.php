<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	function __construct(){        
        parent::__construct();            			
	    $this->load->library("principal");
        $this->load->library('restclient');        
        $this->load->helper('transferencia');        
	    $this->load->library('sessionclass');	     
    }   
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }           
    /**/
    function index(){

        /**/
		$data = $this->val_session("Enid Service");        	            

        if($data["in_session"] == 1) {
            
            /**/
            $action =  valida_valor_variable($this->input->get("action"));   
            $id_usuario=  $this->sessionclass->getidusuario();    
            switch ($action){
                case 0:
                    /*General*/
                    
                    $saldos=  $this->get_saldo_usuario($id_usuario);
                    $data["saldo_disponible"] = $saldos;
                    $data["clasificaciones_departamentos"] = "";
                    $this->principal->show_data_page( $data , 'empresas_enid');
                    break;
                /**/
                case 1:                
                    /*Despliega las cuentas disponibles del usuario*/                    
                    $prm["id_usuario"] = $id_usuario;
                    $data["clasificaciones_departamentos"] = "";
                    $data["bancos"] = $this->get_bancos_disponibles($prm);
                    $data["usuario"] = $this->get_usuario($prm);
                    

                    $data["banca"] = valida_valor_variable($this->input->get("tarjeta"));   

                    $data["error"] =0;                    
                    $prm= $this->input->get(); 

                    if(isset($prm["error"]) && $prm["error"] != null && $prm["error"] == 1){
                        $data["error"] =1;
                    }
                    $this->principal->show_data_page( $data , 'metodos_disponibles');
                    
                    
                    break;
                /**/
                case 2:          
                    /*Despliega las cuentas disponibles del usuario*/
                    $data["clasificaciones_departamentos"] = "";                    
                    $saldos=  $this->get_saldo_usuario($id_usuario);
                    $data["saldo_disponible"] = $saldos;
                    $cuentas_bancarias =  $this->get_cuentas_usuario($id_usuario , 0);
                    
                    $data["cuentas_gravadas"] = 0;
                    if(count($cuentas_bancarias)>0) {
                       $data["cuentas_gravadas"] = 1;
                       $data["cuentas_bancarias"] = $cuentas_bancarias;
                    }
                    $this->principal->show_data_page( $data , 'metodos_transferencia');
                    
                break;

                case 3:
                    /*Despliega cuentas asociadas al momento*/
                    $data["clasificaciones_departamentos"] = "";                    
                    $data["cuentas_bancarias"] =  $this->get_cuentas_usuario($id_usuario , 0);
                    $data["tarjetas"] =  $this->get_cuentas_usuario($id_usuario , 1);

                    $this->principal->show_data_page( $data , 'cuentas_asociadas');
                    break;
                

                case 4:          
                    /**/
                    if($this->input->post()){                        

                        $prm = $this->input->post();  
                        $prm["id_usuario"] = $id_usuario;
                        $registro = $this->agregar_cuenta_bancaria($prm);
                        
                        if($registro["registro_cuenta"] ==  1){
                            redirect("../../movimientos/?q=transfer&action=3");    
                        }else{                            
                            if($prm["tipo"] == 0) {
                                redirect("../../movimientos/?q=transfer&action=1&error=1");
                            }else{
                                redirect("../../movimientos/?q=transfer&action=1&tarjeta=1&error=1");
                            }
                        }
                        
                        
                    }else{
                        redirect("../../movimientos");
                    }
                    /**/
                    break;

                case 5:
                    
                    /*Se muestran los datos de la cuenta*/


                    break;    
                default:

                

                break;
            }

            
                                        
        }else{
            redirect("../");
        }
        
    }    	
   /**/
    private function val_session($titulo_dinamico_page ){        
        if ( $this->sessionclass->is_logged_in() == 1) {                                                            
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
                $data["info_empresa"] =  $this->sessionclass->get_info_empresa();                     
                $data["desc_web"] =  "";
                return $data;
        }else{            
            redirect(url_log_out());
        }   
    }  
    /**/
    private function get_saldo_usuario($id_usuario){

        $q["id_usuario"] =  $id_usuario;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->post("saldos/usuario/format/json/" , $q);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    private function carga_metodos_pago_usuario($param){

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = 
        $this->restclient->get("cuentas/metodos_disponibles_pago/",$param);
        $response =  $result->response;        
        return $response;           
    }
    /**/
    private function get_cuentas_usuario($id_usuario ,$tipo){
        /**/
        $q["id_usuario"] =  $id_usuario;
        $q["tipo"] = $tipo;
        $q["metodos_disponibles"]=1;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->post("cuentas/usuario/format/json/" , $q);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    private function get_bancos_disponibles($param){

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cuentas/bancos_disponibles/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    private function get_usuario($param){

        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/q/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/
    private function agregar_cuenta_bancaria($param){

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->post("cuentas/bancaria/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);
    }    
    /**/  
}