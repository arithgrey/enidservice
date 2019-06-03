<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper("ventasencuentro");
        $this->load->library(lib_def());
        $this->principal->acceso();
    }

    function index()
    {
        $data = $this->principal->val_session();
        $this->principal->acceso();
        $data["action"] = $this->input->get("action");
        $data = $this->principal->getCSSJs($data, "ventas_encuentro");
        $this->principal->show_data_page($data, 'home');

    }

}