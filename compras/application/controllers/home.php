<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("compras");
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->principal->val_session();
        $this->principal->acceso();
        $data = $this->principal->getCssJs($data, "compras");
        $this->principal->show_data_page($data, get_format_compras(), 1);

    }

}