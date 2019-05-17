<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("area");
        $this->load->library(lib_def());
        $this->principal->acceso();
    }

    function index()
    {
        $data = $this->principal->val_session("");
        $this->principal->acceso();
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
        $data = $this->principal->getCssJs($data, "tiempo_venta");
        $this->principal->show_data_page($data, 'home');


    }

}