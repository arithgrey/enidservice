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
        $data = $this->principal->val_session();
        $this->principal->acceso();

        if (get_param_def($param, "seguimiento") > 0 && ctype_digit($param["seguimiento"])) {

            $this->carga_vista_seguimiento($param, $data);

        } else {

            $fn = (get_param_def($param, "costos_operacion") > 0 && ctype_digit($param["costos_operacion"])) ? $this->carga_vista_costos_operacion($param, $data) : $this->seguimiento_pedido($param, $data);

        }
    }

    private function carga_vista_seguimiento($param, $data)
    {

        $data = $this->principal->getCSSJs($data, "pedidos_seguimiento");
        $id_recibo = $this->input->get("seguimiento");


        $recibo = $this->get_recibo($id_recibo, 1);
        $drecibo = $recibo[0];
        $id_usuario_compra = $drecibo["id_usuario"];
        $id_usuario_venta = $drecibo["id_usuario_venta"];


        $acceso = ($id_usuario_compra == $data["id_usuario"] || $id_usuario_venta == $data["id_usuario"]) ? 1 : 0;
        if (count($recibo) > 0 && $data["in_session"] == 1 && $data["id_usuario"] > 0 && $acceso > 0) {


            $data["es_vendedor"] = ($id_usuario_venta == $data["id_usuario"]) ? 1 : 0;

            $data += [
                "domicilio" => $this->get_domicilio_entrega($id_recibo, $recibo),
                "recibo" => $recibo

            ];

            $fn = (get_param_def($param, "domicilio") > 0) ? $this->load_view_domicilios_pedidos($data) : $this->load_view_seguimiento($data, $param, $recibo, $id_recibo);


        } else {
            redirect("../../area_cliente");
        }

    }

    private function get_recibo($id_recibo, $add_img = 0)
    {

        $q["id"] = $id_recibo;

        $response = $this->principal->api("recibo/id/format/json/", $q);

        if (is_array($response) && count($response) > 0 & $add_img > 0) {

            $response[0]["url_img_servicio"] = $this->principal->get_imagenes_productos($response[0]["id_servicio"], 1, 1, 1);

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
        $q["id_recibo"] = $id_recibo;
        return $this->principal->api("proyecto_persona_forma_pago_punto_encuentro/complete/format/json/", $q);
    }

    private function get_domicilio_recibo($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        $direccion = $this->principal->api("proyecto_persona_forma_pago_direccion/recibo/format/json/", $q);
        $domicilio = [];

        if (count($direccion) > 0 && $direccion[0]["id_direccion"] > 0) {
            $id_direccion = $direccion[0]["id_direccion"];
            $domicilio = $this->get_direccion($id_direccion);
        }

        return $domicilio;
    }

    private function get_direccion($id)
    {
        $q["id_direccion"] = $id;
        $api = "direccion/data_direccion/format/json/";
        return $this->principal->api($api, $q);
    }

    private function load_view_domicilios_pedidos($data)
    {


        $id_usuario = $data["id_usuario"];
        $data += [
            "lista_direcciones" => $this->get_direcciones_usuario($id_usuario),
            "puntos_encuentro" => $this->get_puntos_encuentro($id_usuario)
        ];

        $this->principal->show_data_page($this->principal->getCSSJs($data, "pedidos_domicilios_pedidos"), 'domicilio');
    }

    private function get_direcciones_usuario($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "usuario_direccion/all/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_puntos_encuentro($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->principal->api("usuario_punto_encuentro/usuario/format/json/", $q);
    }

    private function load_view_seguimiento($data, $param, $recibo, $id_recibo)
    {

        $notificacion_pago = (get_param_def($param, "notificar") > 0) ? 1 : 0;

        $data += [
            "notificacion_pago" => ($recibo[0]["notificacion_pago"] > 0) ? 0 : $notificacion_pago,
            "orden" => $id_recibo,
            "status_ventas" => $this->get_estatus_enid_service(),
            "evaluacion" => 1,
            "tipificaciones" => $this->get_tipificaciones($id_recibo),
            "id_servicio" => $recibo[0]["id_servicio"]
        ];

        if ($recibo[0]["saldo_cubierto"] > 0 && $recibo[0]["se_cancela"] == 0 && $data["es_vendedor"] < 1) {

            $data["evaluacion"] = $this->verifica_evaluacion($recibo[0]["id_usuario"], $recibo[0]["id_servicio"]);

        }

        $this->principal->show_data_page($data, 'seguimiento');
    }

    private function get_estatus_enid_service($q = [])
    {

        return $this->principal->api("status_enid_service/index/format/json/", $q);
    }

    private function verifica_evaluacion($id_usuario, $id_servicio)
    {

        $q = [

            "id_usuario" => $id_usuario,
            "id_servicio" => $id_servicio
        ];

        return $this->principal->api("valoracion/num/format/json/", $q);

    }

    private function get_tipificaciones($id_recibo)
    {

        $q["recibo"] = $id_recibo;
        return $this->principal->api("tipificacion_recibo/recibo/format/json/", $q);
    }

    private function get_ppfp($id_recibo)
    {

        $q["id"] = $id_recibo;
        return $this->principal->api("recibo/id/format/json/", $q);

    }

    function carga_vista_costos_operacion($param, $data)
    {

        $data = $this->principal->getCssJs($data, "pedidos");
        $costos_operacion = $this->get_costo_operacion($param["costos_operacion"]);
        $this->table->set_heading(array('MONTO', 'CONCEPTO', 'REGISTO', ''));
        $total = 0;
        foreach ($costos_operacion as $row) {

            $total = $total + $row["monto"];
            $id = $row["id"];
            $icon = icon("fa fa-times ", ["onclick" => "confirma_eliminar_concepto('{$id}')"]);
            $this->table->add_row(array($row["monto"] . " MXN", $row["tipo"], $row["fecha_registro"], $icon));
        }

        $gastos = div(span("TOTAL EN GASTOS: ", " strong ") . $total . " MXN", "top_50 f12");
        $this->table->add_row(array(div($gastos), "", ""));
        $gastos = div(span("SALDADO: ", "strong") . $param["saldado"] . " MXN", "top_5 f12");

        $this->table->add_row(array(div($gastos), "", ""));

        $utilidad = $param["saldado"] - $total;
        $total = div(span("UTILIDAD:", " underline text-utilidad strong ") . $utilidad . "MXN", "top_20 ");
        $this->table->add_row(array(heading_enid($total, 4), "", ""));

        $this->table->set_template(template_table_enid());


        $recibo = $this->get_ppfp($param["costos_operacion"]);
        $id_servicio = (is_array($recibo) && count($recibo) > 0) ? $recibo[0]["id_servicio"] : 0;
        $path = $this->principal->get_imagenes_productos($id_servicio, 1, 1, 1);


        $response = get_format_costo_operacion(
            $this->table->generate(),
            $this->get_tipo_costo_operacion(),
            $param["costos_operacion"],
            $path,
            $costos_operacion,
            $recibo
        );

        $this->principal->show_data_page($data, $response, 1);


    }

    private function get_costo_operacion($id_recibo)
    {

        $q["recibo"] = $id_recibo;
        return $this->principal->api("costo_operacion/recibo/format/json/", $q);

    }

    private function get_tipo_costo_operacion()
    {

        $q["x"] = 1;
        return $this->principal->api("tipo_costo/index/format/json/", $q);

    }

    function seguimiento_pedido($param, $data)
    {


        if ($this->principal->getperfiles() != 3) {

            header("location:" . path_enid("area_cliente"));

        }

        $data = $this->principal->getCssJs($data, "pedidos");

        $data += [
            "tipos_entregas" => $this->get_tipos_entregas([]),
            "status_ventas" => $this->get_estatus_enid_service()
        ];


        $fn = (get_param_def($param, "recibo") < 1) ? $this->principal->show_data_page($data, get_form_busqueda_pedidos($data, $param), 1) : $this->load_detalle_pedido($param, $data);

    }

    private function get_tipos_entregas($q)
    {

        return $this->principal->api("tipo_entrega/index/format/json/", $q);
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

            if (get_param_def($param, "fecha_entrega") > 0) {


                $this->principal->show_data_page($data, get_form_fecha_entrega($data), 1);


            } elseif (get_param_def($param, "recordatorio") > 0) {


                $this->principal->show_data_page($data, form_fecha_recordatorio($data, $this->get_tipo_recordatorio()), 1);

            } else {

                $id_usuario = $recibo[0]["id_usuario"];

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

                ];

                $this->principal->show_data_page($data, 'detalle');
            }


        } else {

            $this->principal->show_data_page($data, get_error_message(), 1);
        }

    }

    private function get_tipo_recordatorio()
    {

        return $this->principal->api("tipo_recordatorio/index/format/json/");
    }

    private function get_usuario($id_usuario)
    {
        return $this->principal->get_info_usuario($id_usuario);
    }

    private function get_recibo_comentarios($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        return $this->principal->api("recibo_comentario/index/format/json/", $q);

    }

    private function get_recordatorios($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        return $this->principal->api("recordatorio/index/format/json/", $q);
    }

    private function get_num_compras($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->principal->api("recibo/num_compras_usuario/format/json/", $q);

    }

}