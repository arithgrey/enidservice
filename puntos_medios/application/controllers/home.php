<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->helper("puntoencuentro");
        $this->load->library(lib_def());     
    }
    function index(){
    

        $data                                   =   $this->principal->val_session("");
        $data["meta_keywords"]                  =   "";
        $data["desc_web"]                       =   "";
        $data["url_img_post"]                   =   create_url_preview("");                
        $data["clasificaciones_departamentos"]  =   $this->principal->get_departamentos();
        $param                                  =   $this->input->post();
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

            $param                                  =   $this->input->post();
            $data["tipos_puntos_encuentro"]         =   $this->get_tipos_puntos_encuentro($param);
            $data["punto_encuentro"]                =   0;
            $data                                   =   $this->appendJSCss($data);

            $primer_registro                        =   (get_param_def($param, "recibo" ) == 0 ) ? 1 : 0;
            $data["primer_registro"]                =   $primer_registro;
            if ($primer_registro > 0) {

                $data["servicio"]   =  $param["servicio"]; 
                $data["num_ciclos"] =  $param["num_ciclos"];    

            }else{
                $data["recibo"]         = $param["recibo"];
            }

            $this->load_vistas_punto_encuentro($param , $data);

        }else{

            redirect("../../producto/?producto=".$this->input->get("producto"));
        }        
    }
    private function load_vistas_punto_encuentro($param , $data){
        if(get_param_def($param , "avanzado" , 0 , 1 ) >0
            && get_param_def($param , "punto_encuentro" , 0 , 1 )){

            /*solo tomamos la hora del pedido*/
            $data["punto_encuentro"]        =  $param["punto_encuentro"];
            $this->principal->show_data_page($data, 'horario_entrega');
        }else{
            $this->principal->show_data_page($data, 'home');
        }

    }
    private function get_tipos_puntos_encuentro($q){

        $api =  "tipo_punto_encuentro/index/format/json/";
        return $this->principal->api($api , $q);
    }
    private function appendJSCss($data){
        $data["css"]                            =   [
            "js/bootstrap-datepicker/css/datepicker-custom.css",
            "js/bootstrap-timepicker/css/timepicker.css",
            "puntos_encuentro.css"

        ];


        $data["js"]         =  ["login/sha1.js" ,
            "puntos_medios/principal.js",
            "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
            "js/bootstrap-daterangepicker/moment.min.js",
            "js/bootstrap-daterangepicker/daterangepicker.js",
            "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
            "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
            "js/pickers-init.js",

        ];
        return $data;
    }
    
}