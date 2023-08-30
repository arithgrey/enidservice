<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->library(lib_def());
        
    }

    function index()
    {
        $data = $this->app->session();        
        $data = $this->app->cssJs($data, "cuenta_personal");
        $data["nichos"] = $this->app->api("nicho/index");
        $this->app->pagina($data, 'cuenta_personal/cuenta');
    }
    
}
