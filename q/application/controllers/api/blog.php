<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Blog extends REST_Controller{      
    function __construct(){
        parent::__construct();                  
        $this->load->helper("enid");        
        $this->load->model("blog_model");        
        $this->load->library('sessionclass');                    
    }
    /**/
    function fecha_GET(){        

        $param = $this->get();
        $data["info_blog"]=  $this->blog_model->get_url_blog_fecha($param);
        $this->load->view("blog/principal", $data);
    }
    /**/ 
}?>