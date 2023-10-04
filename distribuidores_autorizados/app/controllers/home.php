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

        $param = $this->input->get();
        $i = prm_def($param, "info");
        setcookie('xn', 1, strtotime('2038-01-01'));     

        $data = $this->app->cssJs($this->data, "forma_pago");
        $this->app->pagina($data , get_format_pago(), 1);

    }

}