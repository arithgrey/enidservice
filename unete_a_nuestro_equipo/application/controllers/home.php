<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("equipo");
        $this->load->library(lib_def());
    }

    function index()
    {
        $data = $this->app->session();
        $this->app->pagina($data, render_empleo($data), 1);
    }

}