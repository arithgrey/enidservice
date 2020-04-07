<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('busqueda');
        $this->load->library(lib_def());
    }

    function index()
    {
        $param =  $this->input->get();
        $data = $this->app->session();
        $data["css"] = ["search_sin_encontrar.css"];
        $this->app->pagina($data, form($param), 1);

    }

}
