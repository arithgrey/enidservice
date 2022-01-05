<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("compras");
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "compras", 1);
        $this->app->pagina($data, render_compras(), 1);

    }

}
