<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class desarrollo extends REST_Controller{      
    function __construct(){
        parent::__construct();         
        $this->load->helper("q");                                     
        $this->load->model("desarrollomodel");    	
        $this->load->library(lib_def());     
    }
	/**/
    function num_tareas_pendientes_GET(){        

        $param = $this->get();        
        $num_tareas_pendientes = $this->desarrollomodel->get_tareas_pendientes_usuario($param);

        $new_response = "<span class='alerta_pendientes_blue'>".$num_tareas_pendientes."
                            icon('fa fa-terminal'>
                            </i>
                        </span>";
        if ($num_tareas_pendientes > 5 ) {
            
            $new_response = "<span class='alerta_pendientes'>".$num_tareas_pendientes."
                                icon('fa fa-terminal'>
                                </i>
                             </span>";
        }if($num_tareas_pendientes ==  0  ) {
            $new_response = "";
        }

        $this->response($new_response);
    }
    /**/
    function global_GET(){

        $param =  $this->get();
        $data["info_global"]=  $this->desarrollomodel->get_resumen_desarrollo($param);
        $this->load->view("desarrollo/global" , $data);
    }
    /**/
    function global_calidad_GET(){

        $param =  $this->get();
        $data["info_global"]=  $this->desarrollomodel->get_comparativa_desarrollo_calidad($param);
        $this->load->view("desarrollo/global_calidad" , $data);   
    }
    /**/
    function comparativas_GET(){

        $param =  $this->get();
        $data["info_global"]=  $this->desarrollomodel->get_comparativa_desarrollo($param);
        $this->load->view("desarrollo/comparativa" , $data);   
    }

}?>
