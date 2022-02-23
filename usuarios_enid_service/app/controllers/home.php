<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("user");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {

        $data = $this->app->session("");
        $param = $this->input->get();
        $data['q'] = prm_def($param, 'q');

        if ($this->app->getperfiles() === 20) {

            header(_text("location:", path_enid("area_cliente")));
        }

        $data += [
            "departamentos" => $this->get_departamentos_enid(),
            "perfiles_enid_service" => $this->get_perfiles_enid_service()
        ];

        $data = $this->app->cssJs($data, "usuarios_enid_service" , 1);
        $this->app->pagina($data, 'usuarios_enid_service/empresas');
    }

    private function get_perfiles_enid_service()
    {

        return $this->app->api("perfiles/get");

    }

    private function get_departamentos_enid()
    {
        return $this->app->api("departamento/index", ["estado" => 1]);
    }
}