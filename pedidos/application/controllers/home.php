<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{

    function __construct(){        
        parent::__construct();                            

        $this->load->library(lib_def());     
    }           
    /**/
    function index(){
    
        $param                                  =  $this->input->get();
        $data                                   =   $this->principal->val_session("");
        $data["meta_keywords"]                  =   "";
        $data["desc_web"]                       =   "";
        $data["url_img_post"]                   =   create_url_preview("");                
        $data["clasificaciones_departamentos"]  =   $this->principal->get_departamentos();
        

       
            
            

            $data["css"] = [
                "../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css",
                "../js_tema/js/bootstrap-timepicker/css/timepicker.css",
                "pedidos.css"
            
            ];


            $data["js"]         =  ["../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                                    "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                                    "../js_tema/js/bootstrap-daterangepicker/moment.min.js",
                                    "../js_tema/js/bootstrap-daterangepicker/daterangepicker.js",
                                    "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                                    "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                                    "../js_tema/js/pickers-init.js",
                                    "../js_tema/pedidos/principal.js"
                                    
            ];
            
            $this->principal->show_data_page($data, 'home');  

             
    }
    
}