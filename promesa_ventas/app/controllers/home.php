<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("promesa");
        $this->load->library(lib_def());
    }

    function index()
    {
        $param = $this->input->get();     
        $data = $this->app->session(); 
        $data = $this->app->cssJs($data, "promesa_ventas");            
        $this->app->pagina($data, render($data, $param), 1);

    }

    
}
