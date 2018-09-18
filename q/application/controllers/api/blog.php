<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Blog extends REST_Controller{      
    function __construct(){
        parent::__construct();          
        $this->load->helper("q");                                                     
        $this->load->model("blog_model");        
        $this->load->library(lib_def());                    
    }
    /**/
    function fecha_GET(){        

        $param = $this->get();
        $data["info_blog"]=  $this->blog_model->get_url_blog_fecha($param);
        $this->load->view("blog/principal", $data);
    }
    /**/ 
}?>