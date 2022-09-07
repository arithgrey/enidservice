<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("garantia");
        $this->load->library(lib_def());
        
    }

    function index()
    {
        $data = $this->app->session();
        $param = $this->input->get();
        
        $id_orden_compra = prm_def($param, "ticket");

        $data += [
            "ticket" => $id_orden_compra,
        ];
        
        $data = $this->app->cssJs($data, "garantias");
        $this->app->pagina($data, render_user($data), 1);
    }
}
