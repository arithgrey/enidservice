<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
use Enid\Nicho\Nicho as Tiendas;
class Home extends CI_Controller
{
    private $tiendas;
    function __construct()
    {
        parent::__construct();
        $this->load->helper("reporte");
        $this->load->library(lib_def());
        $this->app->acceso();
        $this->tiendas = new Tiendas();
    }

    function index()
    {
        $data = $this->app->session();
        $this->module_redirect();
        $data["tiendas"] = $this->tiendas->tiendas();
        $data["categorias_destacadas"] = $this->app->api("clasificacion/categorias_destacadas");
        $data["tipo_tag_arquetipo"] = $this->app->api("tipo_tag_arquetipo/index");
        $data["ventas_mes_ubicaciones"] = $this->app->ventas_mes_ubicaciones();
        $data = $this->app->cssJs($data, "reporte_enid");

        $this->app->pagina($data, render_reporte($data), 1);
    }

    private function module_redirect()
    {
        $num_perfil = $this->app->getperfiles();
        $area_cliente = "location:../";
        $noticias = "location:../busqueda";

        $modulo = ($num_perfil == 20) ? $area_cliente : $noticias;
        if ($num_perfil != 3) {

            if ($modulo != 1) {
                header($modulo);
            }
        }
    }
}
