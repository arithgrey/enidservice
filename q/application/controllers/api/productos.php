<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class productos extends REST_Controller{      
    function __construct(){
        parent::__construct();                                      
        $this->load->helper("enid");   
        $this->load->model("productos_model");
        $this->load->library('sessionclass');
    }   
    /**/
    function metricas_productos_solicitados_GET(){

        $param =  $this->get();
        $data["info_productos"] =  $this->productos_model->get_productos_solicitados($param);
        $this->load->view("producto/principal" , $data);
    }    
    /**/
    function alcance_usuario_GET(){
                
        $param =  $this->get();
        $alcance =  $this->productos_model->get_alcance_productos_usuario($param);
        $this->response($alcance);
    }
    /**/
    function alcance_producto_GET(){

        $param =  $this->get();
        
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        $producto =  $this->productos_model->get_producto_alcance($param);
        $this->response($producto);
        
    }

}?>
