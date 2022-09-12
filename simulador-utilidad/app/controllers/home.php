<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("simular");
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session(); 
        $data = $this->app->cssJs($data, "simulador");    
        $this->app->pagina($data, render($data), 1);

    }

    
}
