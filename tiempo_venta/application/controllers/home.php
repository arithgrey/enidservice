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
        $data["meta_keywords"] = "";
        $data["desc_web"] = "";
        $data["url_img_post"] = "";
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos();

        $data["js"] = ['tiempo_entrega/principal.js'];
        $this->principal->show_data_page($data, 'home');


    }

}