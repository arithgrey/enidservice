<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Notificaciones extends REST_Controller{      
    function __construct(){
        parent::__construct();                                              
        $this->load->model("notificamodel");        
    }   
    /**/
    function accesos_sitios_web_GET(){

        $param =  $this->get();
        $num_accesos_dia = $this->notificamodel->get_accesos_creados_por_usuario($param);
        $data["num_accesos_dia"] =  $num_accesos_dia;
        
        $meta = 400;        
        $num_accesos_resta = $meta - $num_accesos_dia;
        
        $num_accesos_resta_text =  "";
        
        if ($num_accesos_resta > 0 ){            
            $num_accesos_resta_text =  "<span class='alerta_notificacion_fail'>
                                        <i class='fa fa-minus-circle'></i>
                                        ".$num_accesos_resta."
                                        </span>";
        }

        $data["meta_cubierta"] =  $num_accesos_resta_text;
        $this->response($data);

    }
	/**/
    function email_enviados_GET(){
        
        $param =  $this->get();
        $num_correos_enviados = $this->notificamodel->get_email_enviados_usuario_dia($param);
        $data["num_correos_enviados"] =  $num_correos_enviados;
        
        $meta = 1000;
        $data["meta"] =  $meta;
        $num_correos_resta = $meta - $num_correos_enviados;
        
        $num_correos_resta_text =  "";
        
        if ($num_correos_resta > 0 ){            
            $num_correos_resta_text =  "<span class='alerta_notificacion_fail'>
                                        <i class='fa fa-minus-circle'></i>
                                        ".$num_correos_resta."
                                        </span>";
        }else if($num_correos_resta == 0 ){
            $num_correos_resta_text =  "<span class='alerta_notificacion_ok'>
                                            <i class='fa fa-check'>
                                            </i>
                                        </span>";
        }else{
            $num_correos_resta_text =  "<span class='alerta_notificacion_ok'>
                                            <i class='fa fa-plus-circle' ></i>
                                        ". abs($num_correos_resta) ."
                                        </span>";
        }


        $data["meta_cubierta"] =  $num_correos_resta_text;
        
        $this->response($data);
    }
    /**/    
    function preguntas_recibidas_GET(){
        
        $this->response("ok");
    }
    /**/
}?>
