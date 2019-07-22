<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("desarrollos");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {

        $data = $this->app->session();
        $param = $this->input->get();
        $data["num_departamento"] = $this->get_id_departamento_by_id_perfil($this->app->getperfiles(2, "idperfil"));
        $data["departamentos"] = $this->get_departamentos_enid();
        $data["clasificaciones_departamentos"] = $this->app->get_departamentos(1);
        $activa = prm_def($param, "q");
        $data["ticket"] = prm_def($param, "ticket");
        $data["activa"] = ($activa === "") ? 1 : $activa;
        $data = $this->app->cssJs($data, "desarrollo");
        $this->app->pagina($data, render_ticket_empresa($data), 1);

    }

    private function get_id_departamento_by_id_perfil($id_perfil)
    {

        return $this->app->api("perfiles/id_departamento_by_id_perfil/format/json/", ["id_perfil" => $id_perfil]);

    }

    private function get_departamentos_enid()
    {

        return $this->app->api("departamento/index/format/json/", ["info" => 1]);
    }


}