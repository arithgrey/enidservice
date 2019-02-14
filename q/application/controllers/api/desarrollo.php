<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class desarrollo extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->helper("q");                                     
        $this->load->model("desarrollomodel");    	
        $this->load->library(lib_def());     
    }
    function num_tareas_pendientes_GET(){        

        $param      = $this->get();
        $response   =  false;
        if (if_ext($param, "id_departamento,id_usuario")){
            $num_tareas_pendientes  = $this->desarrollomodel->get_tareas_pendientes_usuario($param);

            $response           =  span($num_tareas_pendientes.icon('fa fa-terminal'),  ["class"  =>  'alerta_pendientes_blue']);
            if ($num_tareas_pendientes > 5 ) {
                $response   =  span($num_tareas_pendientes." ".icon('fa fa-terminal'), ["class" =>  'alerta_pendientes']);
            }if($num_tareas_pendientes ==  0  ) {
                $response   = "";
            }

        }
        $this->response($response);
    }
    function global_GET(){

        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param, "fecha_inicio,fecha_termino")){
            $data["info_global"]=  $this->desarrollomodel->get_resumen_desarrollo($param);
            return $this->load->view("desarrollo/global" , $data);
        }
        $this->response($response);
    }
    function global_calidad_GET(){

        $param      =   $this->get();
        $response   =   false;
        if (if_ext($param, "fecha_inicio,fecha_termino")) {
            $data["info_global"] = $this->desarrollomodel->get_comparativa_desarrollo_calidad($param);
            return $this->load->view("desarrollo/global_calidad", $data);
        }
        $this->response($response);
    }
    function comparativas_GET(){

        $param              =   $this->get();
        $response           =   false;
        
        if (if_ext($param,"tiempo")){
            $data["info_global"] =  $this->desarrollomodel->get_comparativa_desarrollo($param);
            return $this->load->view("desarrollo/comparativa" , $data);
        }
        $this->response($response);
    }

}