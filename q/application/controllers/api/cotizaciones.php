<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class cotizaciones extends REST_Controller{      
    function __construct(){
        parent::__construct();                          
        $this->load->model("contactosmodel");
        $this->load->library('sessionclass');                    
    }
    /**/    
    function cotizaciones_sitios_web_GET(){        

        $param = $this->get();
        $data["cotizaciones"] = $this->contactosmodel->get_resumen_cotizacione($param);
        $this->load->view("cotizador/cotizaciones_dia" , $data);

    }
    /**/
    function contactos_GET(){        

        $param = $this->get();
        $data["cotizaciones"] = $this->contactosmodel->get_contactos($param);
        $this->load->view("cotizador/contactos_dia" , $data);

    }
    /**/
    function sitios_web_GET(){        

        $param = $this->get();
        $data["cotizaciones"] = $this->contactosmodel->get_contactos_sitios_web($param);
        $this->load->view("cotizador/contactos_dia" , $data);

    }
    /**/
    function adwords_GET(){        

        $param = $this->get();
        $data["cotizaciones"] = $this->contactosmodel->get_contactos_adwords($param);
        $this->load->view("cotizador/contactos_dia" , $data);

    }
    /**/
    function tienda_en_linea_GET(){        

        $param = $this->get();
        $data["cotizaciones"] = $this->contactosmodel->get_contactos_tienda_en_linea($param);
        $this->load->view("cotizador/contactos_dia" , $data);

    }
    /**/
    function crm_GET(){        

        $param = $this->get();
        $data["cotizaciones"] = $this->contactosmodel->get_contactos_crm($param);
        $this->load->view("cotizador/contactos_dia" , $data);

    }

    /**/ 
}?>
