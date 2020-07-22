<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("usuario");
        $this->load->library(lib_def());
    }


    function index()
    {

        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "usuario_contacto");
        $param = $this->input->get();
        $id_usuario = prm_def($param, 'id_usuario');

        $data['usuario_busqueda'] = $this->app->usuario($id_usuario);
        $data['perfil_busqueda'] = $this->get_perfil_data($id_usuario);
        $this->app->pagina($data, render($data), 1);


    }

    private function get_perfil_data($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "perfiles/data_usuario/format/json/";
        return $this->app->api($api, $q);
    }

}
