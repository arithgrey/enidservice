<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_transaccion($id_recibo)
    {

        $r[] = div(img_enid(), ["style" => "width: 200px;"]);
        $r[] = heading_enid("Detalles de la transacción", 2);
        $r[] = heading_enid("#Recibo: " . $id_recibo, 3);
        $r[] = hr();
        return append_data($r);

    }

    function validate_format_cancelacion($total_cubierto, $id_recibo, $modalidad)
    {


        $text = ($total_cubierto < 1) ?
            anchor_enid("CANCELAR VENTA",
                [
                    "class" => "cancelar_compra padding_10",
                    "id" => $id_recibo,
                    "modalidad" => $modalidad,
                    "style" => "background: #f00 !important;color:white !important;font-weight: bold !important;"
                ],
                1
            ) : "";

        return $text;

    }

    function get_notificacion_solicitud_valoracion($usuario, $id_servicio)
    {

        $nombre = $usuario[0]["nombre"];
        $email = $usuario[0]["email"];
        $asunto = "Hola  {$nombre} ¡Tu paquete ya se entregó! ";

        $url = "https://enidservice.com/inicio/valoracion/?servicio=" . $id_servicio;
        $r[] = img_enid([], 1, 1);
        $r[] = heading("¿Valorarías tu experiencia de compra en Enid Service?", 3);
        $r[] = div("Nos encantará hacer todo lo necesario para que tu experiencia de compra sea la mejor");
        $r[] = div(anchor_enid("Déjanos tus comentarios aquí!", ["href" => $url]));

        $cuerpo = append_data([$r]);
        $sender = get_request_email($email, $asunto, $cuerpo);
        return $sender;

    }

    function get_saludo($cliente, $config_log, $id_recibo)
    {

        $r[] = heading_enid("Buen día " . $cliente . ", Primeramente un cordial saludo. ", 3);
        $r[] = div("El presente mensaje es para informar que el servicio solicitado ahora (Nueva Compra) o previamente (Recordatorio de Renovación) tiene los siguientes detalles:");
        $r[] = div("Detalles de Orden de Compra");
        $r[] = div(img($config_log));
        $r[] = heading_enid("#Recibo: " . $id_recibo);
        return append_data($r);
    }

    function get_text_saldo_pendiente($resumen_pedido,
                                      $num_ciclos_contratados, $flag_servicio, $id_ciclo_facturacion,
                                      $text_envio_cliente_sistema, $primer_registro, $fecha_vencimiento,
                                      $monto_a_pagar, $saldo_pendiente)
    {


        $resumen_pedido = ($resumen_pedido !== null) ? $resumen_pedido : " ";

        $r[] = div("Concepto");
        $r[] = div($resumen_pedido);
        $r[] = valida_texto_periodos_contratados($num_ciclos_contratados, $flag_servicio, $id_ciclo_facturacion);
        $r[] = div("Precio " . $monto_a_pagar);
        $r[] = div($text_envio_cliente_sistema);
        $r[] = div("Ordén de compra {$primer_registro } Límite de pago  {$fecha_vencimiento} ");
        $r[] = div("Monto total pendiente");
        $r[] = heading_enid($saldo_pendiente . " Pesos Mexicanos", 2);
        $r[] = hr();

        return append_data($r);

    }

    function get_text_forma_pago($img_pago_oxxo, $url_pago_oxxo, $url_pago_paypal, $img_pago_paypal)
    {


        $r[] = heading_enid("Formas de pago Enid Service", 2);
        $r[] = heading_enid("NINGÚN CARGO A TARJETA ES AUTOMÁTICO. SÓLO PUEDE SER PAGADO POR ACCIÓN DEL USUARIO ", 2);
        $r[] = div("1.- Podrás compra en línea de forma segura con tu con tu tarjeta bancaria (tarjeta de crédito o débito) a través de");
        $r[] = anchor($url_pago_paypal, "PayPal");
        $r[] = anchor($url_pago_paypal, img($img_pago_paypal));
        $r[] = anchor($url_pago_paypal, "Comprar ahora!");
        $r[] = hr();
        $r[] = div("2.- Aceptamos pagos en tiendas de autoservicio OXXO y transferencia bancaria en línea para bancos BBVA Bancomer", 1);
        $r[] = anchor($url_pago_oxxo, heading_enid("OXXO", 4));
        $r[] = anchor($url_pago_oxxo, "Imprimir órden de pago");
        $r[] = anchor($url_pago_oxxo, img($img_pago_oxxo));
        return append_data($r);

    }

    function get_text_notificacion_pago($url_seguimiento_pago, $url_cancelacion)
    {

        $r[] = heading_enid("¿Ya realizaste tu pago?", 2);
        $r[] = div("Notifica tu pago para que podamos procesarlo");
        $r[] = anchor_enid("Dando click aquí", ["href" => $url_seguimiento_pago]);
        return append_data($r);

    }

    function create_resumen_pedidos($recibos, $lista_estados, $param)
    {

        $tipo_orden = $param["tipo_orden"];
        $ops_tipo_orden = ["", "fecha_registro", "fecha_entrega", "fecha_cancelacion", "fecha_pago", "fecha_contra_entrega"];
        $ops_tipo_orden_text = ["", "FECHA REGISTRO", "FECHA ENTREGA", "FECHA CANCELACIÓN", "FECHA DE PAGO", "FECHA CONTRA ENTREGA"];

        $default = ["class" => "header_table_recibos"];
        $tb = hr() . "<table class='table_enid_service top_20' ><thead>";
        $tb .= "<tr class='header_table'>";
        $tb .= get_th("ORDEN", $default);
        $tb .= get_th("", $default);
        $tb .= get_th("STATUS", $default);
        $tb .= get_th("TIPO ENTREGA", $default);
        $tb .= get_th("SALDO CUBIERTO", $default);
        $tb .= get_th("MONTO COMPRA", $default);
        $tb .= get_th($ops_tipo_orden_text[$tipo_orden], $default);
        $tb .= "</thead></tr><tbody>";
        foreach ($recibos as $row) {

            //$fecha_contra_entrega = $row["fecha_contra_entrega"];
            //$fecha_entrega = $row["fecha_entrega"];


            $recibo = $row["recibo"];
            $saldo_cubierto = $row["saldo_cubierto"];
            $fecha_registro = $row["fecha_registro"];
            $monto_a_pagar = $row["monto_a_pagar"];

            $num_ciclos_contratados = $row["num_ciclos_contratados"];
            $costo_envio_cliente = $row["costo_envio_cliente"];
            $monto_a_pagar = ($monto_a_pagar * $num_ciclos_contratados) + $costo_envio_cliente;
            $cancela_cliente = $row["cancela_cliente"];
            $se_cancela = $row["se_cancela"];
            $status = $row["status"];
            $tipo_entrega = $row["tipo_entrega"];


            $estado_compra = ($se_cancela == 1 || $cancela_cliente == 1) ? "CANCELACIÓN" : 0;
            $estado_compra = ($estado_compra == 0) ? get_text_status($lista_estados, $status) : $estado_compra;
            $tipo_entrega = ($tipo_entrega == 1) ? "PAGO CONTRA ENTREGA" : "MENSAJERÍA";
            $entrega = $row[$ops_tipo_orden[$tipo_orden]];


            $extra = ($status == 9) ? "entregado" : "";


            $tb .= "<tr id='" . $recibo . "' class='desglose_orden cursor_pointer entregado" . $extra . "' >";

            $id_servicio = $row["id_servicio"];
            $url_img = $row["url_img_servicio"];
            $id_error = "imagen_" . $id_servicio;
            $img = img([
                "src" => $url_img,
                "id" => $id_error,
                "style" => "width:40px!important;height:40px!important;",
                'onerror' => "reloload_img( '" . $id_error . "','" . $url_img . "');"
            ]);
            $tb .= get_td($recibo);
            $tb .= get_td($img);
            $tb .= get_td($estado_compra);
            $tb .= get_td($tipo_entrega);
            $tb .= get_td($saldo_cubierto . "MXN");
            $tb .= get_td($monto_a_pagar . "MXN");
            $tb .= get_td($entrega);

            $tb .= "</tr>";

        }

        $tb .= "</tbody>";
        $tb .= "</table>";
        return $tb;
    }

    function get_text_status($lista, $estado_compra)
    {

        foreach ($lista as $row) {

            $id_estatus_enid_service = $row["id_estatus_enid_service"];
            if ($estado_compra == $id_estatus_enid_service) {
                return strtoupper($row["text_vendedor"]);
            }
        }
    }

    function get_link_paypal($saldo_pendiente)
    {

        if ($saldo_pendiente > 0) {
            /*Aplico la comisión del paypal 3**/
            $comision_paypal = porcentaje($saldo_pendiente, 3.7, 2, 0);
            $saldo = $saldo_pendiente + $comision_paypal;
            return "https://www.paypal.me/eniservice/" . $saldo;
        }
        return 0;

    }


    function get_link_saldo_enid($id_usuario, $id_recibo)
    {
        return "../movimientos/?q=transfer&action=8&operacion=" . $id_usuario . "&recibo=" . $id_recibo;
    }


    function get_link_oxxo($url_request, $saldo, $id_recibo, $id_usuario)
    {

        $url = $url_request . "orden_pago_oxxo/?q=" . $saldo . "&q2=" . $id_recibo . "&q3=" . $id_usuario;
        $url = ($saldo > 0 && $id_recibo > 0 && $id_usuario > 0) ? $url : "";
        return $url;

    }

    function get_saldo_pendiente($monto,
                                 $ciclos,
                                 $cubierto,
                                 $envio_cliente,
                                 $envio_sistema,
                                 $tipo_entrega)
    {


        $cubierto = ($cubierto < 0) ? 0 : $cubierto;
        $total = ($monto > 0 && $ciclos > 0) ? ($monto * $ciclos) - $cubierto : 0;


        $cargo_envio = 0;


        if ($tipo_entrega == 2 || $tipo_entrega == 4) {

            $text_envio = $envio_sistema["text_envio"]["cliente"];
            $cargo_envio = $envio_sistema["costo_envio_cliente"];


        } else {


            $text_envio = ($envio_cliente > 0) ? "Cargos de entrega " . $envio_cliente . "MXN" : $envio_sistema["text_envio"]["cliente"];
            $cargo_envio = ($envio_cliente > 0) ? $envio_cliente : 0;

        }

        $total_mas_envio = $total + $cargo_envio;
        $response = [
            'saldo_pendiente' => $total,
            'text_envio' => $text_envio,
            'total_mas_envio' => $total_mas_envio
        ];
        return $response;

    }

    function crea_data_deuda_pendiente($param)
    {

        $response["cuenta_correcta"] = 0;
        if (count($param) > 0) {

            $recibo = $param[0];
            $precio = $recibo["precio"];
            $num_ciclos_contratados = $recibo["num_ciclos_contratados"];
            $costo_envio_cliente = $recibo["costo_envio_cliente"];
            $saldo_pendiente =
                ($precio * $num_ciclos_contratados) + $costo_envio_cliente;
            $response["saldo_pendiente"] = $saldo_pendiente;
            $response["cuenta_correcta"] = 1;
            $response["resumen"] = $recibo["resumen_pedido"];
            $response["costo_envio_cliente"] = $recibo["costo_envio_cliente"];
            $response["flag_envio_gratis"] = $recibo["flag_envio_gratis"];
            $response["id_recibo"] = $recibo["id_proyecto_persona_forma_pago"];
            $response["id_usuario"] = $recibo["id_usuario"];
            $response["id_usuario_venta"] = $recibo["id_usuario_venta"];

        }
        return $response;

    }

    function get_texto_saldo_pendiente($monto_a_liquidar, $monto_a_pagar, $modalidad_ventas)
    {

        $texto = "";
        if ($modalidad_ventas == 1) {

            if ($monto_a_liquidar > 0) {
                $text = div("MONTO DE LA COMPRA",
                        ["class" => 'text-saldo-pendiente']) .
                    div($monto_a_pagar . "MXN",
                        ["class" => "text-saldo-pendiente-monto"]);
            }
        } else {

            if ($monto_a_liquidar > 0) {

                $text = div("SALDO PENDIENTE", ["class" => 'text-saldo-pendiente']);
                $text .= div($monto_a_liquidar . "MXN", ["class" => "text-saldo-pendiente-monto"]);
            }

        }
        return div($texto, ["class" => 'contenedor-saldo-pendiente']);

    }

    function monto_pendiente_cliente($monto, $saldo_cubierto, $costo, $num_ciclos)
    {

        $total_deuda = $monto * $num_ciclos;
        return $total_deuda + $costo;
    }

    function evalua_acciones_modalidad_anteriores($num_acciones, $modalidad_ventas)
    {

        $text = "";
        if ($num_acciones > 0) {
            if ($modalidad_ventas == 1) {
                $text = ($num_acciones > 1) ? "MIRA TUS ÚLTIMAS $num_acciones  VENTAS" : "MIRA TUS ULTIMAS VENTAS";
            } else {
                $text = "MIRA TUS ÚLTIMAS COMPRAS";
            }
            $config = ["class" => " ver_mas_compras_o_ventas"];
            return div(anchor_enid(heading_enid($text, 3), $config), ["class" => "col-lg-12 border_bottom top_50 bottom_50"]);
        }
        return $text;
    }

    function evalua_acciones_modalidad($en_proceso, $modalidad_ventas)
    {

        $text = "";
        $flag = 0;
        $simbolo = icon("fa  fa-fighter-jet");
        if ($modalidad_ventas == 0 && $en_proceso["num_pedidos"] > 0) {
            $flag++;
            $num = $en_proceso["num_pedidos"];
            $text = ($num > 1) ? $simbolo . " TUS " . $num . " PEDIDOS ESTÁN EN CAMINO " : $simbolo . " TU PEDIDO ESTÁ EN CAMINO ";
        }
        if ($modalidad_ventas == 1 && $en_proceso["num_pedidos"] > 0) {
            $flag++;
            $num = $en_proceso["num_pedidos"];
            $text = ($num > 1) ? $simbolo . " ENVIASTÉ $num PAQUETES QUE  ESTÁN POR LLEGAR A TU CLIENTE" : $simbolo . " TU ENVÍO ESTÁ EN CAMINO ";

        }

        $final = (strlen($text) > 10) ? div($text, ["class" => "alert alert-info text-center"]) : $text;
        return $final;

    }

    function get_total_articulos_promocion($modalidad)
    {

        $response = "";
        if ($modalidad > 0) {

            $l = anchor_enid(
                icon("fa fa-cart-plus") . " Artículos en promoción ",
                [
                    "href" => '../planes_servicios/',
                    "class" => 'black vender_mas_productos text-uppercase letter-spacing-5'

                ]
            );

            $l2 = anchor_enid(
                " Agregar",
                [
                    "href" => '../planes_servicios/?action=nuevo',
                    "class" => 'black vender_mas_productos text-uppercase letter-spacing-5']
            );

            $response = get_btw(div($l), div($l2), " col-lg-8 col-lg-offset-2 d-flex align-items-center justify-content-between top_30");
        }
        return $response;
    }

    function evalua_texto_envios_compras($modalidad_ventas, $total, $tipo)
    {


        $text = "";

        switch ($tipo) {
            case 1:
                if ($modalidad_ventas == 1) {
                    $text = "DATE PRISA MANTÉN EXCELENTE REPUTACIÓN ENVIA TU ARTÍCULO EN VENTA DE FORMA PUNTUAL";

                    $text_2 = "
                Date prisa, 
                mantén una buena reputación enviando 
                tus  $total articulos vendidos de forma puntual";
                    $text = ($total == 1) ? $text : $text_2;

                }

                break;


            case 6:
                if ($modalidad_ventas == 0) {
                    $text = "DATE PRISA REALIZA TU COMPRA ANTES DE QUE OTRA PERSONA SE LLEVE TU 
                  PEDIDO!";
                }
                break;

            default:

                break;
        }

        $text = div($text, ['class' => 'alert alert-info', 'style' => 'margin-top: 10px;background: #001541;color: white']);
        return $text;
    }

    function get_text_direccion_envio($id_recibo, $modalidad_ventas, $direccion_registrada, $estado_envio)
    {

        $texto = "";
        if ($modalidad_ventas == 0) {

            if ($direccion_registrada == 1) {
                switch ($estado_envio) {
                    case 0:
                        $texto = icon("fa fa-bus") . "A LA BREVEDAD EL VENDEDOR TE ENVIARÁ TU PEDIDO";
                        break;

                    default:
                        $texto = icon('fa fa-bus', ["id" => $id_recibo]) . "DIRECCIÓN DE ENVÍO";
                        break;
                }

            } else {
                $texto = icon('fa fa-bus ', ["id" => $id_recibo]) .
                    "¿DÓNDE ENVIAMOS TU PEDIDO?";
            }
        } else {

            if ($direccion_registrada == 1) {
                $texto = icon('fa fa-bus ', ["id" => $id_recibo]) . "VER DIRECCIÓN DE ENVÍO";
            }
        }

        return div($texto, ["class" => "btn_direccion_envio", "id" => $id_recibo]);
    }

    function get_estados_ventas($data, $indice, $modalidad_ventas)
    {

        $nueva_data = [];
        $estado_venta = "";
        foreach ($data as $row) {
            $id_estatus_enid_service = $row["id_estatus_enid_service"];
            if ($id_estatus_enid_service == $indice) {
                if ($modalidad_ventas == 1) {
                    $estado_venta = $row["text_vendedor"];
                } else {
                    $estado_venta = $row["text_cliente"];
                }
                break;
            }
        }
        return $estado_venta;
    }

    function carga_estado_compra($id_recibo, $vendedor = 0)
    {


        $text_icono = ($vendedor == 1) ? "DETALLES DE LA COMPRA " : icon('fa fa-credit-card-alt') . "DETALLES DE TU COMPRA ";

        $text = guardar($text_icono, [
            "class" => 'resumen_pagos_pendientes',
            "id" => $id_recibo,
            "href" => "#tab_renovar_servicio",
            "data-toggle" => "tab"
        ]);
        return div($text);
    }

    function texto_costo_envio_info_publico($flag_envio_gratis, $costo_envio_cliente, $costo_envio_vendedor)
    {

        $data_complete = [];
        if ($flag_envio_gratis > 0) {

            $text = "ENTREGA GRATIS!";
            $data_complete["cliente"] = $text;
            $data_complete["cliente_solo_text"] = "ENTREGA GRATIS!";
            $data_complete["ventas_configuracion"] = "TU PRECIO YA INCLUYE EL ENVÍO";
        } else {
            $data_complete["ventas_configuracion"] = "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO";
            $text = "MÁS " . $costo_envio_cliente . " MXN DE ENVÍO";
            $data_complete["cliente_solo_text"] = "MÁS " . $costo_envio_cliente . " MXN DE ENVÍO";
            $data_complete["cliente"] = $text;
        }
        return $data_complete;
    }

    function valida_texto_periodos_contratados($periodos, $flag_servicio, $id_ciclo_facturacion)
    {

        $text = "";
        if ($flag_servicio == 1) {

            $ciclos = [
                "",
                "Anualidad",
                "Mensualidad",
                "Semana",
                "Quincena",
                "",
                "Anualidad a 3 meses",
                "Anualidad a 6 meses",
                "A convenir"];

            $ciclos_largos = [
                "",
                "Anualidades",
                "Mensualidades",
                "Semanas",
                "Quincenas",
                "",
                "Anualidades a 3 meses",
                "Anualidades a 6 meses",
                "A convenir"];


            $text_ciclos = ($periodos > 1) ? $ciclos_largos[$id_ciclo_facturacion] : $ciclos[$id_ciclo_facturacion];
            $text = "Ciclos contratados: " . $periodos . " " . $text_ciclos;
        } else {

            $text = ($periodos > 1) ? "Piezas " : "Pieza ";
            $text = heading_enid($periodos . " " . $text, 3);
        }
        return $text;
    }

    function get_text_modalidad($modalidad, $ordenes)
    {

        $text = ($modalidad == 1) ? "TUS VENTAS" : "TUS COMPRAS";
        if ($modalidad == 0 && $ordenes == 0) {
            return "";
        }
        return div(heading_enid($text, 3), 1);
    }

    function get_mensaje_compra($modalidad, $num_ordenes)
    {


        $response = "";
        if ($modalidad == 0 && $num_ordenes == 0) {
            $final = div(img([
                    "src" => "../img_tema/tienda_en_linea/carrito_compra.jpg",
                    "class" => "img_invitacion_compra"
                ])
                ,
                ["class" => "img_center_compra"]
            );

            $f = anchor_enid($final, ["href" => "../"]);
            $f .= anchor_enid(heading_enid("EXPLORAR TIENDA", 3, ["class" => "text-center text_explorar_tienda"]),
                [
                    "href" => "../"
                ]);
            $response = $f;
        }
        return $response;
    }

    function format_direccion_envio($inf, $id_recibo, $recibo)
    {
        $resumen = "";
        $resumen .= div(
            icon("fa fa-pencil",
                [
                    "class" => "btn_direccion_envio ",
                    "id" => $id_recibo,
                    "href" => "#tab_mis_pagos",
                    "data-toggle" => "tab"
                ],
                1
            ),
            ["class" => "top_20"], 1);


        $r[] = get_campo($inf, "direccion");
        $r[] = get_campo($inf, "calle");
        $r[] = get_campo($inf, "numero_exterior");
        $r[] = get_campo($inf, "numero_interior");
        $r[] = get_campo($inf, "entre_calles");
        $r[] = get_campo($inf, "cp");
        $r[] = get_campo($inf, "asentamiento");
        $r[] = get_campo($inf, "municipio");
        $r[] = get_campo($inf, "ciudad");
        $r[] = get_campo($inf, "estado");
        $resumen .= div(append_data($r), ["class" => 'texto_direccion_envio_pedido top_20']);

        $resumen .= div("¿Quíen más puede recibir tu pedido?");
        $resumen .= div(get_campo($inf, "nombre_receptor"));
        $resumen .= div(get_campo($inf, "telefono_receptor"));
        $text = div($resumen, ["class" => "informacion_resumen_envio"]);

        return $text;
    }

    function agregar_direccion_envio($id_recibo)
    {

        return div(
            icon("fa fa-bus") . " Agrega la dirección de envío de tu pedido!",
            [
                "class" =>
                    "btn_direccion_envio
								contenedor_agregar_direccion_envio_pedido
								a_enid_black cursor_pointer",
                "id" => $id_recibo,
                "href" => "#tab_mis_pagos",
                "data-toggle" => "tab"
            ],
            1
        );

    }

    function format_concepto($id_recibo, $resumen_pedido, $num_ciclos_contratados,
                             $flag_servicio, $id_ciclo_facturacion,
                             $saldo_pendiente, $url_img_servicio, $monto_a_pagar, $deuda)
    {

        $concepto = "";
        $concepto .= heading_enid("#Recibo: " . $id_recibo);
        $concepto .= div("Concepto");
        $concepto .= div($resumen_pedido);
        $concepto .= valida_texto_periodos_contratados($num_ciclos_contratados, $flag_servicio, $id_ciclo_facturacion);
        $concepto .= div("PRECIO " . span("$".$monto_a_pagar , ["class"=>"strong"]),["class"=>"top_30"]);
        $concepto .= div($deuda["text_envio"]);

        $text = div($concepto);

        $monto = heading_enid("Monto total pendiente-", 3, ['class' => 'strong']);
        $monto .= heading_enid($saldo_pendiente . "MXN", 2, ["class" => 'blue_enid ']);
        $monto .= heading_enid("Pesos Mexicanos", 4, ["class" => 'strong']);

        $text .= div($monto, ["style" => "text-align: center;" , "class"=> "top_50"]);
        $text .= div(img($url_img_servicio), ["class"=> "max-height: 250px;"],1);
        return div($text, 4);

    }

    function get_format_punto_encuentro($data_complete, $recibo)
    {

        $p = $data_complete["punto_encuentro"][0];
        $costo_envio = $p["costo_envio"];
        $tipo = $p["tipo"];
        $color = $p["color"];
        $nombre_estacion = $p["nombre"];
        $lugar_entrega = $p["lugar_entrega"];
        $numero = "NÚMERO " . $p["numero"];

        $r[] = div(heading_enid("LUGAR DE ENCUENTRO", 3, ["class" => "top_30 underline "]),1);

        $x[] = div($tipo . " " . $nombre_estacion . " " . $numero . " COLOR " . $color, ["class"=> "top_20"],1);
        $x[] = div("ESTACIÓN " . $lugar_entrega, ["class" => "strong"], 1);
        $x[] = div("HORARIO DE ENTREGA: " . $recibo["fecha_contra_entrega"], 1);

        $r[] =  div(append_data($x), ["class"=> "contenedor_detalle_entrega"]);

        $r[] = div("Recuerda que previo a la entrega de tu producto, deberás realizar el pago de " . $costo_envio . " pesos por concepto de gastos de envío", ["class" => "contenedor_text_entrega border"]);

        return append_data($r);
    }

    function get_botones_seguimiento($id_recibo)
    {

        $link_seguimiento = "../pedidos/?seguimiento=" . $id_recibo;
        $t = guardar(
            "RASTREA TU PEDIDO" . icon("fa fa-map-signs"),
            [
                "class" => "top_20 text-left",
                "style" => "border-style: solid!important;border-width: 2px!important;border-color: black!important;color: black !important;background: #f1f2f5 !important;"
            ],
            1,
            1,
            0,
            $link_seguimiento
        );


        $t .= div(
            anchor_enid('CANCELAR COMPRA',
                [
                    "class" => "cancelar_compra",
                    "id" => $id_recibo,
                    "modalidad" => '0'
                ]
            ),
            ["class" => "top_20"],
            1);

        return $t;

    }

    function getPayButtons($id_recibo, $url_request, $saldo_pendiente, $id_usuario_venta)
    {


        $url_pago_oxxo = get_link_oxxo($url_request, $saldo_pendiente, $id_recibo, $id_usuario_venta);
        $url_pago_paypal = get_link_paypal($saldo_pendiente);
        $url_pago_saldo_enid = get_link_saldo_enid($id_usuario_venta, $id_recibo);

        $t = guardar(
            "PAGOS EN TIENDAS DE AUTOSERVICIO (OXXO)",
            [
                "class" => "top_10 text-left",
                "onclick" => "notifica_tipo_compra(4 ,  '" . $id_recibo . "');"

            ],
            1,
            1,
            0,
            $url_pago_oxxo
        );


        $t .= guardar(
            "A TRAVÉS DE PAYPAL",
            [
                "class" => "top_20 text-left",
                "recibo" => $id_recibo,
                "onclick" => "notifica_tipo_compra(2 ,  '" . $id_recibo . "');"
            ],
            1,
            1,
            0,
            $url_pago_paypal
        );

        $t .= guardar(
            "SALDO  ENID SERVICE",
            [
                "class" => "top_30 text-left",
                "onclick" => "notifica_tipo_compra(1 ,  '" . $id_recibo . "');"
            ],
            1,
            1,
            0,
            $url_pago_saldo_enid
        );

        return $t;

    }

    function get_vista_compras_efectivas($data, $status_enid_service)
    {

        $response = "";
        if ($data["total"] > 0) {

            $ordenes = $data["compras"];
            $listado = create_listado_compra_venta($ordenes, $status_enid_service, 1);
            $response = div($listado, 1);
        }
        return $response;

    }

    function get_vista_cliente($data)
    {

        $modalidad = $data["modalidad"];
        $ordenes = $data["ordenes"];
        $status_enid_service = $data["status_enid_service"];
        $en_proceso = $data["en_proceso"];
        $anteriores = $data["anteriores"];
        $id_perfil = $data["id_perfil"];

        $r[] = get_text_modalidad($modalidad, $ordenes);
        //$total = ($modalidad < 1) ? count($ordenes) : 0;
        $r[] = get_total_articulos_promocion($modalidad);
        $r[] = create_listado_compra_venta($ordenes, $status_enid_service, $modalidad, $id_perfil);
        $r[] = evalua_acciones_modalidad($en_proceso, $modalidad);
        $r[] = evalua_acciones_modalidad_anteriores($anteriores, $modalidad);
        $r[] = place("contenedor_ventas_compras_anteriores");
        return div(append_data($r), 1);
    }

    function create_listado_compra_venta($ordenes, $status_enid_service, $modalidad, $id_perfil = 0)
    {

        $list = [];
        foreach ($ordenes as $row) {


            $id_recibo = $row["id_proyecto_persona_forma_pago"];
            $id_servicio = $row["id_servicio"];
            $url_servicio = "../producto/?producto=" . $id_servicio;
            $url_imagen_servicio = $row["url_img_servicio"];
            $id_error = "imagen_" . $id_servicio;

            $t = anchor_enid(
                img([
                    "src" => $url_imagen_servicio,

                    "class" => 'imagen_articulo',
                    "id" => $id_error
                ]),
                ["href" => $url_servicio]
            );


            $t .= carga_estado_compra($id_recibo, $modalidad);

            if ($id_perfil == 3) {
                $url = "../pedidos/?recibo=" . $id_recibo;
                $t .= guardar("AVANZADO", [], 1, 1, 0, $url);
            }

            $list[] = div($t, ["class" => "align-items-center  d-flex flex-row border row top_20 justify-content-between "]);
        }

        if ($modalidad < 1) {


            $response = div(append_data($list), 12);
        } else {
            $response = div(append_data($list), 8, 1);

        }

        return $response;

    }

    function get_view_compras($status_enid_service, $compras, $tipo)
    {

        $response = [];
        $info_status = "";
        foreach ($status_enid_service as $row) {
            if ($row["id_estatus_enid_service"] == $tipo) {
                $info_status = strtoupper($row["nombre"]);
                break;
            }
        }

        $l = "";
        $r = [];
        foreach ($compras as $row) {

            $saldo_cubierto = $row["saldo_cubierto"];
            $fecha_registro = $row["fecha_registro"];
            $monto_a_pagar = $row["monto_a_pagar"];
            $num_email_recordatorio = $row["num_email_recordatorio"];
            $num_ciclos_contratados = $row["num_ciclos_contratados"];
            $costo_envio_vendedor = $row["costo_envio_vendedor"];
            $id_servicio = $row["id_servicio"];
            $resumen_pedido = $row["resumen_pedido"];
            $url_imagen = "../imgs/index.php/enid/imagen_servicio/" . $id_servicio;


            $response [] = img([
                "src" => $url_imagen,
                "style" => 'width: 44px!important',
                "onerror" => "this.src='../img_tema/portafolio/producto.png'"
            ]);
            $response [] = anchor_enid($resumen_pedido, ["href" => "../producto/?producto=" . $id_servicio]);

            $t = ["PRECIO", $monto_a_pagar, " MXN | COSTO DE ENVIO AL CLIENTE ", "| COSTO DE ENVIO AL VENDEDOR ", $costo_envio_vendedor, "MXN"];
            $response [] = div(append_data($t));
            $response [] = div(["ARTICULOS SOLICITADOS ", $num_ciclos_contratados, "|", "SALDO CUBIERTO", $saldo_cubierto, "MXN"]);
            $response [] = append_data([
                "LABOR DE COBRANZA",
                icon("fa fa-envelope"),
                $num_email_recordatorio
            ]);

            $response [] = div($fecha_registro);
            $r[] = div(div(append_data($response), ["class" => "popup-head-left pull-left"]), ["class" => "popup-head"]);

        }


        $r[] = heading_enid("SOLICITUDES", $info_status);
        return append_data($r);


    }

}