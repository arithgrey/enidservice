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
    /**/
    function top_semanal_vendedor_GET(){

        $param =  $this->get();
        $response =  $this->productos_model->get_top_semanal_vendedor($param);
        $data_complete = [];
        $a =0;
        foreach ($response as $row){
            $id_servicio =  $row["id_servicio"];
            $nombre =  $this->productos_model->get_nombre_servicio_por_id($id_servicio);
            $data_complete[$a] =  $row;
            $data_complete[$a]["nombre_servicio"] =  $nombre;
            $a ++;
        }
        $this->response($data_complete);

    }
}?>
