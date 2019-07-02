<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session();

        $data += [

            "vista" => "secciones/terminos_condiciones",
            "titulo" => "TÉRMINOS Y CONDICIONES",

        ];

        $this->app->pagina($data, 'home');
    }
}