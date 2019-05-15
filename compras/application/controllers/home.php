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

        $data = $this->principal->val_session("");
        $this->principal->acceso();
        $data["meta_keywords"] = "";
        $data["desc_web"] = "";
        $data["url_img_post"] = create_url_preview("");
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
        $data = $this->principal->getCssJs($data, "compras");
        $this->principal->show_data_page($data, get_format_compras(), 1);


    }

}