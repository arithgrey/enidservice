<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("procesar");
        $this->load->library(lib_def());
    }

    private function crea_data_costo_envio($data)
    {

        $param["flag_envio_gratis"] = (array_key_exists("servicio", $data) && count($data["servicio"]) > 0) ? $data["servicio"][0]["flag_envio_gratis"] : 0;
        return $param;
    }

    function index()
    {


        $param = $this->input->post();
        if (array_key_exists("num_ciclos", $param) && ctype_digit($param["num_ciclos"]) && $param["num_ciclos"] > 0 && array_key_exists("ciclo_facturacion", $param) && $param["num_ciclos"] > 0 && $param["num_ciclos"] < 10 && ctype_digit($param["plan"]) && $param["plan"] > 0
            ||
            array_key_exists("es_servicio", $param)

        ) {


            $fn = (array_key_exists("es_servicio", $param) && $param["es_servicio"] > 0) ? $this->crea_orden_compra_servicio($param) : $this->crea_orden_compra($param);


        } else {


            $fb = (get_param_def($param, "recibo", 0, 1) > 0) ? $this->add_domicilio_entrega($param) : redirect("../../");


        }
    }

    private function crea_orden_compra($param)
    {

        $data = $this->app->session(
            "",
            "",
            "Registra tu cuenta  y recibe  asistencia al momento.",
            create_url_preview("recomendacion.jpg")
        );

        $num_usuario_referencia = usuario($this->input->get("q2"));
        $data["q2"] = $num_usuario_referencia;
        $data["servicio"] = $this->resumen_servicio($param["plan"]);
        $data["costo_envio"] = "";

        if ($data["servicio"][0]["flag_servicio"] == 0) {
            $data["costo_envio"] =
                $this->calcula_costo_envio($this->crea_data_costo_envio($data));

        }

        $data["info_solicitud_extra"] = $param;
        $data["clasificaciones_departamentos"] = "";
        $data["vendedor"] = "";
        if ($data["servicio"][0]["telefono_visible"] == 1) {
            $data["vendedor"] =
                $this->app->usuario($data["servicio"][0]["id_usuario"]);
        }

        $data = $this->app->cssJs($data, "procesar");
        $data["carro_compras"] = $param["carro_compras"];
        $data["id_carro_compras"] = $param["id_carro_compras"];

        $this->app->pagina($data, 'home');

    }

    function crea_orden_compra_servicio($param)
    {

        $data = $this->app->session(
            "",
            "",
            "Registra tu cuenta  y recibe  asistencia al momento.",
            create_url_preview("recomendacion.jpg")
        );

        $data["servicio"] = $this->resumen_servicio($param["id_servicio"]);

        $this->app->pagina($this->app->cssJs($data, "procesar_crear"), 'procesar_contacto');

    }

    private function add_domicilio_entrega($param)
    {

        $data = $this->app->session("", "", "Registra tu cuenta  y recibe  asistencia al momento.");
        $data = $this->app->cssJs($data, "procesar_domicilio");

        $param += [

            "id_recibo"  =>  $param["recibo"],
            "id_usuario" => $this->app->get_session("idusuario")
        ];

        $response = $this->carga_ficha_direccion_envio($param, 1);
        $this->app->pagina($data, $response, 1);

    }

    private function calcula_costo_envio($q)
    {

        return $this->app->api("cobranza/calcula_costo_envio/format/json/", $q);
    }

    private function resumen_servicio($id_servicio)
    {

        $q["id_servicio"] = $id_servicio;
        return $this->app->api("servicio/resumen/format/json/", $q);
    }

    private function carga_ficha_direccion_envio($q, $v = 0)
    {
        $q += [
            "text_direccion" => "Dirección de Envio",
            "externo" => 1
        ];

        $response = $this->app->api("usuario_direccion/direccion_envio_pedido", $q, "html");

        if ($v > 0) {
            $response = append([$response, input_hidden(["class" => "es_seguimiento", "value" => 1])]);
        }
        return $response;
    }
}