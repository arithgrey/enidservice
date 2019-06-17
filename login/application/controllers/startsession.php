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

        $param = $this->input->get();
        $data = $this->principal->val_session();
        $data = $this->principal->getCssJs($data, "login");
        $this->validate_user_sesssion();
        $this->principal->show_data_page($data, get_page_sigin(get_param_def($param, "action")), 1);


    }

    function validate_user_sesssion()
    {
        if ($this->principal->is_logged_in() > 0) {
            redirect(path_enid("url_home"));
        }
    }

    function logout()
    {

        $this->principal->logout();

    }
}