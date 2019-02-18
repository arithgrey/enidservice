<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class funcionalidad extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();         
        $this->load->model("funcionalidad_model");
        $this->load->helper("funcionalidad");
        $this->load->library(lib_def());                      
        $this->id_usuario = $this->principal->get_session("idusuario");
    }
    function add_usuario_PUT(){

        $param              =   $this->put();
        $response           =   false;
        if(if_ext($param , "id_usuario")){
            $funcionalidades    =   $this->funcionalidad_model->get([], [] , 100);
            $response           =   $this->add_conceptos($funcionalidades , $param["id_usuario"]);
        }
        $this->response($response);
    }
    function usuario_GET(){
        
        $param                =  $this->get();
        $funcionalidad        =  $this->funcionalidad_model->get([], [] , 100);        
        $conceptos            =  $this->add_conceptos($funcionalidad , $this->id_usuario);
        //$this->load->view("privacidad/conceptos" , $data);
        $response =  get_terminos($conceptos);
        $this->response($response);
    }  
    function add_conceptos($funcionalidades , $id_usuario){

        $data_complete          =   [];
        $a =0;
        foreach($funcionalidades as $row){

            $data_complete[$a]  =  $row;
            $id_funcionalidad   =  $row["id_funcionalidad"];
            $data_complete[$a]["conceptos"] = $this->get_conceptos_por_funcionalidad_usuario($id_funcionalidad , $id_usuario);
            $a ++;
        }
        return $data_complete;
    }
    function get_conceptos_por_funcionalidad_usuario($id_funcionalidad , $id_usuario){

        $q["id_usuario"]        = $id_usuario;
        $q["id_funcionalidad"]  = $id_funcionalidad;
        $api                    = "privacidad/conceptos_por_funcionalidad_usuario/format/json/";        
        return $this->principal->api( $api , $q);
    }    

}