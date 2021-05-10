<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("competencias");
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->get();
        $tipo_top = prm_def($param, 'tipo_top');

        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "competencias");
        $data['metricas'] = $this->metricas_dia($tipo_top);
        $data['tipo_top'] = $tipo_top;
        $data['comisionistas'] = $this->usuarios_comisionistas();
        $this->app->pagina($data, render($data), 1);

    }

    private function metricas_dia($tipo_top)
    {
        return $this->app->api("competencias/comisiones/format/json/", ['tipo_top' => $tipo_top]);
    }

    private function usuarios_comisionistas()
    {
        return $this->app->api("usuario_perfil/comisionistas/format/json/");
    }
}
