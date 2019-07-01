<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("area");
        $this->load->library(lib_def());
        $this->principal->acceso();
    }

    function index()
    {
        $data = $this->principal->val_session();
        $param =  $this->input->get();
        if (get_param_def($param, "transfer") > 0) {

        } else {

            $valocaciones =  $this->resumen_valoraciones($data["id_usuario"]);

            $this->principal->acceso();
            $data +=  [
                "action" => $param["action"],
                "valoraciones" => get_param_def($valocaciones,"info_valoraciones",[]),
                "alcance" => crea_alcance($this->get_alcance($data["id_usuario"])),
                "ticket" => get_param_def($param , "ticket"),
            ];

            $data   =  $this->principal->getCSSJs($data, "area_cliente");
            $this->principal->show_data_page($data, render_user($data),1);
        }
    }
    private function resumen_valoraciones($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->principal->api("valoracion/usuario/format/json/", $q);
    }

    private function get_alcance($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->principal->api("servicio/alcance_usuario/format/json/", $q);
    }
}