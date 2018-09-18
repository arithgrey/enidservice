<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reportecontrolador extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper("repo");        
        $this->load->library(lib_def());               
        
    }
    function index(){  
          
        $data = $this->val_session("Ayudanos a mejorar tu experiencia");                       
        $this->principal->show_data_page( $data , 'reporte/reportes');    
        $clasificaciones_departamentos =   
        $this->principal->get_departamentos("nosotros");    
        $data["clasificaciones_departamentos"] = $clasificaciones_departamentos;
            
        $this->principal->crea_historico(15);
    }
    /**/    
   

}