<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Startsession extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("log");
        $this->load->library(lib_def());
    }

    function index()
    {

        $param  =   $this->input->get();
        $data   =   $this->principal->val_session("");
        $data   =   $this->principal->getCssJs($data,"login");
        $action =   get_param_def($param, "action");
        $this->principal->validate_user_sesssion();
        $this->principal->show_data_page($data, get_page_sigin($action) ,1);


    }
    function logout()
    {

        $this->principal->logout();

    }
}