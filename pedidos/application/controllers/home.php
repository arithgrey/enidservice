<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("pedidos");
        $this->load->library("table");
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->get();
        $data = $this->app->session();
        $this->app->acceso();

        if (prm_def($param, "seguimiento") > 0 && ctype_digit($param["seguimiento"])) {

            $this->vista_seguimiento($param, $data);

        } else {

            $fn = (prm_def($param, "costos_operacion") > 0 && ctype_digit($param["costos_operacion"])) ? $this->carga_vista_costos_operacion($param, $data) : $this->seguimiento_pedido($param, $data);

        }
    }

    private function vista_seguimiento($param, $data)
    {

        $data = $this->app->cssJs($data, "pedidos_seguimiento");
        $id_recibo = $this->input->get("seguimiento");

        $recibo = $this->get_recibo($id_recibo, 1);

        $data += [
            "servicio" => $this->app->servicio(pr($recibo, "id_servicio"))
        ];


        $drecibo = $recibo[0];
        $id_usuario_compra = $drecibo["id_usuario"];
        $id_usuario_venta = $drecibo["id_usuario_venta"];


        $acceso = ($id_usuario_compra == $data["id_usuario"] || $id_usuario_venta == $data["id_usuario"]) ? 1 : 0;
        if (es_data($recibo) && $data["in_session"] == 1 && $data["id_usuario"] > 0 && $acceso > 0) {


            $data["es_vendedor"] = ($id_usuario_venta == $data["id_usuario"]) ? 1 : 0;

            $data += [
                "domicilio" => $this->get_domicilio_entrega($id_recibo, $recibo),
                "recibo" => $recibo

            ];

            $fn = (prm_def($param, "domicilio") > 0) ? $this->load_view_domicilios_pedidos($data) : $this->load_view_seguimiento($data, $param, $recibo, $id_recibo);


        } else {
            redirect("../../area_cliente");
        }

    }

    private function get_recibo($id_recibo, $add_img = 0)
    {

        $q["id"] = $id_recibo;

        $response = $this->app->api("recibo/id/format/json/", $q);

        if (es_data($response) && $add_img > 0) {

            $response[0]["url_img_servicio"] = $this->app->imgs_productos($response[0]["id_servicio"], 1, 1, 1);

        }

        return $response;
    }

    private function get_domicilio_entrega($id_recibo, $recibo)
    {

        $response = [];

        if (es_data($recibo)) {

            $recibo = $recibo[0];
            $tipo_entrega = $recibo["tipo_entrega"];
            $response["tipo_entrega"] = $tipo_entrega;
            $domicilio = ($tipo_entrega > 0) ? $this->get_punto_encuentro($id_recibo) : $this->get_domicilio_recibo($id_recibo);
            $response["domicilio"] = $domicilio;

        }

        return $response;

    }

    private function get_punto_encuentro($id_recibo)
    {

        return $this->app->api("proyecto_persona_forma_pago_punto_encuentro/complete/format/json/", ["id_recibo" => $id_recibo]);
    }

    private function get_domicilio_recibo($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        $direccion = $this->app->api("proyecto_persona_forma_pago_direccion/recibo/format/json/", $q);
        $domicilio = [];

        if (count($direccion) > 0 && $direccion[0]["id_direccion"] > 0) {
            $id_direccion = $direccion[0]["id_direccion"];
            $domicilio = $this->get_direccion($id_direccion);
        }

        return $domicilio;
    }

    private function get_direccion($id)
    {

        return $this->app->api("direccion/data_direccion/format/json/", ["id_direccion" => $id]);
    }

    private function load_view_domicilios_pedidos($data)
    {


        $id_usuario = $data["id_usuario"];
        $data += [
            "lista_direcciones" => $this->get_direcciones_usuario($id_usuario),
            "puntos_encuentro" => $this->get_puntos_encuentro($id_usuario)
        ];

        $this->app->pagina($this->app->cssJs($data, "pedidos_domicilios_pedidos"), render_domicilio($data), 1);
    }

    private function get_direcciones_usuario($id_usuario)
    {

        return $this->app->api("usuario_direccion/all/format/json/", ["id_usuario" => $id_usuario]);
    }

    private function get_puntos_encuentro($id_usuario)
    {

        return $this->app->api("usuario_punto_encuentro/usuario/format/json/", ["id_usuario" => $id_usuario]);
    }

    private function load_view_seguimiento($data, $param, $recibo, $id_recibo)
    {

        $notificacion_pago = (prm_def($param, "notificar") > 0) ? 1 : 0;

        $data += [
            "notificacion_pago" => ($recibo[0]["notificacion_pago"] > 0) ? 0 : $notificacion_pago,
            "orden" => $id_recibo,
            "status_ventas" => $this->get_estatus_enid_service(),
            "evaluacion" => 1,
            "tipificaciones" => $this->get_tipificaciones($id_recibo),
            "id_servicio" => pr($recibo, "id_servicio")
        ];

        if ($recibo[0]["saldo_cubierto"] > 0 && $recibo[0]["se_cancela"] == 0 && $data["es_vendedor"] < 1) {

            $data["evaluacion"] = $this->verifica_evaluacion($recibo[0]["id_usuario"], $recibo[0]["id_servicio"]);

        }

        $this->app->pagina($data, render_seguimiento($data), 1);
    }

    private function get_estatus_enid_service($q = [])
    {

        return $this->app->api("status_enid_service/index/format/json/", $q);
    }

    private function verifica_evaluacion($id_usuario, $id_servicio)
    {

        $q = [

            "id_usuario" => $id_usuario,
            "id_servicio" => $id_servicio
        ];

        return $this->app->api("valoracion/num/format/json/", $q);

    }

    private function get_tipificaciones($id_recibo)
    {


        return $this->app->api("tipificacion_recibo/recibo/format/json/", ["recibo" => $id_recibo]);
    }

    private function get_ppfp($id_recibo)
    {


        return $this->app->api("recibo/id/format/json/", ["id" => $id_recibo]);

    }

    function carga_vista_costos_operacion($param, $data)
    {

        $data = $this->app->cssJs($data, "pedidos");
        $costos_operacion = $this->get_costo_operacion($param["costos_operacion"]);
        $this->table->set_heading(array('MONTO', 'CONCEPTO', 'REGISTO', ''));
        $total = 0;
        foreach ($costos_operacion as $row) {

            $total = $total + $row["monto"];
            $id = $row["id"];
            $icon = icon("fa fa-times ", ["onclick" => "confirma_eliminar_concepto('{$id}')"]);
            $this->table->add_row(array($row["monto"] . " MXN", $row["tipo"], $row["fecha_registro"], $icon));
        }

        $gastos = d(span("TOTAL EN GASTOS: ", " strong ") . $total . " MXN", "top_50 f12");
        $this->table->add_row(array(d($gastos), "", ""));
        $gastos = d(span("SALDADO: ", "strong") . $param["saldado"] . " MXN", "top_5 f12");

        $this->table->add_row(array(d($gastos), "", ""));

        $utilidad = $param["saldado"] - $total;
        $total = d(span("UTILIDAD:", " underline text-utilidad strong ") . $utilidad . "MXN", "top_20 ");
        $this->table->add_row(array(h($total, 4), "", ""));

        $this->table->set_template(template_table_enid());


        $recibo = $this->get_ppfp($param["costos_operacion"]);
        $id_servicio = (is_array($recibo) && count($recibo) > 0) ? $recibo[0]["id_servicio"] : 0;
        $path = $this->app->imgs_productos($id_servicio, 1, 1, 1);


        $response = get_format_costo_operacion(
            $this->table->generate(),
            $this->get_tipo_costo_operacion(),
            $param["costos_operacion"],
            $path,
            $costos_operacion,
            $recibo
        );

        $this->app->pagina($data, $response, 1);


    }

    private function get_costo_operacion($id_recibo)
    {

        return $this->app->api("costo_operacion/recibo/format/json/", ["recibo" => $id_recibo]);

    }

    private function get_tipo_costo_operacion()
    {

        return $this->app->api("tipo_costo/index/format/json/", ["x" => 1]);

    }

    function seguimiento_pedido($param, $data)
    {


        if ($this->app->getperfiles() != 3) {

            header("location:" . path_enid("area_cliente"));

        }

        $data = $this->app->cssJs($data, "pedidos");

        $data += [
            "tipos_entregas" => $this->get_tipos_entregas([]),
            "status_ventas" => $this->get_estatus_enid_service()
        ];


        $fn = (prm_def($param, "recibo") < 1) ? $this->app->pagina($data, get_form_busqueda_pedidos($data, $param), 1) : $this->load_detalle_pedido($param, $data);

    }

    private function get_tipos_entregas($q)
    {

        return $this->app->api("tipo_entrega/index/format/json/", $q);
    }

    private function load_detalle_pedido($param, $data)
    {

        $fn = (array_key_exists("recibo", $param) && ctype_digit($param["recibo"])) ? $this->carga_detalle_pedido($param, $data) : redirect("../../?q=");

    }

    private function carga_detalle_pedido($param, $data)
    {

        $id_recibo = $param["recibo"];
        $recibo = $this->get_recibo($id_recibo, 1);

        if (count($recibo) > 0) {


            $data += [

                "orden" => $id_recibo,
                "recibo" => $recibo

            ];

            if (prm_def($param, "fecha_entrega") > 0) {


                $this->app->pagina($data, get_form_fecha_entrega($data), 1);


            } elseif (prm_def($param, "recordatorio") > 0) {


                $id_usuario = pr($data["recibo"], "id_usuario");
                if ($id_usuario > 0) {
                    $data["usuario"] = $this->app->usuario($id_usuario);
                }
                $this->app->pagina($data, form_fecha_recordatorio($data, $this->get_tipo_recordatorio()), 1);

            } else {

                $id_usuario = pr($recibo, "id_usuario");


                $data += [

                    "domicilio" => $this->get_domicilio_entrega($id_recibo, $recibo),
                    "usuario" => $this->get_usuario($id_usuario),
                    "status_ventas" => $this->get_estatus_enid_service(),
                    "tipificaciones" => $this->get_tipificaciones($id_recibo),
                    "comentarios" => $this->get_recibo_comentarios($id_recibo),
                    "recordatorios" => $this->get_recordatorios($id_recibo),
                    "id_recibo" => $id_recibo,
                    "tipo_recortario" => $this->get_tipo_recordatorio(),
                    "num_compras" => $this->get_num_compras($id_usuario),
                    "servicio" => $this->app->servicio(pr($recibo, "id_servicio"))

                ];

                $this->app->pagina($data, render_pendidos($data), 1);
            }


        } else {

            $this->app->pagina($data, get_error_message(), 1);
        }

    }

    private function get_tipo_recordatorio()
    {

        return $this->app->api("tipo_recordatorio/index/format/json/");
    }

    private function get_usuario($id_usuario)
    {
        return $this->app->usuario($id_usuario);
    }

    private function get_recibo_comentarios($id_recibo)
    {

        return $this->app->api("recibo_comentario/index/format/json/", ["id_recibo" => $id_recibo]);

    }

    private function get_recordatorios($id_recibo)
    {

        return $this->app->api("recordatorio/index/format/json/", ["id_recibo" => $id_recibo]);
    }

    private function get_num_compras($id_usuario)
    {

        return $this->app->api("recibo/num_compras_usuario/format/json/", ["id_usuario" => $id_usuario]);

    }
}