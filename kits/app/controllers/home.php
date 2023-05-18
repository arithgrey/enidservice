<?php

class Home extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();        
        $this->load->library(lib_def());                        
        $this->load->helper('kit');
     
    }

    function index()
    {
                
        $data = $this->app->session();    
        $data = $this->app->cssJs($data, "kits");
        $data["kits"] = $this->app->api("kit/list_servicios/format/json");        
        $this->app->pagina($data, render($data),1);

    }

}