<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("top_clientes");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "top_clientes");
        $clientes = $this->clientes();
        $this->app->pagina($data, render($clientes), 1);


    }
    private function clientes(){

        return $this->app->api("recibo/clientes_frecuentes/format/json/",[]);
    }
}
