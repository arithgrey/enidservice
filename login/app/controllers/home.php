<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
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
        $this->validate_user_sesssion();
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "login");
        $data['footer_visible'] = false;
        $this->app->pagina($data, page_sigin(prm_def($param, "action")), 1);

    }

    function validate_user_sesssion()
    {


        if (intval($this->app->is_logged_in()) > 0) {
            redirect(path_enid("url_home"));

        }
    }

    function logout()
    {

        $this->app->out();

    }
}