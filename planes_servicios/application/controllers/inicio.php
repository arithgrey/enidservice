<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    private $modulo;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("planes");
        $this->load->library(lib_def());
        $this->app->acceso();
        $this->modulo = 'planes_servicios';
    }

    function index()
    {


        $param = $this->input->get();
        $data = $this->app->session();
        $data += [
            "action" => valida_action($param, "action"),
            "considera_segundo" => 0,
            "extra_servicio" => 0,
        ];


        $data = $this->prevenir_acceso($param, $data);
        $data["error_registro"] = valida_extension(prm_def($param, "mensaje", ""), 5, "");
//        $data["top_servicios"] = $this->get_top_servicios_usuario($data["id_usuario"]);
        $data["top_servicios"] = [];
        $data["ciclo_facturacion"] = $this->create_ciclo_facturacion();
        $data["is_mobile"] = ($this->agent->is_mobile() === FALSE) ? 0 : 1;

        $data = $this->app->cssJs($data, "planes_servicios");

        $data["list_orden"] = $this->get_orden();
        $data["id_perfil"] = $this->app->getperfiles();
        $this->app->pagina($data, render_ventas($data), 1);

    }

    private function restricciones($data)
    {

        $restricciones = $data['restricciones'][$this->modulo];
        $id_perfil = $data['id_perfil'];
        $acceso = (in_array($id_perfil, $restricciones));

        if ($acceso) {

            redirect(path_enid("url_home"));
        }
    }

    private function prevenir_acceso($param, $data)
    {

        $this->restricciones($data);
        if ($data["action"] == 2) {
            $data["considera_segundo"] = 1;
            if (ctype_digit($param["servicio"]) && $data["in_session"] === 1 && $data["id_usuario"] > 0) {

                $param["id_usuario"] = $data["id_usuario"];
                $param["id_servicio"] = $param["servicio"];

                if ($this->valida_servicio_usuario($param) != 1) {

                    $fn = ($data["id_perfil"] == 20) ? $this->app->out() : "";

                }

                $data["extra_servicio"] = $param["servicio"];
            } else {
                $this->app->out();
            }
        }
        return $data;
    }

    private function valida_servicio_usuario($q)
    {

        return $this->app->api("servicio/es_servicio_usuario/format/json/", $q);
    }

    private function get_top_servicios_usuario($id_usuario)
    {

        return $this->app->api("servicio/top_semanal_vendedor/format/json/", ["id_usuario" => $id_usuario]);

    }

    private function get_orden()
    {
        $response = [
            "Las novedades primero",
            "Lo     más vendido",
            "Los más votados",
            "Los más populares ",
            "Precio [de mayor a menor]",
            "Precio [de menor a mayor]",
            "Nombre del producto [A-Z]",
            "Nombre del producto [Z-A]",
            "Sólo servicios",
            "Sólo productos"
        ];
        return $response;
    }

    private function create_ciclo_facturacion($q = [])
    {

        return $this->app->api("ciclo_facturacion/not_ciclo_facturacion/format/json/", $q);
    }
}
