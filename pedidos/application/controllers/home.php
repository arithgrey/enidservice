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

            if (get_param_def($param, "costos_operacion") > 0 && ctype_digit($param["costos_operacion"])) {

                $this->carga_vista_costos_operacion($param, $data);

            } else {

                $this->seguimiento_pedido($param, $data);
            }


        }
    }

    private function carga_vista_seguimiento($param, $data)
    {

        $data = $this->principal->getCSSJs($data, "pedidos_seguimiento");
        $id_recibo = $this->input->get("seguimiento");
        $recibo = $this->get_recibo($id_recibo, 1);
        $id_usuario_compra = $recibo[0]["id_usuario"];
        $id_usuario_venta = $recibo[0]["id_usuario_venta"];


        $acceso = ($id_usuario_compra == $data["id_usuario"] || $id_usuario_venta == $data["id_usuario"]) ? 1 : 0;
        $data["es_vendedor"] = ($id_usuario_venta == $data["id_usuario"]) ? 1 : 0;


        if (count($recibo) > 0 && $data["in_session"] == 1 && $data["id_usuario"] > 0 && $acceso > 0) {


            $data["domicilio"] = $this->get_domicilio_entrega($id_recibo, $recibo);
            $data["recibo"] = $recibo;


            if (get_param_def($param, "domicilio") > 0) {

                $this->load_view_domicilios_pedidos($data);

            } else {

                $this->load_view_seguimiento($data, $param, $recibo, $id_recibo);
            }

        } else {
            redirect("../../area_cliente");
        }

    }

    private function get_recibo($id_recibo, $add_img = 0)
    {

        $q["id"] = $id_recibo;
        $api = "recibo/id/format/json/";
        $response = $this->principal->api($api, $q);

        if (is_array($response) && count($response) > 0 & $add_img > 0) {


            $response[0]["url_img_servicio"] = $this->principal->get_imagenes_productos($response[0]["id_servicio"], 1, 1, 1);
        }
        return $response;
    }

    private function get_domicilio_entrega($id_recibo, $recibo)
    {


        $recibo = $recibo[0];
        $tipo_entrega = $recibo["tipo_entrega"];
        $data_complete["tipo_entrega"] = $tipo_entrega;
        $domicilio = [];

        if ($tipo_entrega == 1) {
            /*Pido el punto de encuentro*/
            $domicilio = $this->get_punto_encuentro($id_recibo);

        } else {
            /*Pido el domicilio del cliente*/
            $domicilio = $this->get_domicilio_recibo($id_recibo);
        }
        $data_complete["domicilio"] = $domicilio;
        return $data_complete;
    }

    private function get_punto_encuentro($id_recibo)
    {
        $q["id_recibo"] = $id_recibo;
        $api = "proyecto_persona_forma_pago_punto_encuentro/complete/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_domicilio_recibo($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        $api = "proyecto_persona_forma_pago_direccion/recibo/format/json/";
        $direccion = $this->principal->api($api, $q);
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


        $data["lista_direcciones"] = $this->get_direcciones_usuario($data["id_usuario"]);
        $data["puntos_encuentro"] = $this->get_puntos_encuentro($data["id_usuario"]);
        $data = $this->principal->getCSSJs($data, "pedidos_domicilios_pedidos");
        $this->principal->show_data_page($data, 'domicilio');
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
        $api = "usuario_punto_encuentro/usuario/format/json/";
        return $this->principal->api($api, $q);
    }

    private function load_view_seguimiento($data, $param, $recibo, $id_recibo)
    {


        $notificacion_pago = (get_param_def($param, "notificar") > 0) ? 1 : 0;
        $notificacion_pago = ($recibo[0]["notificacion_pago"] > 0) ? 0 : $notificacion_pago;
        $data["notificacion_pago"] = $notificacion_pago;
        $data["orden"] = $id_recibo;
        $data["status_ventas"] = $this->get_estatus_enid_service();

        $data["evaluacion"] = 1;
        if ($recibo[0]["saldo_cubierto"] > 0 && $recibo[0]["se_cancela"] == 0 && $data["es_vendedor"] < 1) {

            $data["evaluacion"] = $this->verifica_evaluacion($recibo[0]["id_usuario"], $recibo[0]["id_servicio"]);

        }
        $data["tipificaciones"] = $this->get_tipificaciones($id_recibo);
        $data["id_servicio"] = $recibo[0]["id_servicio"];
        $this->principal->show_data_page($data, 'seguimiento');
    }

    private function get_estatus_enid_service($q = [])
    {
        $api = "status_enid_service/index/format/json/";
        return $this->principal->api($api, $q);
    }

    private function verifica_evaluacion($id_usuario, $id_servicio)
    {

        $q["id_usuario"] = $id_usuario;
        $q["id_servicio"] = $id_servicio;
        $api = "valoracion/num/format/json/";
        return $this->principal->api($api, $q);

    }

    private function get_tipificaciones($id_recibo)
    {

        $q["recibo"] = $id_recibo;
        $api = "tipificacion_recibo/recibo/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_servicio_ppfp($id_recibo){

        $q["id_recibo"] = $id_recibo;
        $api = "recibo/servicio_ppfp/format/json/";
        return $this->principal->api($api, $q);

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
        $this->table->add_row(array(heading_enid($total, 4) , "", ""));

        $this->table->set_template(template_table_enid());


        $path  = $this->principal->get_imagenes_productos($this->get_servicio_ppfp($param["costos_operacion"]), 1,1,1);



        $response = get_format_costo_operacion(
            $this->table->generate(),
            $this->get_tipo_costo_operacion(),
            $param["costos_operacion"],
            $path,
            $costos_operacion
        );

        $this->principal->show_data_page($data, $response, 1);



    }

    private function get_costo_operacion($id_recibo)
    {

        $q["recibo"] = $id_recibo;
        $api = "costo_operacion/recibo/format/json/";
        return $this->principal->api($api, $q);

    }

    private function get_tipo_costo_operacion()
    {

        $q["x"] = 1;
        $api = "tipo_costo/index/format/json/";
        return $this->principal->api($api, $q);

    }

    function seguimiento_pedido($param, $data)
    {

        $num_perfil = $this->principal->getperfiles();
        if ($num_perfil != 3) {
            $module = "location:../area_cliente";
            header($module);
        }

        $data = $this->principal->getCssJs($data, "pedidos");
        $es_recibo = get_param_def($param, "recibo");
        $data["tipos_entregas"] = $this->get_tipos_entregas(array());
        $data["status_ventas"] = $this->get_estatus_enid_service();


        if ($es_recibo == 0) {

            $response = get_form_busqueda_pedidos($data["tipos_entregas"], $data["status_ventas"], $param);

            $this->principal->show_data_page(
                $data
                ,
                $response
                ,
                1
            );

        } else {

            $this->load_detalle_pedido($param, $data);

        }
    }

    private function get_tipos_entregas($q)
    {
        $api = "tipo_entrega/index/format/json/";
        return $this->principal->api($api, $q);
    }

    private function load_detalle_pedido($param, $data)
    {

        if (ctype_digit($param["recibo"])) {

            $this->carga_detalle_pedido($param, $data);

        } else {
            redirect("../../?q=");
        }
    }

    private function carga_detalle_pedido($param, $data)
    {

        $id_recibo = $param["recibo"];
        $recibo = $this->get_recibo($id_recibo, 1);

        if (count($recibo) > 0) {


            $data["orden"] = $id_recibo;
            $data["recibo"] = $recibo;

            if (get_param_def($param, "fecha_entrega") > 0) {


                $this->principal->show_data_page($data, get_form_fecha_entrega($data), 1);


            } elseif (get_param_def($param, "recordatorio") > 0) {

                $tipo_recortario = $this->get_tipo_recordatorio();
                $response = form_fecha_recordatorio($data["orden"], $tipo_recortario);
                $this->principal->show_data_page($data, $response, 1);

            } else {

                $id_usuario = $recibo[0]["id_usuario"];
                $data["domicilio"] = $this->get_domicilio_entrega($id_recibo, $recibo);
                $data["usuario"] = $this->get_usuario($id_usuario);
                $data["status_ventas"] = $this->get_estatus_enid_service();
                $data["tipificaciones"] = $this->get_tipificaciones($id_recibo);
                $data["comentarios"] = $this->get_recibo_comentarios($id_recibo);
                $data["recordatorios"] = $this->get_recordatorios($id_recibo);
                $data["id_recibo"] = $id_recibo;
                $data["tipo_recortario"] = $this->get_tipo_recordatorio();
                $data["num_compras"] = $this->get_num_compras($id_usuario);

                $this->principal->show_data_page($data, 'detalle');
            }

        } else {

            $this->principal->show_data_page($data, get_error_message(), 1);
        }

    }

    private function get_tipo_recordatorio()
    {

        $q["z"] = [];
        $api = "tipo_recordatorio/index/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_usuario($id_usuario)
    {
        return $this->principal->get_info_usuario($id_usuario);
    }

    private function get_recibo_comentarios($id_recibo)
    {
        $q["id_recibo"] = $id_recibo;
        $api = "recibo_comentario/index/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_recordatorios($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        $api = "recordatorio/index/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_num_compras($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "recibo/num_compras_usuario/format/json/";
        return $this->principal->api($api, $q);

    }

}