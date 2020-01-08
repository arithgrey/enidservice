<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class recibo extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("recibo_model");
        $this->load->helper("recibo");
        $this->load->library('table');
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function pendientes_sin_cierre_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->recibo_model->pendientes_sin_cierre($param["id_usuario"]);
        }
        $this->response($response);

    }

    function tiempo_venta_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        $response = false;


        if (fx($param, "id_usuario,q,fecha_inicio,fecha_termino")) {

            $response = $this->recibo_model->get_tiempo_venta($param);
            if (es_data($response)) {

                $total = $this->recibo_model->get_tiempo_venta($param, 1);
                $response = $this->app->imgs_productos(0, 1, 1, 1, $response);
                $response = $this->get_costos_operativos($response,
                    $param["fecha_inicio"], $param["fecha_termino"]);
                $response = get_format_tiempo_entrega($response, $total, $param);

            }

        }
        $this->response($response);

    }

    private function get_costos_operativos($data, $fecha_inicio, $fecha_termino)
    {


        $response = [];
        $a = 0;
        foreach ($data as $row) {

            $response[$a] = $row;
            if ($fecha_inicio === $fecha_termino) {
                $fecha_termino = $fecha_inicio = "";

            }

            $ids_recibo = $this->recibo_model->get_recibo_ventas_pagas_servicio($row["id_servicio"],
                $fecha_inicio, $fecha_termino);
            $costos = (es_data($ids_recibo)) ? $this->get_text_in($ids_recibo) : [];
            $response[$a]["total_costos_operativos"] = $costos;
            $a++;

        }

        return $response;

    }

    private function get_text_in($data)
    {

        $response = [];
        $total = 0;
        foreach ($data as $row) {

            $response[] = $row["recibo"];
            $total = ($total + $row["saldo_cubierto"]);
        }

        $response = add_fields($response);

        $res = [
            "total_costos" => intval($this->get_sumatoria_costos_operativos($response)),
            "total_pagos" => $total,
        ];

        return $res;
    }

    private function get_sumatoria_costos_operativos($in)
    {

        $q["in"] = $in;

        return $this->app->api("costo_operacion/qsum/format/json/", $q);

    }

    function saldo_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->recibo_model->get_saldo_usuario($param);
        }
        $this->response($response);
    }

    function cancelar_envio_recordatorio_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->recibo_model->q_up("cancela_email", 1, $param["id"]);
        }
        $this->response($response);
    }

    function servicio_ppfp_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo")) {

            $recibo = $this->recibo_model->q_get(["id_servicio"], $param["id_recibo"]);
            $response = pr($recibo, "id_servicio", 0);

        }
        $this->response($response);
    }

    function saldo_pendiente_recibo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo")) {
            $response = $this->get_saldo_pendiente_recibo($param);
        }
        $this->response($response);
    }

    function get_saldo_pendiente_recibo($param)
    {

        $response = 0;
        $recibo = $this->recibo_model->q_get(
            [
                "monto_a_pagar",
                "num_ciclos_contratados",
                "flag_envio_gratis",
            ],
            $param["id_recibo"]
        );

        if (es_data($recibo)) {

            $recibo = $recibo[0];
            $monto_a_pagar = $recibo["monto_a_pagar"];
            $num_ciclos_contratados = $recibo["num_ciclos_contratados"];
            $costo_envio = get_costo_envio($recibo);
            $response = ($monto_a_pagar * $num_ciclos_contratados) + $costo_envio["costo_envio_cliente"];
        }

        return $response;
    }

    function orden_de_compra_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario,id_ciclo_facturacion,talla")) {

            $response = $this->recibo_model->crea_orden_de_compra($param);
        }
        $this->response($response);
    }

    function precio_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $response = $this->recibo_model->get_precio_servicio($param);
        }
        $this->response($response);

    }

    function compras_efectivas_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        if (fx($param, "modalidad,id_usuario")) {


            $compras = $this->recibo_model->compras_ventas_efectivas_usuario($param);
            $compras = $this->app->imgs_productos(0, 1, 1, 1, $compras);
            $response = d(create_listado_compra_venta($compras, $param["modalidad"]), 1);
        }

        $this->response($response);
    }

    function get_estatus_servicio_enid_service($q)
    {
        return $this->app->api("status_enid_service/servicio/format/json/", $q);
    }

    function recibos_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "modalidad")) {

            $response["total"] = 0;
            $modalidad = $param["modalidad"];
            $param["id_usuario"] = $id_usuario = $this->id_usuario;
            $ordenes = $this->recibo_model->get_compras_usuario($param, $modalidad);
            $ordenes = $this->add_imgs_servicio($ordenes);

            if (es_data($ordenes)) {

                $data = [
                    "id_usuario" => $id_usuario,
                    "ordenes" => $ordenes,
                    "modalidad" => $modalidad,
                    "id_perfil" => $this->app->getperfiles(),
                    "total" => count($ordenes)
                ];

                $response = get_vista_cliente($data);

            }
        }
        $this->response($response);

    }

    private function add_imgs_servicio($ordenes)
    {

        $a = 0;
        $response = [];
        foreach ($ordenes as $row) {

            $orden = $row;
            $id_servicio = $ordenes[$a]["id_servicio"];
            $orden["url_img_servicio"] = $this->app->imgs_productos($id_servicio, 1, 1,
                1);
            $a++;
            $response[] = $orden;
        }

        return $response;
    }

    function agrega_estados_direcciones_a_pedidos($ordenes_compra)
    {

        $ordenes = [];
        $a = 0;
        foreach ($ordenes_compra as $row) {

            $ordenes[$a] = $row;
            $ordenes[$a]["direccion_registrada"] = ($row["status"] == 6) ? 0 : 1;
            $a++;
        }

        return $ordenes;
    }

    private function get_tipos_entregas()
    {

        return $this->app->api("tipo_entrega/index/format/json/");
    }

    function resumen_desglose_pago_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo", 1)) {
            $recibo = $this->recibo_model->q_get([], $param["id_recibo"]);
            if (es_data($recibo)) {

                $r = $recibo[0];
                $id_servicio = $r["id_servicio"];
                $dc = [
                    "url_request" => get_url_request(""),
                    "recibo" => $recibo,
                    "id_recibo" => $param["id_recibo"],
                    "tipos_entregas" => $this->get_tipos_entregas()

                ];


                $url_img = $this->app->imgs_productos($id_servicio, 1, 1, 1);
                $dc["servicio"] = $this->app->servicio($id_servicio);


                if (($r["monto_a_pagar"] > $r["saldo_cubierto"]) || pr($dc["servicio"],
                        "flag_servicio") > 0) {

                    if (pr($dc["servicio"], "flag_servicio") > 0) {

                        $dc += [
                            "usuario_venta" => $this->app->usuario($r["id_usuario_venta"]),
                            "modalidad" => 1,
                        ];

                        $response = notificacion_cotizacion($dc);

                    } else {

                        $response = $this->ticket_pendiente_pago($param, $recibo, $dc,
                            $url_img);

                    }


                } else {


                    $dc += [
                        "usuario_venta" => $this->app->usuario($r["id_usuario_venta"]),
                        "modalidad" => 1,
                    ];

                    $response = notificacion_pago_realizado($dc);

                }
            }
        }
        $this->response($response);
    }

    function ticket_pendiente_pago($param, $recibo, $dc, $url_img)
    {
        $response = false;

        if (es_data($recibo)) {

            $r = $recibo[0];
            $dc["costo_envio_sistema"] = get_costo_envio($r);

            if ($r["tipo_entrega"] == 1) {

                return $this->ticket_pendiente_pago_contra_entrega($param, $recibo, $dc,
                    $url_img);

            } else {

                if (prm_def($param, "cobranza") > 0) {

                    $dc = $this->get_data_saldo($param, $recibo, $dc);
                    $dc["es_punto_encuentro"] = 0;
                    $response = $this->pagar($dc, $url_img);


                } else {

                    $usuario = $this->app->usuario($r["id_usuario"]);
                    $response = $this->get_mensaje_no_aplica(
                        $recibo, get_costo_envio($r), $usuario, $dc);
                }

            }
        }

        return $response;

    }

    function ticket_pendiente_pago_contra_entrega($param, $recibo, $dc, $url_img_servicio)
    {

        $id_recibo = $param["id_recibo"];
        $response = false;
        $dc["es_punto_encuentro"] = 0;

        if (es_data($recibo)):

            $r = $recibo[0];
            if (prm_def($param, "cobranza") == 1) :

                if ($r["entregado"] == 0 && $r["se_cancela"] == 0):

                    $id = $this->get_punto_encuentro($this->get_punto_encuentro_recibo($id_recibo));
                    $dc["punto_encuentro"] = $id;
                    $dc["es_punto_encuentro"] = 1;
                    $response = $this->pagar($dc,
                        $url_img_servicio);

                endif;

            else:

                $usuario = $this->app->usuario($r["id_usuario"]);
                $response = $this->get_mensaje_no_aplica($recibo, get_costo_envio($r[0]),
                    $usuario, $dc);
            endif;

        endif;

        return $response;
    }

    private function get_punto_encuentro($id_punto_encuentro)
    {

        $q["id"] = $id_punto_encuentro;

        return $this->app->api("punto_encuentro/id/format/json/", $q);
    }

    private function get_punto_encuentro_recibo($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        $ppfppe = $this->app->api("proyecto_persona_forma_pago_punto_encuentro/punto_encuentro_recibo/format/json/",
            $q);

        return pr($ppfppe, "id_punto_encuentro", 0);

    }

    private function pagar($dc, $url_img)
    {

        $response = [];
        $recibo = $dc["recibo"];
        $tipos_entrega = $dc["tipos_entregas"];

        if (es_data($recibo)):

            $r = $recibo[0];
            $data["recibo"] = $r;
            $url_request = $dc["url_request"];
            $monto_a_pagar = $r["monto_a_pagar"];
            $id_recibo = $r["id_proyecto_persona_forma_pago"];
            $id_usuario_venta = $r["id_usuario_venta"];
            $resumen_pedido = $r["resumen_pedido"];
            $checkout = format_concepto(
                $resumen_pedido,
                $url_img,
                $monto_a_pagar,
                $recibo,
                $tipos_entrega
            );
            $pedido[] = $checkout['checkout_resumen'];
            $data_checkout = $checkout['checkout'];
            $seccion_compra = getPayButtons($r, $url_request, $id_usuario_venta, $data_checkout);
            $pedido[] = rastreo_compra($id_recibo);

            $response[] = dd($seccion_compra, $pedido, 5);

        endif;

        return append($response);


    }

    private function get_mensaje_no_aplica(
        $recibo,
        $costo_envio_sistema,
        $usuario,
        $data_complete
    )
    {


        $response = false;
        if (es_data($recibo) && es_data($data_complete["servicio"])) {

            $r = $recibo[0];
            $u = $usuario[0];
            $envio_sistema = $costo_envio_sistema["costo_envio_cliente"];
            $saldo_cubierto = $r["saldo_cubierto"];
            $fecha_registro = $r["fecha_registro"];
            $fecha_vencimiento = $r["fecha_vencimiento"];
            $monto_a_pagar = $r["monto_a_pagar"];
            $id_proyecto_persona_forma_pago = $r["id_proyecto_persona_forma_pago"];
            $id_recibo = $id_proyecto_persona_forma_pago;
            $envio_cliente = $r["costo_envio_cliente"];
            $id_ciclo_facturacion = $r["id_ciclo_facturacion"];
            $num_ciclos_contratados = $r["num_ciclos_contratados"];
            $envio_vendedor = $r["costo_envio_vendedor"];
            $resumen_pedido = $r["resumen_pedido"];

            $id_usuario = $u["id_usuario"];
            $nombre = $u["nombre"];
            $a_paterno = ($u["apellido_paterno"] !== null) ? $u["apellido_paterno"] : "";
            $a_materno = ($u["apellido_materno"] !== null) ? $u["apellido_materno"] : "";

            $cliente = $nombre . " " . $a_paterno . " " . $a_materno;
            $envio_cliente = ($envio_sistema > $envio_vendedor) ? $envio_sistema : $envio_cliente;
            $saldo_pendiente = ($monto_a_pagar * $num_ciclos_contratados) - $saldo_cubierto;


            $servicio = $data_complete["servicio"][0];
            $es_servicio = $servicio["flag_servicio"];
            $text_envio_cliente_sistema = "";
            if ($es_servicio == 0) {
                $saldo_pendiente = $saldo_pendiente + $envio_cliente;
                $text_envio_cliente_sistema = key_exists_bi($costo_envio_sistema,
                    "text_envio", "cliente");
            }


            $url_request = "https://enidservices.com/inicio/";
            $url_pago_oxxo = _text(
                $url_request,
                "orden_pago_oxxo/?q=",
                $saldo_pendiente,
                "&q2=",
                $id_recibo,
                "&q3=",
                $id_usuario
            );

            $url_pago_paypal = "https://www.paypal.me/eniservice/" . $saldo_pendiente;
            $config_log = [
                'src' => "https://enidservices.com/inicio/img_tema/enid_service_logo.jpg",
                'width' => '100',
            ];
            $img_oxxo = "https://enidservices.com/inicio/img_tema/pago-oxxo.jpeg";
            $img_paypal = "https://enidservices.com/inicio/img_tema/explicacion-pago-en-linea.png";
            $url_seguimiento_pago = $url_request . "pedidos/?seguimiento=$id_recibo&notificar=1";


            $r[] = saludo($cliente, $config_log, $id_recibo);

            $r[] = text_saldo_pendiente(
                $resumen_pedido,
                $num_ciclos_contratados,
                $es_servicio,
                $id_ciclo_facturacion,
                $text_envio_cliente_sistema,
                $fecha_registro,
                $fecha_vencimiento,
                $monto_a_pagar,
                $saldo_pendiente
            );

            $r[] = text_forma_pago(
                $img_oxxo,
                $url_pago_oxxo,
                $url_pago_paypal,
                $img_paypal
            );

            $r[] = get_text_notificacion_pago($url_seguimiento_pago);

            $response = d(append($r), 'w-100');
        }

        return $response;

    }

    private function get_data_saldo($param, $recibo, $response)
    {

        if (es_data($recibo)) {

            $response += [
                "id_recibo" => $param["id_recibo"],
                "id_usuario_venta" => $recibo[0]["id_usuario_venta"],
                "informacion_envio" => [],
                /*"recibo" => $recibo*/
            ];
        }

        return $response;
    }

    function pedidos_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "fecha_inicio,fecha_termino,tipo_entrega,recibo,v")) {

            $params = [
                "p.id_proyecto_persona_forma_pago recibo",
                "p.saldo_cubierto",
                "p.fecha_registro",
                "p.monto_a_pagar",
                "p.num_ciclos_contratados",
                "p.cancela_cliente",
                "p.se_cancela",
                "p.status",
                "p.fecha_contra_entrega",
                "p.tipo_entrega",
                "p.fecha_entrega",
                "p.costo_envio_cliente",
                "p.id_servicio",
                "p.fecha_cancelacion",
                "p.fecha_pago",
            ];
            if ($param["recibo"] > 0) {
                /*Busqueda por número recibo*/
                $params = [
                    "id_proyecto_persona_forma_pago recibo",
                    "saldo_cubierto",
                    "fecha_registro",
                    "monto_a_pagar",
                    "num_ciclos_contratados",
                    "cancela_cliente",
                    "se_cancela",
                    "status",
                    "fecha_contra_entrega",
                    "tipo_entrega",
                    "fecha_entrega",
                    "costo_envio_cliente",
                    "id_servicio",
                    "fecha_cancelacion",
                    "fecha_pago",
                ];

                $response = $this->recibo_model->q_get($params, $param["recibo"]);

            } else {


                $response = $this->recibo_model->get_q($params, $param);
            }
            if ($param["v"] == 1) {
                $response = $this->add_imgs_servicio($response);
                $response = render_resumen_pedodos($response,
                    $this->get_estatus_enid_service($param), $param);

            }
        }
        $this->response($response);

    }

    function get_estatus_enid_service($q)
    {

        return $this->app->api("status_enid_service/index/format/json/", $q);
    }

    function fecha_entrega_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "fecha_entrega,horario_entrega,recibo")) {

            $fecha_contra_entrega = $param["fecha_entrega"] . " " . $param["horario_entrega"] . ":00";
            $response = $this->recibo_model->set_fecha_contra_entrega($param["recibo"],
                $fecha_contra_entrega);
        }

        $this->response($response);
    }

    function recibo_por_pagar_usuario_GET()
    {

        $param = $this->get();
        $respose = false;
        if (fx($param, "id_recibo")) {
            $respose = $this->recibo_model->valida_recibo_por_pagar_usuario($param);
            $respose = crea_data_deuda_pendiente($respose);
        }
        $this->response($respose);
    }

    function cancelar_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_recibo")) {
            $respose = $this->recibo_model->cancela_orden_compra($param);
        }
        $this->response($respose);

    }

    function deuda_cliente_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->recibo_model->get_adeudo_cliente($param);
        }
        $this->response($response);
    }

    function dia_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, 'fecha')) {
            if ($param["fecha"] == 1) {
                $param["fecha"] = date("Y-m-d");
            }
            $response = $this->recibo_model->get_dia($param);

        }
        $this->response($response);
    }

    function id_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "id")) {

            $id_recibo = $param["id"];
            $response = $this->recibo_model->q_get([], $id_recibo);
        }
        $this->response($response);
    }

    function saldo_cubierto_PUT()
    {

        $param = $this->put();
        $response = [];
        if (fx($param, "saldo_cubierto,recibo")) {
            $response = $this->set_saldo_cubierto($param);
        }
        $this->response($response);
    }

    private function set_saldo_cubierto($param)
    {

        $param["id_recibo"] = $param["recibo"];
        $pago_pendiente = $this->get_saldo_pendiente_recibo($param);
        $response = "INGRESA UN MONTO CORRECTO SALDO POR LIQUIDAR " . $pago_pendiente . "MXN";
        if ($param["saldo_cubierto"] > 0 && $param["saldo_cubierto"] >= $pago_pendiente || ($pago_pendiente - $param["saldo_cubierto"]) < 101) {

            $response = $this->recibo_model->set_status_orden($param["saldo_cubierto"], 1,
                $param["recibo"], 'fecha_pago');

        }

        return $response;
    }

    function status_PUT()
    {

        $param = $this->put();
        if (array_key_exists("cancelacion", $param)) {
            $this->response($this->set_cancelacion($param));
        }
        if (array_key_exists("es_proceso_compra",
                $param) && $param["es_proceso_compra"] == 1) {
            $this->response($this->set_default_orden($param));
        }
        $response = false;
        if (fx($param, "saldo_cubierto,recibo,status")) {

            $this->response($this->set_status($param));

        } else {

            $this->response($response);

        }

    }

    function set_cancelacion($param)
    {

        $response = [];

        if (fx($param, "status,tipificacion,recibo")) {

            $response = $this->recibo_model->cancela_orden(0, $param["status"],
                $param["recibo"], 'fecha_cancelacion');
            if ($response == true) {
                $response = $this->add_tipificacion($param);
            }
        }

        return $response;
    }

    private function add_tipificacion($q)
    {

        return $this->app->api("tipificacion_recibo/index", $q, "json", "POST");
    }

    function set_default_orden($param)
    {
        $response = [];

        if (fx($param, "status,recibo")) {

            $params = [
                "status" => $param["status"],
                "saldo_cubierto" => 0,
            ];

            $in = ["id_proyecto_persona_forma_pago" => $param["recibo"]];
            $response = $this->recibo_model->update($params, $in);
            if ($response == true) {

                $param["tipificacion"] = 32;
                $response = $this->add_tipificacion($param);
            }
        }

        return $response;
    }

    private function set_status($param)
    {
        $param["id_recibo"] = $param["recibo"];
        $pago_pendiente = $this->get_saldo_pendiente_recibo($param);
        $response = "INGRESA UN MONTO CORRECTO SALDO POR LIQUIDAR " . $pago_pendiente . "MXN";

        if ($param["saldo_cubierto"] > 0
            &&
            $param["saldo_cubierto"] >= $pago_pendiente
            ||
            ($pago_pendiente - $param["saldo_cubierto"]) < 101) {


            $response = $this->recibo_model->notifica_entrega($param["saldo_cubierto"],
                $param["status"], $param["recibo"], 'fecha_entrega');
            $this->solicita_encuenta($param["id_recibo"]);


        }

        return $response;
    }

    private function solicita_encuenta($id_recibo)
    {

        $recibo = $this->recibo_model->q_get([
            "notificacion_encuesta",
            "id_usuario",
            "id_servicio",
        ], $id_recibo);

        if (es_data($recibo)) {
            $r = $recibo[0];
            if ($r["notificacion_encuesta"] < 1) {
                $id_usuario = $r["id_usuario"];
                $usuario = $this->app->usuario($id_usuario);
                if (es_data($usuario)) {
                    if (es_email_valido($usuario[0]["email"]) > 0) {
                        $sender = notificacion_solicitud_valoracion($usuario,
                            $r["id_servicio"]);
                        $this->app->send_email($sender, 1);
                        $this->recibo_model->q_up("notificacion_encuesta", 1, $id_recibo);
                    }
                }
            }
        }
    }

    function tipo_entrega_PUT()
    {

        $param = $this->put();
        $response = [];
        if (fx($param, "recibo,tipo_entrega")) {
            $response = $this->recibo_model->q_up("tipo_entrega", $param["tipo_entrega"],
                $param["recibo"]);
            if ($response) {
                $param["tipificacion"] = 31;
                $this->add_tipificacion($param);
            }
        }
        $this->response($response);

    }

    function notificacion_pago_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "recibo")) {
            $response = $this->recibo_model->q_up("notificacion_pago", 1,
                $param["recibo"]);
        }
        $this->response($response);
    }

    function compras_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino,tipo")) {

            $compras = $this->recibo_model->get_compras_tipo_periodo($param);
            if ($param["v"] == 1) {
                $response = get_view_compras($this->status_enid(), $compras,
                    $param["tipo"]);
            }
        }
        $this->response($response);


    }

    private function status_enid($q = [])
    {
        return $this->app->api("status_enid_service/index/format/json/", $q);
    }

    function solicitudes_periodo_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio,tipo")) {

            $interval = "";
            switch ($param["tipo"]) {
                case 1;

                    $interval = " - 1 MONTH ";

                    break;

                case 3:
                    $interval = " - 3 MONTH ";

                    break;

                case 6:
                    $interval = " - 6 MONTH ";

                    break;

                case 12;

                    $interval = " - 1 YEAR ";

                    break;
            }

            $id_servicio = $param["id_servicio"];
            $response = [
                "solicitudes" => $this->recibo_model->get_solicitudes_periodo_servicio($id_servicio,
                    $interval),
                "entregas" => $this->recibo_model->get_solicitudes_entregadas_periodo_servicio($id_servicio,
                    $interval),
            ];

        }
        $this->response($response);
    }

    function compras_por_enviar_GET()
    {

        $this->response($this->recibo_model->get_compras_por_enviar());
    }

    function num_compras_usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->recibo_model->get_total_compras_usuario($param["id_usuario"]);
        }
        $this->response($response);
    }

    function recibo_por_enviar_usuario_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo,id_usuario")) {

            $this->response(crea_data_deuda_pendiente($this->recibo_model->valida_recibo_por_enviar_usuario($param)));
        }

        $this->response($response);

    }

    function agenda_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id", 1)) {

            $this->app->set_userdata("agenda_pedido", $param["id"]);
            $response = true;

        }
        $this->response($response);
    }

}
