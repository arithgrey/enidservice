<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("cuenta");
        $this->load->library(lib_def());
        $this->principal->acceso();
    }

    function index()
    {

        $data = $this->principal->val_session();
        $data["usuario"] = $this->principal->get_info_usuario($this->principal->get_session("idusuario"));
        $data = $this->principal->getCssJs($data, "administracion_cuenta");
        $this->principal->show_data_page($data, 'home');

    }

}