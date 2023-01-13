<?php 

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->load->helper("rastreo");

    }

    function index()
    {   
        $param = $this->input->get();
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "rastrea_paquete");            
        $this->app->pagina($data, busqueda_pedido($param), 1);

    }
   
}