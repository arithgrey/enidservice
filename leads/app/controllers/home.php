<?php 

class Home extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();                       
        $this->load->helper("busqueda");
        $this->load->library(lib_def());        
        
    }

    function index()
    {
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "leads");                            
        
        $data["leads"] = $this->recibos_sin_ficha_seguimiento();        
        $this->app->pagina($data, render($data), 1);


    }
    function recibos_sin_ficha_seguimiento()
    {
    
        return $this->app->api("clientes/recibos_sin_ficha_seguimiento");

    }

        
}