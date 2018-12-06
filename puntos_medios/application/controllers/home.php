<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->helper("puntoencuentro");
        $this->load->library(lib_def());     
    }           
    /**/
    function index(){
    
        $param =  $this->input->post();
        $data                                   = 
        $this->principal->val_session("");
        $data["meta_keywords"]                  =   "";
        $data["desc_web"]                       =   "";
        $data["url_img_post"]                   =   create_url_preview("");                
        $data["clasificaciones_departamentos"]  = $this->principal->get_departamentos();
        
        $param                                  =  $this->input->post();        
        $data["proceso_compra"] =1;

        
        
        $method_request = $this->input->server('REQUEST_METHOD');        
        if ( 
            (   $method_request == 'POST' 
                &&  
                get_param_def($param, "servicio" , 0 , 1 ) > 0 
            )

            || 
                        
            (   $method_request == 'POST' 
                &&  
                get_param_def($param, "recibo" , 0 , 1 ) > 0 
            )

        ){            
        


            $data["tipos_puntos_encuentro"]=  $this->get_tipos_puntos_encuentro($param);

            $data["css"] = [
                "../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css",
                "../js_tema/js/bootstrap-timepicker/css/timepicker.css",
                "puntos_encuentro.css"
            
            ];


            $data["js"]         =  ["../js_tema/login/sha1.js" , 
                                    "../js_tema/puntos_medios/principal.js",
                                    "../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                                    "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                                    "../js_tema/js/bootstrap-daterangepicker/moment.min.js",
                                    "../js_tema/js/bootstrap-daterangepicker/daterangepicker.js",
                                    "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                                    "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                                    "../js_tema/js/pickers-init.js",
                                    
            ];

            $primer_registro            =  (get_param_def($param, "recibo" ) == 0 ) ? 1 : 0;
            $data["primer_registro"]    =  $primer_registro;
            if ($primer_registro ==  1) {

                $data["servicio"]   =  $param["servicio"]; 
                $data["num_ciclos"] =  $param["num_ciclos"];    

            }else{                
                $data["recibo"]     = $param["recibo"];
            }            
            $this->principal->show_data_page($data, 'home');  

        }else{
            

            $id_servicio = $this->input->get("producto");
            redirect("../../producto/?producto=".$id_servicio);
        }        
    }
    private function get_tipos_puntos_encuentro($q){

        $api =  "tipo_punto_encuentro/index/format/json/";
        return $this->principal->api($api , $q);
    }
    
}?>