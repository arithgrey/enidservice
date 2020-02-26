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
        $module = $this->module_redirect($num_perfil);
        $this->valida_es_cliente($module);

        $data["categorias_destacadas"] = $this->carga_categorias_destacadas();
        $data["tipo_tag_arquetipo"] = $this->tipo_tag_arquetipo();
        $data = $this->app->cssJs($data, "reporte_enid");

        $this->app->pagina($data, render_reporte($data), 1);

    }

    private function module_redirect($num_perfil)
    {

        $module = 1;
        $desarrollo = [8, 11, 7];
        switch ($num_perfil) {
            case 5:
                $module = "location:../cargar_base";
                break;

            case 6:
                $module = "location:../pedidos";
                break;


            case  in_array($num_perfil, $desarrollo):
                $module = "location:../desarrollo";
                break;


            case 20:
                $module = "location:../area_cliente";
                break;

            case 21:
                $module = "location:../entregas";
                break;

            default:

                break;
        }

        return $module;

    }

    /**
     * @param $module
     */
    private function valida_es_cliente($module)
    {
        if ($module != 1) {
            header($module);
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