<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    private $data;
    function __construct()
    {
        parent::__construct();
        $this->load->helper("pago");
        $this->load->library(lib_def());
        $this->data = $this->app->session();

    }

    function index()
    {
        $data = $this->app->cssJs($this->data, "cambios_devoluciones");
        $this->app->pagina($data , get_format_pago(), 1);
    }

}