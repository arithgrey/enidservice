<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("desarrollos");
        $this->load->library(lib_def());
        $this->principal->acceso();
    }

    function index()
    {

        $data = $this->principal->val_session();
        $param =  $this->input->get();

        $data["num_departamento"] = $this->get_id_departamento_by_id_perfil($this->principal->getperfiles(2, "idperfil"));
        $data["departamentos"] = $this->get_departamentos_enid();
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos(1);

        $activa = get_param_def($param, "q");
        $data["activa"] = ($activa === "") ? 1 : $activa;
        $data = $this->principal->getCssJS($data, "desarrollo");
        $this->principal->show_data_page($data, 'empresas_enid');

    }

    private function get_id_departamento_by_id_perfil($id_perfil)
    {

        $q["id_perfil"] = $id_perfil;
        $api = "perfiles/id_departamento_by_id_perfil/format/json/";
        return $this->principal->api($api, $q);

    }

    private function get_departamentos_enid()
    {
        $q["info"] = 1;
        $api = "departamento/index/format/json/";
        return $this->principal->api($api, $q);
    }


}