<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper("kit");
        $this->load->library(lib_def());
        $this->principal->acceso();
    }

    function index()
    {
        $data = $this->principal->val_session();
        $this->principal->acceso();
        $data["action"] = $this->input->get("action");
        $class_departamentos = $this->principal->get_departamentos();
        $data["clasificaciones_departamentos"] = $class_departamentos;
        $data = $this->principal->getCSSJs($data, "utilidades");
        $this->principal->show_data_page($data, 'home');


    }

}