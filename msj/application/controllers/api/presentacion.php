<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Presentacion extends REST_Controller{      
    function __construct(){
        parent::__construct();                                                          
    }    
    /**/
    function notificacion_duda_vendedor_GET(){

        $param = $this->get();
        $data["vendedor"] = $param;        
        $this->load->view("ventas/notificacion_pregunta" , $data);
    }
    

}?>