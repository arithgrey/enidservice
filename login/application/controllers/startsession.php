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

        $data = $this->principal->val_session("");
        $data = $this->getCssJs($data);
        $action = get_info_variable($this->input->get(), "action");
        $this->principal->validate_user_sesssion();
        $data["clasificaciones_departamentos"] = "";
        $this->principal->show_data_page($data, get_page_sigin($action) ,1);


    }

    private function getCssJs($data)
    {

        $data["desc_web"] = "COMPRA Y VENDE EN ENID SERVICE";
        $data["meta_keywords"] = "COMPRA Y VENDE ARTÍCULOS Y SERVICIOS  EN ENID SERVICE ";
        $data["url_img_post"] = create_url_preview("promo.png");
        $data["css"] = ["login.css"];
        $data["js"] = ["login/sha1.js", "login/ini.js"];
        return $data;

    }

    function logout()
    {

        $this->principal->logout();

    }
}