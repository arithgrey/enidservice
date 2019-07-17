<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("recomendacion");
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->get();

        if (ctype_digit(prm_def($param, "q"))) {


            $id_usuario = $this->input->get("q");
            $data = $this->app->session();
            $prm["id_usuario"] = $id_usuario;
            $data["usuario"] = $this->app->usuario($id_usuario);
            $fn = (count($data["usuario"]) > 0) ? $this->create_vista($data, $id_usuario, $prm) : $this->go_home();


        } else {

            $this->go_home();

        }
    }

    private function create_vista($data, $id_usuario, $prm)
    {
        $data_recomendacion = $this->busqueda_recomendacion($prm);
        if ($data["in_session"] == 1) {
            $id_usuario_actual = $data["id_usuario"];
            $this->notifica_lectura($id_usuario, $id_usuario_actual);
        }

        $resumen_recomendacion = $data_recomendacion["info_valoraciones"];
        $prm["page"] = prm_def($this->input->get(), "page");
        $prm["resultados_por_pagina"] = 5;
        $resumen_valoraciones_vendedor = $this->resumen_valoraciones_vendedor($prm);
        $prm["totales_elementos"] = $data_recomendacion["data"][0]["num_valoraciones"];

        $data["paginacion"] = "";
        if ($prm["totales_elementos"] > $prm["resultados_por_pagina"]) {

            $prm["per_page"] = 5;
            $prm["q"] = $id_usuario;
            $data["paginacion"] = $this->get_paginacion($prm);
        }


        $data = $this->app->cssJs($data, "recomendacion_vista");
        $response = get_formar_recomendacion($data, $resumen_recomendacion, $resumen_valoraciones_vendedor);
        $this->app->pagina($data, $response, 1);

    }

    private function busqueda_recomendacion($q)
    {

        return $this->app->api("valoracion/usuario/format/json/", $q);

    }

    private function notifica_lectura($id_usuario, $id_usuario_valoracion)
    {

        if ($id_usuario === $id_usuario_valoracion) {

            $q["id_usuario"] = $id_usuario;
            $this->app->api("valoracion/lectura/format/json/", $q, 'json', 'PUT');
        }
    }

    private function resumen_valoraciones_vendedor($q)
    {

        return $this->app->api("valoracion/resumen_valoraciones_vendedor/format/json/", $q);
    }

    private function get_paginacion($q)
    {

        return $this->app->api("producto/paginacion/format/json/", $q);
    }

    private function go_home()
    {
        redirect("../../", 'POST');
    }
}