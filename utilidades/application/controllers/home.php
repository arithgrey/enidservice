<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper("kit");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {

        $data = $this->app->session();
        $this->app->acceso();
        $this->app->pagina($this->app->cssJs($data, "utilidades") , get_form_tags($data),1);

    }

}