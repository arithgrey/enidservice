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

    function index_GET()
    {
        $param = $this->get();
        if (fx($param, "recibo")) {
            $id = $param['recibo'];
            $q = prm_def($param, 'q');
            $busqueda = (es_data($q)) ? $q : [];
            $response = $this->recibo_model->q_get($busqueda, $id);
        }
        $this->response($response);
    }

    function pendientes_sin_cierre_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,id_perfil")) {
            $response = $this->recibo_model->pendientes_sin_cierre($param["id_usuario"], $param["id_perfil"]);
            $response = $this->horarios_contra_entrega_pedidos($response);
        }
        $this->response($response);

    }

    function horarios_contra_entrega_pedidos($ordenes_compra)
    {
        $ids_contra_entrega_domicilio = [];
        foreach ($ordenes_compra as $row) {

            $tipo_entrega = $row['tipo_entrega'];
            if ($tipo_entrega == 2) {
                $ids_contra_entrega_domicilio[] = $row['id_recibo'];
            }
        }

        $recibos_domicilio = $this->get_recibos_domicilio($ids_contra_entrega_domicilio);
        $recibos_domicilio_contra_entrega_sin_domicilio =
            $this->recibos_domicilio_contra_entrega_sin_domicilio($ids_contra_entrega_domicilio, $recibos_domicilio);


        $response = $this->domicilios_contra_entrega_pedidos($ordenes_compra, $ids_contra_entrega_domicilio, $recibos_domicilio_contra_entrega_sin_domicilio);
        $this->response($response);
    }

    function domicilios_contra_entrega_pedidos($ordenes_compra, $ids_contra_entrega_domicilio, $sin_direccion_contra_entrega)
    {

        $recibos = [];
        $a = 0;
        foreach ($ordenes_compra as $row) {

            $recibos[$a] = $row;
            $id_recibo = $row['id_recibo'];
            $es_contra_entrega_domicilio = in_array($id_recibo, $ids_contra_entrega_domicilio);
            if ($es_contra_entrega_domicilio) {

                $es_contra_entrega_domicilio_sin_direccion = (in_array($id_recibo, $sin_direccion_contra_entrega));
                $recibos[$a]['es_contra_entrega_domicilio_sin_direccion'] = $es_contra_entrega_domicilio_sin_direccion;
            }
            $recibos[$a]['es_contra_entrega'] = $es_contra_entrega_domicilio;

            $a++;
        }
        return $recibos;
    }

    function recibos_domicilio_contra_entrega_sin_domicilio($ids_contra_entrega_domicilio, $recibos_domicilio)
    {


        $response = [];
        foreach ($ids_contra_entrega_domicilio as $row) {

            $id_recibo = (int)$row;
            $tiene_direccion = search_bi_array($recibos_domicilio, 'id_proyecto_persona_forma_pago', $id_recibo, FALSE, FALSE);
            if ($tiene_direccion === false) {

                $response[] = $id_recibo;
            }
        }
        return $response;

    }

    function get_recibos_domicilio($ids_contra_entrega_domicilio)
    {
        $response = [];
        if (es_data($ids_contra_entrega_domicilio)) {

            $response = $this->recibos_domicilios($ids_contra_entrega_domicilio);
        }
        return $response;
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

        return [
            "total_costos" => intval($this->get_sumatoria_costos_operativos($response)),
            "total_pagos" => $total,
        ];
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

    function pago_comision_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,monto")) {
            /*los pagos y fecha registro se mantienen en los costos operativos*/
            $response = $this->recibo_model->q_up("flag_pago_comision", 1, $param['id']);

        }
        $this->response($response);
    }

    function lista_negra_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_recibo")) {

            $id_recibo = $param['id_recibo'];
            $response = $this->recibo_model->update(
                [
                    'status' => 19,
                    'se_cancela' => 1,
                ],
                ["id_proyecto_persona_forma_pago" => $id_recibo]
            );


            $response = $this->boletina_compras($param);


        }
        $this->response($response);
    }

    function boletina_compras($param)
    {
        $telefono = prm_def($param, 'telefono');
        $response = '';
        if ($telefono > 0) {

            $response = $this->recibo_model->ordenes_por_telefono($telefono);
            $ordenes = [];
            foreach ($response as $row) {
                $ordenes[] = $row['id_proyecto_persona_forma_pago'];
            }

            if (es_data($ordenes)) {

                $response = $this->recibo_model->boletina_ordenes($ordenes);
            }
        }
        return $response;
    }

    function registro_articulo_interes_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->recibo_model->q_up("registro_articulo_interes", 1, $param['id']);

        }
        $this->response($response);
    }

    function repartidor_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "recibo,usuario")) {

            $response = $this->recibo_model->q_up("id_usuario_entrega", $param['usuario'], $param['recibo']);

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

    function reparto_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $id_recibo = $param['id'];
            $params = [
                "status" => 16,
                "saldo_cubierto" => 0,
                'se_cancela' => 0,
                'cancela_cliente' => 0
            ];

            $in = ["id_proyecto_persona_forma_pago" => $id_recibo];
            $repartidores = $this->repartidores();
            $repartidores_en_entrega = $this->recibo_model->espacios($id_recibo);
            $id_usuario = repartidor_disponible($repartidores_en_entrega, $repartidores);
            $params['id_usuario_entrega'] = $id_usuario;

            $response = $this->recibo_model->update($params, $in);
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
                "tipo_entrega"
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
        $path_servicio = [];
        $servicios = [];
        foreach ($ordenes as $row) {

            $orden = $row;
            $id_servicio = $ordenes[$a]["id_servicio"];
            if (!in_array($id_servicio, $servicios)) {
                $servicios[] = $id_servicio;
                $path = $this->app->imgs_productos($id_servicio, 1, 1, 1);
                $path_servicio[] = [
                    'id_servicio' => $id_servicio,
                    'path' => $path
                ];
                $orden["url_img_servicio"] = $path;

            } else {

                $path = search_bi_array($path_servicio, 'id_servicio', $id_servicio, 'path');
                $orden["url_img_servicio"] = $path;
            }

            $a++;
            $response[] = $orden;
        }

        return $response;
    }

    function add_comisionistas($ordenes, $param)
    {
        $id_perfil = $param['perfil'];
        $es_administrador = (!in_array($id_perfil, [20, 6]));

        if ($es_administrador) {

            return $this->append_usuarios($ordenes);

        } else {

            return $ordenes;
        }

    }

    function append_usuarios($ordenes)
    {
        $a = 0;
        $ids_usuarios = [];
        $usuarios = [];
        $response = [];

        foreach ($ordenes as $row) {

            $orden = $row;
            $id_usuario_referencia = $row['id_usuario_referencia'];
            $response[$a] = $orden;
            if (!in_array($id_usuario_referencia, $ids_usuarios)) {

                $ids_usuarios[] = $id_usuario_referencia;
                $usuario = $this->app->usuario($id_usuario_referencia);
                $busqueda_usuario =
                    [
                        'id_usuario' => $id_usuario_referencia,
                        'usuario' => $usuario
                    ];
                $response[$a]['usuario'] = $busqueda_usuario['usuario'];
                $usuarios[] = $busqueda_usuario;

            } else {
                $usuario = search_bi_array($usuarios, 'id_usuario', $id_usuario_referencia, 'usuario');
                $response[$a]['usuario'] = $usuario;
            }
            $a++;
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
            $pedido[] = rastreo_compra($id_recibo, $seccion_compra);
            $seccion_compra = d($seccion_compra, 'd-none d-md-block');
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

            $response = d($r, 'w-100');
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
        $es_usuario = ($this->id_usuario > 0 || fx($param, 'id_usuario'));

        if ($this->id_usuario > 0) {
            $param['id_usuario'] = $this->id_usuario;
        }

        if (fx($param, "fecha_inicio,fecha_termino,tipo_entrega,recibo,v,perfil") && $es_usuario) {
            $param['perfil'] = $this->app->getperfiles();

            $params = [
                "p.id_proyecto_persona_forma_pago recibo ",
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
                "p.flag_pago_comision",
                "p.comision_venta",
                "p.id_usuario_referencia",
                "p.intento_reventa",
                'p.intento_recuperacion'

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
                    "flag_pago_comision",
                    "comision_venta",
                    "id_usuario_referencia",
                    "intento_reventa",
                    'intento_recuperacion'
                ];


                $response = $this->recibo_model->q_get($params, $param["recibo"]);

            } else {


                $response = $this->recibo_model->get_q($params, $param);
            }
            if ($param["v"] == 1) {


                $response = $this->add_imgs_servicio($response);
                $response = $this->add_comisionistas($response, $param);
                $session = $this->app->session();
                $response = render_resumen_pedidos($response,
                    $this->get_estatus_enid_service($param), $param, $session);

            }
        }
        $this->response($response);

    }

    function reparto_recoleccion_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "v")) {

            $response = $this->recibo_model->reparto_recoleccion($param);
            if ($param['v'] == 1) {

                $response = $this->add_imgs_servicio($response);
                $response = cuentas_por_cobrar_reparto($response);

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
            $es_contra_entrega_domicilio = prm_def($param, 'contra_entrega_domicilio');
            $tipo_entrega = prm_def($param, 'tipo_entrega');
            $response = $this->recibo_model->set_fecha_contra_entrega(
                $param["recibo"],
                $fecha_contra_entrega,
                $es_contra_entrega_domicilio,
                $tipo_entrega
            );
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

        $response = _text_(_text_pago, money($pago_pendiente));
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
                'se_cancela' => 0,
                'cancela_cliente' => 0
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

    private
    function set_status($param)
    {
        $param["id_recibo"] = $param["recibo"];
        $pago_pendiente = $this->get_saldo_pendiente_recibo($param);
        $response = _text_(_text_pago, money($pago_pendiente));

        $saldo_cubierto = $param["saldo_cubierto"];
        $restante = ($pago_pendiente - $param["saldo_cubierto"]);
        if ($saldo_cubierto > 0 && $saldo_cubierto >= $pago_pendiente || $restante < 101) {

            $status = $param["status"];
            $recibo = $param["recibo"];
            $response = $this->recibo_model->notifica_entrega($saldo_cubierto,
                $status, $recibo, 'fecha_entrega');
            $this->solicita_encuenta($param["id_recibo"]);

        }

        return $response;
    }

    private
    function solicita_encuenta($id_recibo)
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

    private
    function status_enid($q = [])
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

            $id_usuario = $param["id_usuario"];
            $usuario = $this->app->usuario($id_usuario);
            $response = 0;
            if (es_data($usuario)) {

                $email = pr($usuario, "email");
                $tel_contacto = pr($usuario, "tel_contacto");
                $q = ["id_usuario" => $id_usuario, "email" => $email, "tel_contacto" => $tel_contacto];
                $usuarios = $this->usuarios_similares($q);
                $response = 0;
                if (es_data($usuarios)) {

                    $lista = [];
                    foreach ($usuarios as $row) {

                        $lista[] = $row['idusuario'];
                    }
                    $ids = implode(",", $lista);
                    $response = $this->recibo_model->get_total_compras_usuario($ids);
                }
            }
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

    function stags_arquetipos_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_empresa")) {

            $id_empresa = $param['id_empresa'];
            $response = $this->recibo_model->sin_tags_arquetipo($id_empresa);
        }
        $this->response($response);

    }

    function reventa_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_vendedor", 1)) {

            $id_vendedor = $param['id_vendedor'];
            $response = $this->recibo_model->reventa($id_vendedor);
        }
        $this->response($response);

    }

    function recuperacion_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_vendedor", 1)) {

            $response = $this->recibo_model->recuperacion($param['id_vendedor']);

        }
        $this->response($response);

    }


    function reventa_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "recibo", 1)) {

            $id_recibo = $param['recibo'];
            $response = $this->recibo_model->notificacion_intento_reventa($id_recibo);

        }
        $this->response($response);

    }

    function recuperacion_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "recibo", 1)) {

            $id_recibo = $param['recibo'];
            $response = $this->recibo_model->notificacion_intento_recuperacion($id_recibo);

        }
        $this->response($response);

    }

    function efectivo_en_casa_PUT()
    {
        $param = $this->put();
        $response = false;
        if (array_key_exists('recibos', $param)) {

            $recibos = $param['recibos'];
            if (es_data($recibos)) {

                $response = $this->recibo_model->recibos_efectivo_en_casa($recibos);
            }
        }
        $this->response($response);

    }

    function proximas_reparto_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,id_perfil,id_empresa")) {

            $dia = prm_def($param, 'dia');
            $id_usuario = $param["id_usuario"];
            $id_perfil = $param["id_perfil"];
            $id_empresa = $param['id_empresa'];
            $response = $this->recibo_model->proximas($id_empresa, $id_usuario, $id_perfil, $dia);
        }
        $this->response($response);
    }

    function franja_horaria_GET()
    {

        $param = $this->get();
        $response = false;
        $data = $this->app->get_session();
        if (fx($param, "franja_horaria,v")) {

            $id_usuario = $data['idusuario'];
            $id_perfil = $this->app->getperfiles();
            $id_empresa = $data['idempresa'];

            $franja_horaria = $param['franja_horaria'];
            $ordenes = $this->recibo_model->franja_horaria($franja_horaria, $id_usuario, $id_perfil, $id_empresa);
            $response = $this->add_imgs_servicio($ordenes);
            if ($param['v'] > 0) {
                $response = tracker_franja_horaria($response);
            }
        }
        $this->response($response);
    }

    function repartidores()
    {

        return $this->app->api("usuario_perfil/repartidores/format/json/");
    }

    function usuarios_similares($q)
    {

        return $this->app->api("usuario/busqueda/format/json/", $q);

    }

    function recibos_domicilios($recibos)
    {

        $response = [];
        if (es_data($recibos)) {

            $q = [
                'v' => 1,
                'ids_recibos' => get_keys($recibos)
            ];
            $response = $this->app->api("proyecto_persona_forma_pago_direccion/recibos/format/json/", $q);
        }
        return $response;

    }
}
