<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper("ventasencuentro");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $this->app->acceso();
        $data["action"] = $this->input->get("action");
        $this->app->pagina($this->app->cssJs($data, "ventas_encuentro"), render($data) ,1);

    }

}