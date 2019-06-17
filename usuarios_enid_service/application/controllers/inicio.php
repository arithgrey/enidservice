<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("user");
        $this->load->library(lib_def());
        $this->principal->acceso();
    }

    function index()
    {

        $data = $this->principal->val_session("Grupo ventas - Enid Service - ");

        if ($this->principal->getperfiles() === 20) {

            header("location:" . path_enid("area_cliente"));
        }


        $data += [

            "departamentos" => $this->get_departamentos_enid(),
            "perfiles_enid_service" => $this->get_perfiles_enid_service()

        ];


        $this->principal->show_data_page($this->principal->getCssJs($data, "usuarios_enid_service"), 'empresas_enid');
    }

    private function get_perfiles_enid_service()
    {

        return $this->principal->api("perfiles/get/format/json/");
    }

    private function get_departamentos_enid()
    {

        $q["estado"] = 1;
        return $this->principal->api("departamento/index/format/json/", $q);
    }
}