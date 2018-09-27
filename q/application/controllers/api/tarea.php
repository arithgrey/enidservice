<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Tarea extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();                          
        $this->load->model("tareasmodel");
        $this->load->library(lib_def());     
        $this->id_usuario = $this->principal->get_session("idusuario");
    }
    /**/    
    function estado_PUT(){
        $param =  $this->put();
        $response = $this->tareasmodel->update_estado_tarea($param);
        $this->response($response);
    }
    /**/
    function index_POST(){
        
        $param               =  $this->post();
        $param["id_usuario"] =  $this->principal->get_session("idusuario");
        $response            =  false ;

        if ($param["id_usuario"] > 0 ) {

            $params = [
                "descripcion"       =>  $param["tarea"] ,
                "id_ticket"         =>  $param["id_ticket"] ,
                "usuario_registro"  =>  $param["id_usuario"]
            ];
            $response            =  $this->tareasmodel->insert_tarea($param);
            if ($response == true) {
                $q = $this->valida_tareas_pendientes($param);
                $this->set_stado_ticket($q);
            }    
        }
        $this->response($response);        
    }
    /**/
    function set_stado_ticket($q){
        $api =  "ticket/estado";
        return $this->principal->api( $api , $q , "json", "PUT");
    }
    /**/    
    function valida_tareas_pendientes($param){

        $num_pendientes =  $this->tareasmodel->get_pendientes_ticket($param);
        $nuevo_estado_ticket ="";
        $status = 1;
        $nuevo_estado_ticket ="cerrado";        
        if ($num_pendientes != 0 ) {        
            $status = 0;
            $nuevo_estado_ticket ="abierto";
        }
        $q    = [
                    "status"        =>  $status  , 
                    "id_ticket"     =>  $id_ticket,
                    "num_tareas"    =>  $num_pendientes
                ]; 
        return $q;
    }  
    function buzon_POST(){

        $param =  $this->post();       
        $params = [
            "descripcion"       =>  $param["tarea"] ,
            "id_ticket"         =>  $param["id_ticket"] ,
            "usuario_registro"  =>  $param["id_usuario"]
        ];
        $response = $this->tareasmodel->insert($params);
        $this->response($response);        
    }
    function ticket_GET(){

        $param      =   $this->get();       
        $response   =   [];        
        if (if_ext($param , "id_ticket")) {            

            $this->response($this->tareasmodel->get_tareas_ticket($param));               
        }
        $this->response($response);
    }
    function tareas_ticket_num_GET(){

        $param      =   $this->get();       
        $response   =   $this->tareasmodel->get_tareas_ticket_num($param);        
        $this->response($response);           
    }
    
}?>