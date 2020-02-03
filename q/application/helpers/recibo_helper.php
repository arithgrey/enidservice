<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function notificacion_cotizacion($data)
    {


        $recibo = $data["recibo"];
        $id_recibo = $data["id_recibo"];
        $usuario_venta = $data["usuario_venta"];
        $precio = pr($recibo, "precio");
        $monto_a_pagar = pr($recibo, "monto_a_pagar");
        $url_seguimiento = path_enid('pedido_seguimiento', $id_recibo);

        $response[] = get_format_transaccion($id_recibo, 1);
        $response[] = _titulo("VENDEDOR", 4);

        $usuario_venta = pr($usuario_venta, "nombre");
        $apellido = pr($usuario_venta, "apellido_materno");
        $nombre_vendedor = _text_($usuario_venta, $apellido);

        $rr[] = _titulo($nombre_vendedor, 5);

        if (strlen($usuario_venta) > 4) {

            $response[] = _titulo("información de contacto", 5);
            $telefono = pr($usuario_venta, "tel_contacto");
            $rr[] = _titulo($telefono, 5);
        }


        $response[] = d($rr);
        $resumen_pedido = pr($recibo, "resumen_pedido");

        $b[] = flex_md("DETALLES", $resumen_pedido, _between_md);

        $descripcion_precio = flex_md("PRECIO:", money($precio), _between_md);
        $descripcion_precio_solicitado = flex_md("PRECIO ", "SOLICITADO AL VENDEDOR", _between);
        $b[] = ($precio > 0) ? $descripcion_precio : $descripcion_precio_solicitado;

        if ($precio > 0) {
            $b[] = flex_md("MONTO A PAGAR", money($monto_a_pagar));
        }

        $c[] = d("Total de la compra", "top_40 strong text-uppercase");
        $str = _text("$", $monto_a_pagar, "MXN");
        $c[] = ($monto_a_pagar > 0) ? d($str) : "COTIZACIÍÓN EN PROCESO";
        $t[] = d($b);
        $t[] = d($c);
        $response[] = append($t);
        $response[] = format_link("RASTREAR COTIZACIÓN",
            [
                "href" => $url_seguimiento,
                "class" => "top_50 bottom_50",
            ]
        );

        $_response[] = append(
            $response,
            [
                "class" => "border padding_10 shadow m-0",
            ]
        );

        return d($_response, _8auto);

    }

    function notificacion_pago_realizado($data)
    {

        $recibo = $data["recibo"];
        $id_recibo = $data["id_recibo"];
        $usuario_venta = $data["usuario_venta"];
        $saldo_cubierto = pr($recibo, "saldo_cubierto");
        $costo_envio_cliente = pr($recibo, "costo_envio_cliente");
        $total_cubierto = $saldo_cubierto + $costo_envio_cliente;
        $monto_a_pagar = pr($recibo, "monto_a_pagar");
        $url_seguimiento = path_enid('pedido_seguimiento', $id_recibo);

        $_response[] = validate_format_cancelacion(
            $total_cubierto, $id_recibo, $data["modalidad"]
        );

        $response[] = get_format_transaccion($id_recibo);
        $pg[] = td(h("Pago enviado a ", 4));
        $pg[] = td(h("Importe ", 4));
        $pa[] = tr($pg);
        $t[] = strtoupper(pr($usuario_venta, "nombre"));
        $t[] = strtoupper(pr($usuario_venta, "apellido_materno"));
        $t[] = strtoupper(pr($usuario_venta, "apellido_paterno"));
        $rr[] = td($t);
        $rr[] = td(_text($total_cubierto, " MXN"));
        $pa[] = tr($rr);

        $response[] = tb($pa);

        $es[] = td("Estado: " .
            span("COMPLETADO"),
            [
                "style" => "border-style: solid;border-color: #000506;padding: 2px;",
            ]
        );

        $es[] = td();
        tr(append($es));
        $response[] = "</div>";

        $response[] = tr();

        $a[] = td("Detalles del pedido");
        $a[] = td("Cantidad");
        $a[] = td("Precio");
        $a[] = td("Subtotal");

        $b[] = td(pr($recibo, "resumen_pedido"));
        $b[] = td(pr($recibo, "num_ciclos_contratados"));
        $b[] = td(_text("$", pr($recibo, "precio"), "MXN"));
        $b[] = td(_text("$", $monto_a_pagar, "MXN"));

        $c[] = td("");
        $c[] = td("");
        $c[] = td("Total de la compra");
        $c[] = td("$" . $monto_a_pagar . "MXN");

        $t[] = tr(append($a), 'tb_pagos');
        $t[] = tr(append($b));
        $t[] = tr(append($c));


        $response[] = tb(append($t));
        $response[] = btn(
            "RASTREAR PEDIDO",
            [
                "href" => $url_seguimiento,
                "class" => "top_50 bottom_50",
            ], 1, 1, 0,
            $url_seguimiento
        );
        $_response[] = append($response, [
            "style" => "margin: 0 auto;width: 66%;",
            "class" => "border padding_10 shadow",
        ]);

        return append($_response);


    }

    function get_format_tiempo_entrega($data, $servicios, $param)
    {

        $response = [];
        $a = 0;
        foreach ($data as $row) {

            $response[$a] = $row;
            $solicitudes = search_bi_array(
                $servicios, "id_servicio", $row["id_servicio"], "total", 0);
            $response[$a]["solicitudes"] = $solicitudes;
            $porcentaje = porcentaje_total($row["total"], $solicitudes);
            $response[$a]["porcentaje"] = substr($porcentaje, 0, 5);
            $a++;
        }

        return get_format_entrega($response, $param);

    }

    function get_format_entrega($data, $param)
    {

        $response = [];
        $fecha_inicio = $param["fecha_inicio"];
        $fecha_termino = $param["fecha_termino"];
        $utilidad_global = 0;

        foreach ($data as $row) {


            $id_servicio = $row["id_servicio"];
            $x = [];
            $imagen_servicio = img(
                [
                    "src" => $row["url_img_servicio"],
                    "class" => "img_servicio_def padding_10",
                ]
            );
            $x[] =
                a_enid(
                    $imagen_servicio,
                    [
                        "class" => "col-lg-3 p-0",
                        "href" => get_url_servicio($id_servicio)
                    ]
                );
            $text = [];
            $text[] = d(h($row["porcentaje"] . "%", 3), "text-center");


            $form = [];
            $form[] = "<form action='../pedidos/?s=1' METHOD='GET'>";
            $form[] = hiddens(["name" => "fecha_inicio", "value" => $fecha_inicio]);
            $form[] = hiddens(["name" => "fecha_termino", "value" => $fecha_termino]);
            $form[] = hiddens(["name" => "type", "value" => 13]);
            $form[] = hiddens(["name" => "servicio", "value" => $id_servicio]);
            $form[] = btn($row["solicitudes"] . " SOLICITUDES ");
            $form[] = form_close();
            $text[] = append($form);


            $form = [];

            $form[] = "<form action='../pedidos/?s=1' METHOD='GET'>";
            $form[] = hiddens(["name" => "fecha_inicio", "value" => $fecha_inicio]);
            $form[] = hiddens(["name" => "fecha_termino", "value" => $fecha_termino]);
            $form[] = hiddens(["name" => "type", "value" => 14]);
            $form[] = hiddens(["name" => "servicio", "value" => $id_servicio]);
            $form[] = btn(_text($row["total"], " VENTAS"));
            $form[] = form_close();

            $text[] = append($form);

            $x[] = d(
                append($text),
                "col-lg-3 d-flex flex-column justify-content-between"
            );

            $dias_venta = _text(
                "Tiempo promedio de venta ", substr($row["dias"], 0, 5), "días");

            $x[] = d(h($dias_venta, 4), "col-lg-3 text-center align-self-center");


            $total_costos_operativos = $row["total_costos_operativos"];
            $utilidad = h("Sin costos operativos registrados", 5);

            if (es_data($total_costos_operativos)) {

                $total_costos = $total_costos_operativos["total_costos"];
                $total_pagos = $total_costos_operativos["total_pagos"];
                $utilidad = ($total_pagos - $total_costos);
                $utilidad_global = $utilidad_global + $utilidad;
            }

            $x[] = d(
                add_text(
                    h(
                        "UTILIDAD", 3
                    ),
                    h(
                        _text($utilidad, " MXN "), 5
                    )
                )
                ,
                "col-lg-3 text-center align-self-center"
            );

            $response[] = d(append($x), "row border  top_30");

        }

        $r[] = h(_text("UTILIDAD TOTAL: ", money($utilidad_global)), 4);
        $r[] = append($response);

        return $r;


    }

    function get_format_transaccion($id_recibo, $es_servicio = 0)
    {

        if ($es_servicio < 1) {

            $r[] = d(img_enid(), "w_200");
            $r[] = h("Detalles de la transacción", 2);
            $r[] = h("#Recibo: " . $id_recibo, 3);
            $r[] = hr();

        } else {

            $r[] = d(d(img_enid(), "w_200"), "d-flex justify-content-center");
            $r[] = _titulo(add_text("#Recibo: ", $id_recibo), 3);
            $r[] = hr([],0);

        }

        return append($r);

    }

    function validate_format_cancelacion($total_cubierto, $id_recibo, $modalidad)
    {
        $text = ($total_cubierto < 1) ?
            a_enid("CANCELAR VENTA",
                [
                    "class" => "cancelar_compra padding_10",
                    "id" => $id_recibo,
                    "modalidad" => $modalidad,
                ],
                1
            ) : "";

        return $text;

    }

    function notificacion_solicitud_valoracion($usuario, $id_servicio)
    {

        $sender = [];

        if (es_data($usuario)) {

            $usuario = $usuario[0];

            $url = "https://enidservices.com/inicio/valoracion/?servicio=" . $id_servicio;
            $r[] = img_enid([], 1, 1);
            $r[] = h("¿Valorarías tu experiencia de compra en Enid Service?", 3);
            $r[] = d("Nos encantará hacer todo lo necesario para que tu experiencia de compra sea la mejor");
            $r[] = a_enid("Déjanos tus comentarios aquí!", $url);
            $sender = get_request_email(
                $usuario["email"],
                "Hola {$usuario["nombre"]} ¡Tu paquete ya se entregó! "
                , append($r)
            );

        }

        return $sender;


    }

    function saludo($cliente, $config_log, $id_recibo)
    {

        $r[] = h(_text("Buen día ", $cliente, ", Primeramente un cordial saludo. "), 3);
        $r[] = d("El presente mensaje es para informar que el servicio solicitado ahora 
        (Nueva Compra) o previamente (Recordatorio de Renovación) 
        tiene los siguientes detalles:");
        $r[] = d("Detalles de Orden de Compra");
        $r[] = d(img($config_log));
        $r[] = h("#Recibo: " . $id_recibo);

        return append($r);
    }

    function text_saldo_pendiente(
        $resumen_pedido,
        $num_ciclos_contratados,
        $es_servicio,
        $id_ciclo_facturacion,
        $text_envio_cliente_sistema,
        $primer_registro,
        $fecha_vencimiento,
        $monto_a_pagar,
        $saldo_pendiente
    )
    {


        $r = [
            d("Concepto"),
            d(((!is_null($resumen_pedido)) ? $resumen_pedido : " ")),
            text_periodos_contratados($num_ciclos_contratados, $es_servicio,
                $id_ciclo_facturacion),
            d("Precio " . $monto_a_pagar),
            d($text_envio_cliente_sistema),
            d("Ordén de compra {$primer_registro } Límite de pago  {$fecha_vencimiento} "),
            d("Monto total pendiente"),
            h($saldo_pendiente . " Pesos Mexicanos", 2),
            hr(),
        ];

        return append($r);

    }

    function text_forma_pago(
        $img_pago_oxxo,
        $url_pago_oxxo,
        $url_pago_paypal,
        $img_pago_paypal
    )
    {


        $r[] = h("Formas de pago Enid Service", 2);
        $r[] = h("NINGÚN CARGO A TARJETA ES AUTOMÁTICO. 
        SÓLO PUEDE SER PAGADO 
        POR ACCIÓN DEL USUARIO ",
            2
        );
        $r[] = d(
            "1.- Podrás compra en línea de forma segura 
            con tu con tu tarjeta bancaria (tarjeta de crédito o débito)
             a través de"
        );
        $r[] = anchor($url_pago_paypal, "PayPal");
        $r[] = anchor($url_pago_paypal, img($img_pago_paypal));
        $r[] = anchor($url_pago_paypal, "Comprar ahora!");
        $r[] = hr();
        $r[] = d("2.- Aceptamos pagos en tiendas de autoservicio OXXO y transferencia
         bancaria en línea para bancos BBVA Bancomer", 1);
        $r[] = anchor($url_pago_oxxo, h("OXXO", 4));
        $r[] = anchor($url_pago_oxxo, "Imprimir órden de pago");
        $r[] = anchor($url_pago_oxxo, img($img_pago_oxxo));

        return d($r);

    }

    function get_text_notificacion_pago($url)
    {

        $r[] = h("¿Ya realizaste tu pago?", 2);
        $r[] = d("Notifica tu pago para que podamos procesarlo");
        $r[] = a_enid("Dando click aquí", $url);

        return append($r);

    }

    function render_resumen_pedodos($recibos, $lista_estados, $param)
    {

        $tipo_orden = $param["tipo_orden"];
        $ops_tipo_orden = [
            "",
            "fecha_registro",
            "fecha_entrega",
            "fecha_cancelacion",
            "fecha_pago",
            "fecha_contra_entrega",
        ];
        $ops_tipo_orden_text = [
            "",
            "FECHA REGISTRO",
            "FECHA ENTREGA",
            "FECHA CANCELACIÓN",
            "FECHA DE PAGO",
            "FECHA CONTRA ENTREGA",
        ];


        $items = [
            "ORDEN",
            "",
            "STATUS",
            "TIPO ENTREGA",
            "MONTO COMPRA",
            $ops_tipo_orden_text[$tipo_orden],
        ];

        $titulos = d_c($items, "font-weight-bold col-lg-2 ");
        $tb[] = d($titulos, 'mb-3 mt-3 d-none d-md-block row');

        $total = 0;
        foreach ($recibos as $row) {


            $recibo = $row["recibo"];
            $monto_a_pagar = $row["monto_a_pagar"];
            $monto_a_pagar = ($monto_a_pagar * $row["num_ciclos_contratados"]) + $row["costo_envio_cliente"];
            $status = $row["status"];
            $tipo_entrega = $row["tipo_entrega"];
            $estado_compra = ($row["se_cancela"] == 1 || $row["cancela_cliente"] == 1) ? "CANCELACIÓN" : 0;
            $estado_compra = ($estado_compra == 0) ? get_text_status($lista_estados, $status) : $estado_compra;
            $tipo_entrega = ($tipo_entrega == 1) ? "PAGO CONTRA ENTREGA" : "MENSAJERÍA";
            $entrega = $row[$ops_tipo_orden[$tipo_orden]];
            $extra = (in_array($status, [9, 7, 11, 12])) ? " entregado" : "";
            $extra = ($status == 10) ? " cancelado " : $extra;
            $url_img = $row["url_img_servicio"];
            $total += $monto_a_pagar;

            $img = img(
                [
                    "src" => $url_img,
                    "class" => "mx-auto d-block pedido_img"
                ]
            );

            $items = [
                span($recibo, 'd-md-block d-none'),
                $img,
                span($estado_compra, 'font-weight-bold estado_compra'),
                $tipo_entrega,
                money($monto_a_pagar),
                format_fecha($entrega),
            ];

            $tb[] = hr('d-md-none mt-sm-5 mt-md-0 solid_bottom_2');
            $tb[] = d(
                d_c(
                    $items, 'col-lg-2 border descripcion_compra fp8'),
                [
                    'id' => $recibo,
                    'class' => 'desglose_orden cursor_pointer row  mt-md-0 mt-sm-5 text-center text-md-left' . $extra
                ]
            );
        }


        $tb_fechas = tb_fechas($recibos, $ops_tipo_orden, $tipo_orden);
        $inicio = _titulo(_text(count($recibos), " resultados "), 1, "mt-5");
        $totales = _titulo(_text_('Total', money($total)), 1);
        return _text($tb_fechas, $inicio, d($tb, 'col-lg-12 mb-4'), $totales);
    }

    function tb_fechas($recibos, $ops_tipo_orden, $tipo_orden)
    {

        $fechas = array_column($recibos, $ops_tipo_orden[$tipo_orden]);
        $fechas = array_reverse($fechas);
        $calback = function ($n) {
            return substr($n, 0, 10);
        };

        $fechas = array_map($calback, $fechas);
        $ventas_fecha = array_count_values($fechas);
        $fechas_keys = array_keys($ventas_fecha);
        $cb = function ($a, $b) {
            return " " . $a . td($b);
        };
        $titulos = "<td>" . implode("</td><td>", $fechas_keys) . "</td>";
        $valores = array_reduce($ventas_fecha, $cb, '');


        $r[] = tr($titulos);
        $r[] = tr($valores);

        return tb($r);
    }

    function get_text_status($lista, $estado_compra)
    {

        $key = array_search(
            $estado_compra,
            array_column($lista, 'id_estatus_enid_service')
        );

        return ($key !== false) ? strtoupper($lista[$key]["text_vendedor"]) : "";

    }

    function paypal($saldo_pendiente)
    {

        $response = 0;
        if ($saldo_pendiente > 0) {

            $response = path_enid(
                "paypal_enid",
                $saldo_pendiente + porcentaje($saldo_pendiente, 3.7, 2, 0),
                1
            );

        }

        return $response;

    }


    function get_link_oxxo($url_request, $saldo, $id_recibo, $id_usuario)
    {


        return ($saldo > 0 && $id_recibo > 0 && $id_usuario > 0) ?
            ($url_request . "orden_pago_oxxo/?q=" . $saldo . "&q2=" . $id_recibo . "&q3=" . $id_usuario) : "";

    }

    function get_saldo_pendiente(
        $monto,
        $ciclos,
        $cubierto,
        $envio_cliente,
        $envio_sistema,
        $tipo_entrega
    )
    {


        $cubierto = ($cubierto < 0) ? 0 : $cubierto;
        $total = ($monto > 0 && $ciclos > 0) ? ($monto * $ciclos) - $cubierto : 0;

        $cargo_envio = $envio_sistema["costo_envio_cliente"];
        if (in_array($tipo_entrega, [2, 4])) {

            $text_envio = $envio_sistema["text_envio"]["cliente"];


        } else {

            $text_envio = ($envio_cliente > 0) ? _text("Cargos de entrega ", $envio_cliente, "MXN") : $envio_sistema["text_envio"]["cliente"];

        }

        return [
            'saldo_pendiente' => $total,
            'text_envio' => $text_envio,
            'total_mas_envio' => ($total + $cargo_envio),
            'total' => $total,
            'cargo_envio' => $cargo_envio,
            'costo_envio_cliente' => $envio_sistema["costo_envio_cliente"]
        ];


    }

    function crea_data_deuda_pendiente($param)
    {

        $response["cuenta_correcta"] = 0;
        if (es_data($param)) {

            $recibo = $param[0];
            $response = [
                "saldo_pendiente" => (($recibo["precio"] * $recibo["num_ciclos_contratados"]) + $recibo["costo_envio_cliente"]),
                "cuenta_correcta" => 1,
                "resumen" => $recibo["resumen_pedido"],
                "costo_envio_cliente" => $recibo["costo_envio_cliente"],
                "flag_envio_gratis" => $recibo["flag_envio_gratis"],
                "id_recibo" => $recibo["id_proyecto_persona_forma_pago"],
                "id_usuario" => $recibo["id_usuario"],
                "id_usuario_venta" => $recibo["id_usuario_venta"],
                "id_servicio" => $recibo['id_servicio']
            ];

        }

        return $response;


    }

    /*
    function get_texto_saldo_pendiente($monto_a_liquidar, $monto_a_pagar, $modalidad_ventas)
    {

        $texto = "";
        if ($modalidad_ventas == 1) {

            $texto = ($monto_a_liquidar > 0) ? d("MONTO DE LA COMPRA", 'text-saldo-pendiente') . d($monto_a_pagar . "MXN", "text-saldo-pendiente-monto") : $texto;

        } else {

            $texto = ($monto_a_liquidar > 0) ?
                add_text(
                    d("SALDO PENDIENTE", 'text-saldo-pendiente')
                    ,
                    d(add_text($monto_a_liquidar, "MXN"), "text-saldo-pendiente-monto")
                ) : $texto;


        }

        return d($texto, 'contenedor-saldo-pendiente');

    }
    */

    /*
    function monto_pendiente_cliente($monto, $saldo_cubierto, $costo, $num_ciclos)
    {

        return ($monto * $num_ciclos) + $costo;

    }
    */
    /*
    function evalua_texto_envios_compras($modalidad_ventas, $total, $tipo)
    {

        $text = "";
        switch ($tipo) {
            case 1:
                if ($modalidad_ventas > 0) {

                    $text = "DATE PRISA MANTÉN EXCELENTE REPUTACIÓN ENVIA TU ARTÍCULO EN VENTA DE FORMA PUNTUAL";
                    $text_2 = "Date prisa, mantén una buena reputación enviando tus  $total articulos vendidos de forma puntual";
                    $text = ($total == 1) ? $text : $text_2;

                }

                break;


            case 6:
                if ($modalidad_ventas < 1) {

                    $text = "DATE PRISA REALIZA TU COMPRA ANTES DE QUE OTRA PERSONA SE LLEVE TU PEDIDO!";

                }
                break;

            default:

                break;
        }

        $text = d($text, ['class' => 'alert alert-info', 'style' => 'margin-top: 10px;background: #001541;color: white']);
        return $text;
    }
*/
    /*
    function get_text_direccion_envio($id_recibo, $modalidad_ventas, $direccion_registrada, $estado_envio)
    {

        $texto = "";
        if ($modalidad_ventas == 0) {

            $texto = text_icon('fa fa-bus ', "¿DÓNDE ENVIAMOS TU PEDIDO?", ["id" => $id_recibo]);
            if ($direccion_registrada > 0) {
                switch ($estado_envio) {
                    case 0:
                        $texto = text_icon("fa fa-bus", "A LA BREVEDAD EL VENDEDOR TE ENVIARÁ TU PEDIDO");
                        break;

                    default:
                        $texto = text_icon('fa fa-bus', "DIRECCIÓN DE ENVÍO", ["id" => $id_recibo]);
                        break;
                }

            }

        } else {

            $texto = ($direccion_registrada == 1) ? text_icon('fa fa-bus ', "VER DIRECCIÓN DE ENVÍO", ["id" => $id_recibo]) : $texto;

        }

        return d($texto, ["class" => "btn_direccion_envio", "id" => $id_recibo]);
    }
    */
    /*
    function get_estados_ventas($data, $indice, $modalidad_ventas)
    {

        $response = "";
        foreach ($data as $row) {

            if ($row["id_estatus_enid_service"] == $indice) {

                $response = ($modalidad_ventas == 1) ? $row["text_vendedor"] : $row["text_cliente"];

                break;
            }
        }

        return $response;
    }
    */
    function carga_estado_compra($id_recibo, $vendedor = 0)
    {


        $text_icono =
            ($vendedor == 1) ?
                "DETALLES DE LA COMPRA " : text_icon(_money_icon,
                "DETALLES DE TU COMPRA ");

        $text = tab(
            $text_icono,
            "#tab_renovar_servicio",
            [
                "class" => 'resumen_pagos_pendientes mt-4 mb-4 strong black',
                "id" => $id_recibo,
            ]
        );

        return d($text,'col-md-3');
    }


    function text_periodos_contratados($periodos, $es_servicio, $id_ciclo_facturacion)
    {


        if ($es_servicio == 1) {

            $ciclos = [
                "",
                "Anualidad",
                "Mensualidad",
                "Semana",
                "Quincena",
                "",
                "Anualidad a 3 meses",
                "Anualidad a 6 meses",
                "A convenir",
            ];

            $ciclos_largos = [
                "",
                "Anualidades",
                "Mensualidades",
                "Semanas",
                "Quincenas",
                "",
                "Anualidades a 3 meses",
                "Anualidades a 6 meses",
                "A convenir",
            ];


            $text_ciclos = ($periodos > 1) ? $ciclos_largos[$id_ciclo_facturacion] : $ciclos[$id_ciclo_facturacion];
            $text = "Ciclos contratados: " . $periodos . " " . $text_ciclos;

        } else {


            $text = ($periodos > 1) ? "Piezas " : "Pieza ";
            $text = h($periodos . " " . $text, 3);

        }

        return $text;
    }

    function get_text_modalidad($modalidad, $ordenes)
    {


        return ($modalidad < 1 && $ordenes < 1) ?
            "" :
            _titulo(mayorque($modalidad, 0, "TUS VENTAS", "TUS COMPRAS"));

    }

    /*
    function get_mensaje_compra($modalidad, $num_ordenes)
    {


        $response = "";
        if ($modalidad == 0 && $num_ordenes == 0) {
            $final = d(
                img(
                    [
                        "src" => "../img_tema/tienda_en_linea/carrito_compra.jpg",
                        "class" => "img_invitacion_compra"
                    ]
                )
                ,
                "img_center_compra"
            );

            $f = a_enid($final, path_enid("home"));

            $f .= a_enid(
                h(
                    "EXPLORAR TIENDA"
                    ,
                    3, "text-center text_explorar_tienda"
                ), path_enid("home")
            );

            $response = $f;
        }
        return $response;
    }

    function agregar_direccion_envio($id_recibo)
    {

        return d(
            text_icon("fa fa-bus", " Agrega la dirección de envío de tu pedido!")
            ,
            [
                "class" => "btn_direccion_envio contenedor_agregar_direccion_envio_pedido a_enid_black cursor_pointer",
                "id" => $id_recibo,
                "href" => "#tab_mis_pagos",
                "data-toggle" => "tab"
            ],
            1
        );

    }

    */

    function format_direccion_envio($inf, $id_recibo, $recibo)
    {


        $resumen = tab(
            icon("fa fa-pencil"),
            "#tab_mis_pagos",
            [
                "class" => "btn_direccion_envio ",
                "id" => $id_recibo,

            ]
        );


        $r[] = pr($inf, "direccion");
        $r[] = pr($inf, "calle");
        $r[] = pr($inf, "numero_exterior");
        $r[] = pr($inf, "numero_interior");
        $r[] = pr($inf, "entre_calles");
        $r[] = pr($inf, "cp");
        $r[] = pr($inf, "asentamiento");
        $r[] = pr($inf, "municipio");
        $r[] = pr($inf, "ciudad");
        $r[] = pr($inf, "estado");

        $resumen[] = d(append($r), 'texto_direccion_envio_pedido top_20');
        $resumen[] = d("¿Quíen más puede recibir tu pedido?");
        $resumen[] = d(pr($inf, "nombre_receptor"));
        $resumen[] = d(pr($inf, "telefono_receptor"));

        return d(append($resumen), "informacion_resumen_envio");

    }

    function format_concepto($resumen_pedido, $url_img_servicio, $monto_a_pagar, $recibo, $tipos_entrega)
    {


        $text_money = money($monto_a_pagar);
        $resume_articulo[] = d($resumen_pedido, ' text-right');
        $resume_articulo[] = d($text_money, ' text-right mr-3 h4');
        $descripcion_compra = append($resume_articulo);

        $articulo =
            img(
                [
                    "src" => $url_img_servicio,
                    "class" => "img_servicio_def p-2",
                ]
            );

        $r[] = flex(
            $articulo,
            $descripcion_compra,
            'align-items-center justify-content-between  '

        );

        $ticket_pago = ticket_pago($recibo, $tipos_entrega);

        $r[] = $ticket_pago['checkout'];


        return [
            'checkout_resumen' => d_row(d($r, 'bg-light p-5')),
            'checkout' => $ticket_pago
        ];


    }

    function get_format_punto_encuentro($data_complete, $recibo)
    {

        $r = [];
        if (es_data($data_complete) &&
            array_key_exists("punto_encuentro", $data_complete) &&
            es_data($data_complete["punto_encuentro"])) {

            $p = $data_complete["punto_encuentro"][0];
            $costo_envio = $p["costo_envio"];

            $r[] = d(h("LUGAR DE ENCUENTRO", 3, "top_30 underline "), 1);
            $x[] = d($p["tipo"] . " " . $p["nombre"] . " " . "NÚMERO " . $p["numero"] . " COLOR " . $p["color"],
                "top_20", 1);
            $x[] = d("ESTACIÓN " . $p["lugar_entrega"], "strong", 1);
            $x[] = d("HORARIO DE ENTREGA: " . $recibo["fecha_contra_entrega"], 1);
            $r[] = d(append($x), "contenedor_detalle_entrega");

            if ($costo_envio > 0) {
                $r[] = d("Recuerda que previo a la entrega de tu producto, deberás realizar el 
                pago de " . $costo_envio . " pesos por concepto 
                de gastos de envío", "contenedor_text_entrega border");
            }
        }

        return append($r);
    }

    function get_botones_seguimiento($id_recibo)
    {


        $t[] = btn(
            text_icon("fa fa-map-signs", "RASTREA TU PEDIDO"),
            [
                "class" => "top_20 text-left",
                "style" => "border-style: solid!important;border-width: 2px!important;border-color: black!important;color: black !important;background: #f1f2f5 !important;",
            ],
            1,
            1,
            0,
            path_enid("pedido_seguimiento", $id_recibo)
        );


        $t[] = d(
            a_enid('CANCELAR COMPRA',
                [
                    "class" => "cancelar_compra",
                    "id" => $id_recibo,
                    "modalidad" => '0',
                ]
            ),
            "top_20",
            1);

        return append($t);

    }

    function getPayButtons($recibo, $url_request, $id_usuario_venta, $checkout)
    {


        $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
        $tipo_entrega = $recibo["tipo_entrega"];
        $descuento_entrega = $checkout['descuento_entrega'];
        $es_descuento = ($tipo_entrega == 1 && $descuento_entrega > 0);
        $saldo_pendiente = ($es_descuento) ? $checkout['saldo_pendiente_pago_contra_entrega'] : $checkout['saldo_pendiente'];
        $text_descuento = ($es_descuento) ? _text('Compra ya y paga ', money($saldo_pendiente)) : '';
        $texto_cambio_contra_entrega =
            _text(
                money($saldo_pendiente),
                ' comprando contra entrega ',
                small('(solo en estaciones de metro de CDMX)', 'h6 text-secondary d-block')
            );
        $texto_cambio_contra_entrega = a_enid(
            $texto_cambio_contra_entrega,
            [
                'href' => path_enid('pedido_seguimiento', _text($id_recibo, '&domicilio=1&asignacion=1')),
                'class' => 'black'
            ]
        );
        $text_descuento = ($tipo_entrega == 2) ? $texto_cambio_contra_entrega : $text_descuento;


        $response[] = _titulo('FORMAS DE PAGO', 0, 'mb-5 mt-5');
        $botones_pago[] =
            a_enid(
                img(
                    [
                        "src" => '../img_tema/bancos/paypal_button.png',
                        "class" => "w-25",

                    ]
                ),
                [
                    "class" => 'text-center sombra_boton border_big m-auto mt-5',
                    "recibo" => $id_recibo,
                    "onclick" => "notifica_tipo_compra(2 ,  '" . $id_recibo . "');",
                    "href" => paypal($saldo_pendiente),

                ]
            );


        $botones_pago[] =

            format_link(
                "Tiendas (OXXO)"
                ,
                [

                    "class" => " mt-4 mb-5",
                    "onclick" => "notifica_tipo_compra(4 , '" . $id_recibo . "');",
                    "href" =>
                        get_link_oxxo(
                            $url_request,
                            $saldo_pendiente,
                            $id_recibo,
                            $id_usuario_venta),
                ]
            );

        $response[] = append($botones_pago);

        $response[] = _titulo(
            $text_descuento, 1
        );

        return d($response, "col-lg-12 seccion_compra p-0");

    }

    function get_vista_cliente($data)
    {

        $modalidad = $data["modalidad"];
        $ordenes = $data["ordenes"];

        $r[] = d(get_text_modalidad($modalidad, $ordenes), 'mt-5');
        $text = ($modalidad == 1) ? "ÚLTIMAS VENTAS" : "ÚLTIMAS COMPRAS";
        $r[] = d(d(btn($text, ["class" => "ver_mas_compras_o_ventas mt-5 mb-5 col-sm-3"]), 12), 'row');
        $r[] = create_listado_compra_venta($ordenes, $modalidad, $data["id_perfil"]);
        $r[] = d(place("contenedor_ventas_compras_anteriores"), 13);

        return d($r);
    }

    function create_listado_compra_venta($ordenes, $modalidad, $id_perfil = 0)
    {

        $list = [];
        foreach ($ordenes as $row) {


            $id_recibo = $row["id_proyecto_persona_forma_pago"];
            $t = a_enid(
                img(
                    [
                        "src" => $row["url_img_servicio"],
                        "class" => 'imagen_articulo',
                    ]
                )
                ,
                path_enid("producto", $row["id_servicio"])

            );


            $t .= carga_estado_compra($id_recibo, $modalidad);

            if ($id_perfil == 3) {
                $url = path_enid("pedidos_recibo", $id_recibo);
                $t .= btn("AVANZADO", [], 1, 1, 0, $url);
            }

            $list[] = d(
                d($t,
                    "align-items-center d-md-flex border border border-secondary mt-4 mb-4 p-4 justify-content-between min_block text-center"),
                1);
        }

        return append($list);

    }

    function get_view_compras($status_enid_service, $compras, $tipo)
    {

        $tipo_solicitud =
            _titulo(
                search_bi_array(
                    $status_enid_service,
                    "id_estatus_enid_service",
                    $tipo,
                    "nombre"
                )

            );
        $r = [];
        foreach ($compras as $row) {

            $response = [];
            $id_servicio = $row["id_servicio"];
            $url_imagen = link_imagen_servicio($id_servicio);


            $response[] = img(
                [
                    "src" => $url_imagen,
                    "onerror" => "this.src='../img_tema/portafolio/producto.png'",
                    "class" => "col-md-3"
                ]
            );

            $response[] = _titulo(money($row["monto_a_pagar"]), 1);

            $r[] = d(
                $response,
                "d-md-flex align-items-center 
                justify-content-between border shadow mt-5 p-5 text-center"
            );

        }

        array_unshift($r, $tipo_solicitud);

        return append($r);

    }

    function rastreo_compra($id_recibo, $seccion_compra)
    {
        $response[] = d($seccion_compra, 'd-md-none row');
        $seccion[] = d(format_link(
            "Rastrea tu orden",
            [

                "href" => path_enid('pedido_seguimiento', _text($id_recibo)),
                'class' => 'text-right mt-5',
            ]
            , 1, 0
        ), _12p);

        $seccion[] = d(format_link(
            "Cambia la dirección de entrega",
            [

                "href" => path_enid('pedido_seguimiento',
                    _text($id_recibo,
                        '&domicilio=1&asignacion=1')),
                'class' => 'mt-3',
            ]
            ,
            0, 0
        ), _12p);

        $seccion[] = d(format_link('Cancelar compra',
            [
                "class" => "cancelar_compra mt-3 text-right text-uppercase",
                "id" => $id_recibo, "modalidad" => '0',
            ], 0, 0
        ), _12p);

        $response[] = d_row(append($seccion));
        return append($response);

    }

//    function get_link_saldo_enid($id_usuario, $id_recibo)
//    {
//
//        return "../movimientos/?q=transfer&action=8&operacion=" . $id_usuario . "&recibo=" . $id_recibo;
//    }

}
