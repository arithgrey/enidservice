<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    public $option;
    function __construct(){        
        parent::__construct();                            
        $this->load->library(lib_def());           
    }           
    /**/
    function index(){

        $data                   =   $this->principal->val_session("");    
        $data["meta_keywords"]  =   '';
        $data["desc_web"]       =   "";                
        $data["url_img_post"]   =   create_url_preview("");        
        $data["f_pago"]         =   1;                   
        $data["num_recibo"]     =   $this->input->get("recibo");                
        $num_usuario            =   get_info_usuario( $this->input->get("q2"));        
        $num_servicio           =   get_info_usuario( $this->input->get("q3"));        

        $clasificaciones_departamentos =   $this->principal->get_departamentos("nosotros");        
        $data["clasificaciones_departamentos"] 
                                = $clasificaciones_departamentos;        
        $data["forma_pago"]     =  $this->get_forma_pago();         
        $data["servicio"]   =  [];            
        if($data["num_recibo"] > 0 && ctype_digit($this->input->get("recibo"))){
            $prm["id_recibo"]   =  $data["num_recibo"];
            $data["servicio"]   =  $this->carga_servicio_por_recibo($prm);            
        }        

        $data["css"] =  ["../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css"];
        $data["js"] 
                 = [
                        "../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                        '../js_tema/notificar/principal.js'
                    ];
        
        $this->principal->show_data_page($data, 'home');                          
    }
    /**/
    function carga_servicio_por_recibo($q){
        return $this->principal->api("q" , "tickets/servicio_recibo/format/json/", $q);
    }
    /**/
    function get_forma_pago(){
        return 
        $this->principal->api("q" , "cuentas/forma_pago/format/json/");
    }   
}