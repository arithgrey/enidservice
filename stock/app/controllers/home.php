<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->load->helper("stock");
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function index()
    {

        $inventario = $this->inventario();
        $inventario = $this->app->add_imgs_servicio($inventario);
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "stock" , 1);
        $this->app->pagina($data, render($inventario), 1);

    }


    private function inventario()
    {

        return $this->app->api("stock/inventario");
    }

}
