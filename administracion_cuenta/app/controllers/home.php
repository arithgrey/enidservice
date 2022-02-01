<?php

class Home extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper("cuenta");
        $this->load->library(lib_def());                
         
    }

    function index()
    {
            
        $data = $this->app->session();    
        $data["usuario"] = $this->app->usuario($data["id_usuario"],1, 1); 
        $data = $this->app->cssJs($data, "administracion_cuenta", 1);
        $this->app->pagina($data, render_cuenta($data),1);
        
    }

}