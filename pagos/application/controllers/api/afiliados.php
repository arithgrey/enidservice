<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Afiliados extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->helper("proyectos");            
        $this->load->model("afiliadosmodel");     
        $this->load->library("sessionclass");            
    }
    /**/
    function ventas_periodo_dia_GET(){

        $param = $this->get();
        $db_response =  $this->afiliadosmodel->create_ventas_por_periodo($param);
        $this->response($db_response);
    }
    /**/    
    function usuarios_con_ganancias_GET(){

        $param =  $this->get();
        $db_response =  $this->afiliadosmodel->get_usuarios_con_ganancias_comisiones($param);
        $this->response($db_response);
    }
    /**/
    function usuarios_ganancias_GET(){

        $param =  $this->get();
        $data =  $this->afiliadosmodel->get_usuarios_afiliados($param);        
        $a =0;
        foreach ($data as $row){
            $param["id_usuario"] = $row["id_usuario"];
            $data[$a]["ganancias"] = $this->afiliadosmodel->get_ganancias_afiliado($param);
                    
            $info_usuario =  $this->afiliadosmodel->get_info_usuario($param);
            
            foreach ($info_usuario as $row) {
                
                
                $data[$a]["nombre"]  =  $row["nombre"];
                $data[$a]["apellido_paterno"]  =  $row["apellido_paterno"];                
                $data[$a]["apellido_materno"] =  $row["apellido_materno"];  
                $data[$a]["email"] =  $row["email"];  
                
            }            
            $a ++;
        }
        $this->response($data);
    }
    /**/
    function ganancias_afiliado_GET(){

        $param =  $this->get();        
        $monto["ganancias"] =  $this->afiliadosmodel->get_ganancias_afiliado($param);
        $this->response($monto);
    }
    /**/
    function metodos_disponibles_pago_GET(){

        $param=  $this->get();         
        /*
        $forma_pago =  
        $this->afiliadosmodel->get_metodos_de_pago_registrados($param);
            
            $data["forma_pago"] = $forma_pago;          
            
            if (count($forma_pago) > 0 ){
                $data["flag_registro_previo"]=1;
            }
        */        
        $data["flag_registro_previo"]= 0;
        $data["bancos"] = $this->afiliadosmodel->get_bancos();
        $data["usuario"] = $this->afiliadosmodel->get_nombre_usuario($param);
        $this->load->view("afiliado/form_forma_pago" , $data);  
             
        
    }
    /**/
    function cuenta_afiliado_PUT(){

        $param =  $this->put();
        $id_usuario = $this->sessionclass->getidusuario();       
        $param["id_usuario"] = $id_usuario;
        $db_response =  $this->afiliadosmodel->insert_cuenta_pago($param);
        /**/
        $this->response($db_response);

    }

    /**/
}?>