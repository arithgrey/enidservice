<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("area");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $param = $this->input->get();
        if (prm_def($param, "transfer") > 0) {

        } else {

            $this->app->acceso();
            $data += [
                "action" => $param["action"],
                "valoraciones" =>
                    prm_def($this->resumen_valoraciones($data["id_usuario"]), "info_valoraciones", []),
                "alcance" => crea_alcance($this->get_alcance($data["id_usuario"])),
                "ticket" => prm_def($param, "ticket"),
            ];

            $data = $this->app->cssJs($data, "area_cliente");
            $this->app->pagina($data, render_user($data), 1);
        }
    }

    private function resumen_valoraciones($id_usuario)
    {

        return $this->app->api("valoracion/usuario/format/json/", ["id_usuario" => $id_usuario]);
    }

    private function get_alcance($id_usuario)
    {

        return $this->app->api("servicio/alcance_usuario/format/json/", ["id_usuario" => $id_usuario]);
    }
}