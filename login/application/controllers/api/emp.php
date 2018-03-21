<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Emp extends REST_Controller{      
    function __construct(){
        parent::__construct();          
        //$this->load->helper("empresa");       
        $this->load->model("empresamodel");                      
        $this->load->library('principal');                    
        $this->load->library('sessionclass');                            
    }   
    /**/    
    
    function prospectos_enid_post(){

        /**/
        $param =  $this->post();        
        $param["pw"] =  $this->valida_password($param);
            

        $param["privacidad_condiciones"] =  1;
        $data["estatus_empresa"] = 0;  

        $data_user = $this->empresamodel->consulta_user_existente($param);        
        $empresa_exist = $this->empresamodel->consulta_empresa_existencia($param);        
        $num_user =  $data_user["num_user"];

       
        if ($num_user >  0) {
            $data["status_user_registrado"]= 1;
        }

        if ($empresa_exist > 0){            
            $data["estatus_registro_empresa"] =  0;
        }

        if($num_user == 0  && $empresa_exist == 0 ){
            $data["estatus_empresa"] = $db_response = $this->empresamodel->create_account($param);                       
        }

        if($data["estatus_empresa"] ==  true){
            $this->principal->isuserexistrecord($param["mail"], $param["pw"]);            
        }        
        $this->response($data);
        
        
    }
    function nueva_POST(){
        
        $response =  "";
        $user_exist = 1; 
        $empresa_exist =1;

        $param = $this->post();    
        $empresa_exist =  $this->empresamodel->get_num_empresa_name($param); 
        $response_emp  =  $this->create_msj_registro($empresa_exist, "org" , "La organización que intenta registrar ya se encuentra registrada."); 

        if($empresa_exist == 0){
            /*Validamos ahora pero en user*/
            $user_exist =  $this->empresamodel->get_num_users($param);
            $response_emp  =  $this->create_msj_registro($user_exist, "user" ,  "El usuario que intenta registrar ya se encuentra registrado."); 
        }       
        /**/
        if($user_exist >  0 || $empresa_exist > 0 ){                    
            $this->response($response_emp);    
        }else{            
            $data["estatus"]  =  $this->empresamodel->create_account($param);
            $this->response($data);
        }
        
    }
    /**/
    function create_msj_registro($valor , $campo ,  $msj ){

        $data["estatus"] =  0;
        $data["campo"] = $campo;  
        $data["msj"] =  $msj; 
        if($valor == 0 ){
            $data["estatus"] =  1;
            $data["campo"] = "";  

        }
        return $data;

    }
   
    /*Validar session para modificar datos*/
    function validate_user_sesssion(){
        if( $this->sessionclass->is_logged_in() == 1) {                        

            }else{
                        /*Terminamos la session*/
                $this->sessionclass->logout();
        }   
    }
    /**/
    function valida_password($param){

        if ($param["password"] ==  $param["password2"]){
            return $param["password"];
        }
    }


}?>