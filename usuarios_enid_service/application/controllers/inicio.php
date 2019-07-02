<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
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

        $data = $this->app->session("Grupo ventas - Enid Service - ");

        if ($this->app->getperfiles() === 20) {

            header("location:" . path_enid("area_cliente"));
        }


        $data += [

            "departamentos" => $this->get_departamentos_enid(),
            "perfiles_enid_service" => $this->get_perfiles_enid_service()

        ];


        $this->app->pagina($this->app->cssJs($data, "usuarios_enid_service"), 'empresas_enid');
    }

    private function get_perfiles_enid_service()
    {

        return $this->app->api("perfiles/get/format/json/");
    }

    private function get_departamentos_enid()
    {

        $q["estado"] = 1;
        return $this->app->api("departamento/index/format/json/", $q);
    }
}