<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Blog extends REST_Controller{      
    function __construct(){
        parent::__construct();
        $this->load->helper("blog");
        $this->load->model("blog_model");        
        $this->load->library(lib_def());                    
    }
    function fecha_GET(){        

        $param              =   $this->get();
        $response           = false;
        if (if_ext($param, "fecha")){

            $f                  =   ["id_faq", "titulo" ,"id_categoria"  , "fecha_registro"];
            $data               =   $this->blog_model->get($f, [ "DATE(fecha_registro) " => $param["fecha"]] , 1000);
            $response           =   create_table_blog($data);

        }
        $this->response($response);
    }
}