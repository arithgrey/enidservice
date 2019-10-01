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

        $recomendacion = $this->busqueda_recomendacion($prm);
        if ($data["in_session"] == 1) {
            $this->notifica_lectura($id_usuario, $data["id_usuario"]);
        }

        $prm +=  [
            "page" => prm_def( $this->input->get(), "page"),
            "resultados_por_pagina" => 5
        ];

        $prm["totales_elementos"] = (es_data($recomendacion)) ? $recomendacion["data"][0]["num_valoraciones"] : 0;

        $data["paginacion"] = "";
        if ($prm["totales_elementos"] > $prm["resultados_por_pagina"]) {
            $prm["per_page"] = 5;
            $prm["q"] = $id_usuario;
            $data["paginacion"] = $this->get_paginacion($prm);
        }

        $response = format_recomendacion(
            $this->app->cssJs($data, "recomendacion_vista"),
            $recomendacion["info_valoraciones"],
            $this->resumen_valoraciones_vendedor($prm)
        );

        $this->app->pagina($data, $response, 1);

    }

    private function busqueda_recomendacion($q)
    {

        return $this->app->api("valoracion/usuario/format/json/", $q);

    }

    private function notifica_lectura($id_usuario, $id_usuario_valoracion)
    {

        if ($id_usuario === $id_usuario_valoracion) {

            $this->app->api("valoracion/lectura/format/json/", ["id_usuario" => $id_usuario], 'json', 'PUT');
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