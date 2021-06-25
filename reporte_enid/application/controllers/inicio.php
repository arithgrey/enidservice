<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Inicio extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("reporte");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session("Métricas Enid Service");
        $num_perfil = $this->app->getperfiles();
        $this->module_redirect($num_perfil);


        $data["categorias_destacadas"] = $this->carga_categorias_destacadas();
        $data["tipo_tag_arquetipo"] = $this->tipo_tag_arquetipo();
        $data = $this->app->cssJs($data, "reporte_enid");

        $this->app->pagina($data, render_reporte($data), 1);

    }

    private function module_redirect($num_perfil)
    {
        $area_cliente = "location:../area_cliente";
        $noticias = "location:../busqueda";

        $modulo = ($num_perfil == 20) ? $area_cliente : $noticias;
        if ($num_perfil != 3) {

            if ($modulo != 1) {
                header($modulo);
            }
        }


    }

    private function carga_categorias_destacadas($q = [])
    {

        return $this->app->api("clasificacion/categorias_destacadas/format/json/", $q);
    }

    private function tipo_tag_arquetipo()
    {

        return $this->app->api("tipo_tag_arquetipo/index/format/json/");
    }


}