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


        $data   =   $this->principal->val_session("");
        $data   =   $this->principal->getCssJs($data,"login");
        $data["action"] = get_info_variable($this->input->get(), "action");
        $this->principal->validate_user_sesssion();
        $this->principal->show_data_page($data, "signin");


    }
    function logout()
    {

        $this->principal->logout();

    }
}