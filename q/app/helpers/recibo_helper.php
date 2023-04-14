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

        if (str_len($usuario_venta, 4)) {

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
        $response[] = format_link(
            "RASTREAR COTIZACIÓN",
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
        $id_orden_compra = $data["id_orden_compra"];
        $usuario_venta = $data["usuario_venta"];
        $saldo_cubierto = pr($recibo, "saldo_cubierto");
        $costo_envio_cliente = pr($recibo, "costo_envio_cliente");
        $total_cubierto = $saldo_cubierto + $costo_envio_cliente;
        $monto_a_pagar = pr($recibo, "monto_a_pagar");
        $url_seguimiento = path_enid('pedido_seguimiento', $id_orden_compra);

        $_response[] = validate_format_cancelacion(
            $total_cubierto,
            $id_orden_compra,
            $data["modalidad"]
        );

        $response[] = get_format_transaccion($id_orden_compra);
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

        $es[] = td(
            "Estado: " .
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
            ],
            1,
            1,
            0,
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
                $servicios,
                "id_servicio",
                $row["id_servicio"],
                "total",
                0
            );
            $response[$a]["solicitudes"] = $solicitudes;
            $porcentaje = porcentaje_total($row["total"], $solicitudes);
            $response[$a]["porcentaje"] = substr($porcentaje, 0, 5);
            $a++;
        }

        return get_format_entrega($response, $param);
    }

    function sin_resultados_busqueda()
    {

        $response[] = _titulo('ups! parece que no hubo pedidos');
        return d($response, 'row mt-5 alert alert-info border-0');
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
            $texto_porcentaje = d(_text_($row["porcentaje"], "% de las solicitudes son ventas efectivas"));
            $texto_porcentaje = h($texto_porcentaje, 3);
            $text[] = d($texto_porcentaje, "text-center");


            $form = [];
            $form[] = "<form action='../pedidos/?s=1' METHOD='GET'>";
            $form[] = hiddens(["name" => "fecha_inicio", "value" => $fecha_inicio]);
            $form[] = hiddens(["name" => "fecha_termino", "value" => $fecha_termino]);
            $form[] = hiddens(["name" => "type", "value" => 13]);
            $form[] = hiddens(["name" => "servicio", "value" => $id_servicio]);
            $form[] = d(_text_($row["solicitudes"], "SOLICITUDES"), 'text-center');
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
                $text,
                "col-lg-3 d-flex flex-column justify-content-between"
            );

            $dias_venta = _text_(
                "Tiempo promedio de venta ",
                substr($row["dias"], 0, 5),
                "días"
            );

            $x[] = d(h($dias_venta, 4), "col-lg-3 text-center align-self-center");

            $total_costos_operativos = $row["total_costos_operativos"];
            $utilidad = h("Sin costos operativos registrados", 5);

            if (es_data($total_costos_operativos)) {

                $total_pagos = $total_costos_operativos["total_pagos"];
                $total_costo_producto = $total_costos_operativos["total_costo_producto"];
                $utilidad = ($total_pagos - $total_costo_producto);
                $utilidad_global = $utilidad_global + $utilidad;
            }

            $x[] = d(
                add_text(
                    h(
                        "UTILIDAD",
                        3
                    ),
                    h(
                        _text($utilidad, " MXN "),
                        5
                    )
                ),
                "col-lg-3 text-center align-self-center"
            );

            $response[] = d($x, "row border  top_30");
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
            $r[] = hr([], 0);
        }

        return append($r);
    }

    function validate_format_cancelacion($total_cubierto, $id_recibo, $modalidad)
    {
        $text = ($total_cubierto < 1) ?
            a_enid(
                "CANCELAR VENTA",
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

            $url = _text("https://enidservices.com/", _web, "/valoracion/?servicio=", $id_servicio);
            $r[] = img_enid([], 1, 1);
            $r[] = h("¿Valorarías tu experiencia de compra en Enid Service?", 3);
            $r[] = d("Nos encantará hacer todo lo necesario para que tu experiencia de compra sea la mejor");
            $r[] = a_enid("Déjanos tus comentarios aquí!", $url);
            $sender = get_request_email(
                $usuario["email"],
                "Hola {$usuario["name"]} ¡Tu paquete ya se entregó! ",
                append($r)
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
    ) {


        $r = [
            d("Concepto"),
            d(((!is_null($resumen_pedido)) ? $resumen_pedido : " ")),
            text_periodos_contratados(
                $num_ciclos_contratados,
                $es_servicio,
                $id_ciclo_facturacion
            ),
            d("Precio " . $monto_a_pagar),
            d($text_envio_cliente_sistema),
            d("Ordén de compra {$primer_registro} Límite de pago  {$fecha_vencimiento} "),
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
    ) {


        $r[] = h("Formas de pago Enid Service", 2);
        $r[] = h(
            "NINGÚN CARGO A TARJETA ES AUTOMÁTICO. 
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
         bancaria en línea para bancos HSBC", 1);
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

    function cuentas_por_cobrar_reparto($recibos)
    {

        $listado = [];
        $total = 0;
        foreach ($recibos as $row) {

            $recibo = $row["recibo"];
            $url_img = $row["url_img_servicio"];
            $monto = $row["monto_a_pagar"];
            $num_ciclos = $row["num_ciclos_contratados"];
            $costo_envio_cliente = $row["costo_envio_cliente"];
            $nombre_tipo_entrega = $row["nombre_tipo_entrega"];
            $monto_a_pagar = ($monto * $num_ciclos) + $costo_envio_cliente;
            $fecha_contra_entrega = $row['fecha_contra_entrega'];

            $img = img(
                [
                    "src" => $url_img,
                    "class" => "mx-auto d-block mh_50 w_50"
                ]
            );

            $nombre_repartidor = _text_(
                $row['nombre_repartidor'],
                $row['apellido_repartidor']
            );

            $format_fecha_hora = format_fecha($fecha_contra_entrega, 1);

            $items = [];
            $contenido = [];
            $numero_recibo = span($recibo, 'd-md-block d-none');
            $total = $total + $monto_a_pagar;
            $items[] = money($monto_a_pagar);

            $contenido[] = d($numero_recibo, 'col border descripcion_compra fp8 text-center text-uppercase');
            $contenido[] = d($img, 'col border descripcion_compra fp8 text-center text-uppercase');
            $contenido[] = d_c($items, 'col border descripcion_compra fp8');
            $contenido[] = d($nombre_repartidor, 'col border descripcion_compra fp8');
            $contenido[] = d($nombre_tipo_entrega, 'col border descripcion_compra fp8');
            $contenido[] = d($format_fecha_hora, 'col border descripcion_compra fp8');

            $text = append($contenido);
            $line = a_enid(
                $text,
                [
                    'id' => $recibo,
                    'class' => _text_('efectivo_fuera row cursor_pointer mt-md-0 text-center text-md-left mt-5 black'),
                    'href' => path_enid('pedidos_recibo', $recibo)
                ],
                0
            );

            $listado[] = $line;
        }

        $response[] = totales_cuentas_pago($total, $recibos);
        $response[] = d($listado, ' mt-5');
        return d($response, 'col-sm-12 mt-5');
    }

    function totales_cuentas_pago($total, $recibos)
    {

        $response = [];
        if (es_data($recibos)) {


            $ids_usuario_entrega = array_column($recibos, 'id_usuario_entrega');
            $repatidores = array_unique($ids_usuario_entrega);
            $base = 'col border descripcion_compra fp8 text-center text-uppercase';


            $total_recibos = dd('#Recibos', count($recibos));
            $contenido[] = d($total_recibos, $base);

            $repatidores_involucrados = count($repatidores);
            $total_repartidores = dd('#Repartidores', $repatidores_involucrados);

            $btn = btn('REGISTRAR COMO COBRADO', ['class' => 'efectivo_en_casa']);
            $total_por_cobro = _d('Total por cobro', d(money($total), 'total_a_pago'), $btn);
            $contenido[] = d($total_repartidores, $base);
            $contenido[] = d($total_por_cobro, $base);
            $response[] = d($contenido, 13);
        }
        return append($response);
    }

    function conteo_cancelaciones($tota_cancelaciones, $es_orden_cancelada, $es_lista_negra)
    {
        if ($es_orden_cancelada && !$es_lista_negra) {
            $tota_cancelaciones++;
        }
        return $tota_cancelaciones;
    }

    function seccion_comisiones($data, $monto, $cobro_secundario)
    {


        $response["comision_final"] = 0;
        $response["texto_comision_venta_mayor"] = "";
        $response["comision"] = "";
        if (es_cliente($data)) {
            return $response;
        }


        $comision_venta = comision_porcentaje($monto, 10);
        $diferencia_cobro = ($cobro_secundario -  $monto);
        $comision_venta_mayor = $comision_venta + $diferencia_cobro;

        $response["comision_final"] =
            ($comision_venta > $comision_venta_mayor) ? $comision_venta : $comision_venta_mayor;

        $response["texto_comision_venta_mayor"] = ($diferencia_cobro > 0)
            ? d(money($comision_venta_mayor), 'display-5') : ' ';

        $response["comision"] = _titulo(_d(money($comision_venta), "de comisión"), 4);

        return $response;
    }
    function comision_producto_orden_compra(
        $cobro_secundario,
        $monto,
        $articulos_en_compra,
        $row,
        $pos,
        $recibos,
        $data,
        $perfil
    ) {

        $comisiones = seccion_comisiones($data, $monto, $cobro_secundario);
        $texto_comision_venta_mayor = $comisiones["texto_comision_venta_mayor"];
        $comision = $comisiones["comision"];

        $es_orden_cancelada = es_orden_cancelada($row);
        $saldo_cubierto = $row['saldo_cubierto'];
        $usuario_venta = prm_def($row, 'usuario', []);
        $es_administrador = (!in_array($perfil, [20, 6]));

        $nombre_vendedor = '';
        $se_pago = ($row['flag_pago_comision'] > 0 && !$es_orden_cancelada && $saldo_cubierto > 0);
        $texto_se_cobro = d('Cobraste!', 'badge mt-4 mb-4 bg-dark white');
        $texto_cobro = ($se_pago > 0) ?
            $texto_se_cobro : 'YA SE ENTREGÓ, TU PAGO ESTÁ EN PROCESO';
        $verificado = _d($texto_cobro, $comision);
        $es_lista_negra = es_orden_lista_negra($row);


        if (es_administrador($data)) {

            $text_por_pago = d('por liberar', 'border_bottom_big black');
            $nombre_usuario = format_nombre($usuario_venta);
            $datos_vendedor = flex(
                'Vendió ',
                $nombre_usuario,
                'mt-3',
                'strong text-uppercase mr-2'
            );
            $nombre_vendedor = ($es_administrador) ? $datos_vendedor : '';

            $texto_pago_realizado = _text_(icon(_text_(_money_icon, 'white')), 'Pagaste!');
            $texto = d($texto_pago_realizado, 'badge mt-4 mb-4 bg-dark white');

            $textos_pagos_hechos = d(_text_($texto, $texto_comision_venta_mayor, $comision, $nombre_vendedor));
            $textos_pagos_no_hechos = d(_d(
                $texto_comision_venta_mayor,
                $comision,
                $text_por_pago,
                $nombre_vendedor
            ));

            $verificado = ($se_pago > 0) ? $textos_pagos_hechos : $textos_pagos_no_hechos;
        }

        $texto_al_recibir = d('Cuando el cliente reciba su pedido', 'f11');
        $por_ganar = _d(
            $texto_comision_venta_mayor,
            $comision,
            $texto_al_recibir
        );
        $por_ganar_cancelacion = ($es_orden_cancelada || $es_lista_negra) ? '' : $por_ganar;

        $texto = ($saldo_cubierto > 0) ? $verificado : $por_ganar_cancelacion;
        $texto = (es_cliente($data)) ? "" : $texto;

        return [
            "comision" =>  $texto,
            "comision_final"  => $comisiones["comision_final"]

        ];
    }
    function textos_ganancia_comision()
    {
    }
    function render_resumen_pedidos($recibos, $recompensas, $lista_estados, $param, $data)
    {

        $historial = prm_def($param ,"historial");
        $perfil = $param['perfil'];
        $restricciones = $data['restricciones']['orden_entregada'];
        $tipo_orden = $param["tipo_orden"];
        $ops_tipo_orden = [
            "",
            "fecha_registro",
            "fecha_entrega",
            "fecha_cancelacion",
            "fecha_pago",
            "fecha_contra_entrega",
        ];


        $clases_titulos = "bg_black white font-weight-bold col-lg-4 text-center";
        $titulos_reporte[] = d('TUS GANANCIAS', $clases_titulos);
        $linea_titulos[] = d($titulos_reporte, 'mb-3 mt-3 d-none d-md-block row');
        $total = 0;
        $saldo_por_cobrar = 0;
        $ordenes_canceladas = 0;
        $ordenes_pagadas = 0;
        $ordenes_en_proceso = 0;
        $transacciones = 0;
        $linea_en_proceso = [];
        $linea_cambio_estado = [];
        $linea_canceladas = [];
        $linea_cambio_lista_negra = [];
        $usuarios = [];
        $recibos_ventas = [];
        $tota_cancelaciones = 0;

        $ids_ordenes_compra = array_column($recibos, 'id_orden_compra');
        $articulos_en_orden_compra = array_count_values($ids_ordenes_compra);
        $pos = 0;
        $es_primer_articulo_pedido = 0;
        $z = 0;
        $indicador = 1;
        $id_orden_compra_actual = 0;
        $total_montos_proceso  = [];
        $total_montos_compra  = [];
        $total_comisiones  = 0;
        $ids_usuarios_ventas = [];

        foreach ($recibos as $row) {

            $id_servicio = $row['id_servicio'];
            $cobro_secundario = $row["cobro_secundario"];
            $transacciones++;
            $usuario_venta = prm_def($row, 'usuario', []);
            $usuarios[] = $usuario_venta;
            $monto_a_pagar = $row["monto_a_pagar"];
            $num_ciclos_contratados = $row["num_ciclos_contratados"];
            $monto_a_pagar = ($monto_a_pagar * $num_ciclos_contratados) + $row["costo_envio_cliente"];
            $status = $row["status"];
            $es_orden_cancelada = es_orden_cancelada($row);

            $estado_compra = ($es_orden_cancelada) ? "CANCELACIÓN" : 0;
            $status_orden = get_text_status($lista_estados, $status);
            $estado_compra = ($estado_compra == 0) ? $status_orden : $estado_compra;
            $saldo_cubierto = $row['saldo_cubierto'];
            $es_lista_negra = es_orden_lista_negra($row);
            $es_compra_efectiva = (!$es_orden_cancelada && $saldo_cubierto > 0);
            $es_orden_en_proceso = (!$es_compra_efectiva && !$es_orden_cancelada && !$es_lista_negra);

            $ordenes_canceladas = totales($ordenes_canceladas, $es_orden_cancelada);
            $ordenes_pagadas = totales($ordenes_pagadas, $es_compra_efectiva);
            $ordenes_en_proceso = totales($ordenes_en_proceso, $es_orden_en_proceso);

            $id_orden_compra = $row["id_orden_compra"];
            $flag_pago_comision = $row["flag_pago_comision"];

            $entrega = $row[$ops_tipo_orden[$tipo_orden]];
            $es_orden_entregada = es_orden_entregada($row, $restricciones);
            $extra = ($es_orden_entregada) ? " entregado" : "";
            $extra = ($es_orden_cancelada) ? " cancelado white" : $extra;
            $extra = ($es_lista_negra) ? " lista_negra white" : $extra;
            $tota_cancelaciones =
                conteo_cancelaciones($tota_cancelaciones, $es_orden_cancelada, $es_lista_negra);

            $articulos_en_compra = articulos_en_compra($articulos_en_orden_compra, $id_orden_compra);
            $recibos_ventas = conteo_servicio($recibos_ventas, $id_servicio, $num_ciclos_contratados);

            if ($saldo_cubierto > 0 && !$es_lista_negra && $flag_pago_comision < 1) {

                $extra = 'pago_en_proceso black';
                $saldo_por_cobrar = $saldo_por_cobrar + $row['comision_venta'];
                $total += $monto_a_pagar;
            }


            $img = imagenes_articulos_orden_compra(
                $articulos_en_compra,
                $row,
                $pos,
                $recibos
            );

            $monto_compra = monto_compra(
                $cobro_secundario,
                $data,
                $recompensas,
                $articulos_en_compra,
                $id_orden_compra,
                $pos,
                $recibos
            );



            $monto = $monto_compra["monto"];

            $comisiones = comision_producto_orden_compra(
                $cobro_secundario,
                $monto,
                $articulos_en_compra,
                $row,
                $pos,
                $recibos,
                $data,
                $perfil
            );

            $comision = $comisiones["comision"];
            $comision_final = $comisiones["comision_final"];


            $numero_recibo = span(_text_("#", $id_orden_compra), 'd-md-block d-none');
            $nombre_cliente = format_nombre($row['usuario_cliente']);
            $cliente = d(_text_(strong('Cliente'), $nombre_cliente));
            $cliente = es_administrador_o_vendedor($data) ? $cliente : '';

            $contenido = [];
            $class = 'strong text-uppercase';
            $se_entregara = d('Se entregará', $class);
            $se_entrego = d('Se Entregó', $class);
            $str_fecha_contra_entrega = ($es_orden_en_proceso) ? $se_entregara : $se_entrego;
            $str_fecha_contra_entrega = ($es_orden_cancelada) ? "" : $str_fecha_contra_entrega;
            $usurio_entrega = (array_key_exists('usuario_entrega', $row)) ? $row['usuario_entrega'] : [];
            $fecha_contra_entrega = _d($str_fecha_contra_entrega, format_fecha($entrega, 1));
            $formato_reparidor = format_nombre($usurio_entrega);
            $text_usuario_entrega = (es_data($usurio_entrega)) ? d($formato_reparidor) : '';
            $fecha_contra_entrega = _d($fecha_contra_entrega, $text_usuario_entrega);

            $izquierdo = [
                $img,
                $numero_recibo,
                $comision,
                $cliente

            ];

            $seccion_izquieda = d($izquierdo, 'd-flex flex-column black');

            $derecho = [
                $monto_compra["seccion"],
                d($fecha_contra_entrega, 'mt-4 black')
            ];

            $seccion_derecha = d($derecho, 'd-flex flex-column');
            $contenido[] = flex($seccion_izquieda, $seccion_derecha, '', 'col-lg-4 my-auto', 'col-lg-8 text-right');





            $config = [
                'id' => $id_orden_compra,
                'class' => _text_('borde_black p-2 col-sm-12 mt-3 ', $extra),
                'href' =>  gestion_visibilidad_pedido($data, $id_orden_compra, $es_orden_entregada, $row["numero_boleto"], $row["usuario_cliente"], $historial)
            ];


            $line = a_enid(append($contenido), $config, 0);



            if ($id_orden_compra != $id_orden_compra_actual) {

                if ($es_orden_en_proceso) {

                    $total_montos_proceso[] = $monto_compra;
                    $linea_en_proceso[] = $line;
                    $total_comisiones = $total_comisiones + $comision_final;
                } else {

                    if ($es_lista_negra || $es_orden_cancelada) {

                        $linea_cambio_lista_negra =
                            en_lista_negra($es_lista_negra, $linea_cambio_lista_negra, $line);
                        $linea_canceladas = en_cancelacion($es_lista_negra, $linea_canceladas, $line);
                    } else {

                        $total_montos_compra[] = $monto_compra;
                        $linea_cambio_estado[] = $line;
                        $total_comisiones = $total_comisiones + $comision_final;
                        $ids_usuarios_ventas[] = $row["id_usuario_referencia"];
                    }
                }

                $id_orden_compra_actual = $id_orden_compra;
            }

            $pos++;
        }

        $numero_vendedores = count(array_unique($ids_usuarios_ventas));
        $numero_usuarios  = count(array_unique(array_column($recibos,  "id_usuario_referencia")));
        $seccion_administrador_montos  =
            totales_ordenes_compra($data, $total_montos_proceso, $total_montos_compra, $total_comisiones, $numero_usuarios, $numero_vendedores);


        $saldos = seccion_saldos_pendientes($data, $saldo_por_cobrar);

        $conversion = conversion($data, $ordenes_en_proceso, $ordenes_canceladas, $ordenes_pagadas, $transacciones);

        $tb_fechas = "";
        if (es_administrador($data)) {
            $tb_fechas = fechas_ventas_recibos($total_montos_compra, $ops_tipo_orden, $tipo_orden);
        }



        $ordenes_por_estados = [
            append($linea_en_proceso),
            append($linea_cambio_estado),
            append($linea_canceladas),
            append($linea_cambio_lista_negra)
        ];

        return compras_pedidos($ordenes_por_estados, $tb_fechas, $conversion, $saldos, $seccion_administrador_montos);
    }
    function gestion_visibilidad_pedido($data, $id_orden_compra, $es_orden_entregada, $numero_boleto, $cliente, $historial)
    {
        
        if($historial){

            $path = path_enid('usuario_contacto', pr($cliente, "id_usuario"));    
            return $path;    
        }

        $path = path_enid('pedidos_recibo', $id_orden_compra);
        if (es_cliente($data)) {

            if ($es_orden_entregada > 0) {
                $path = path_enid('pedido_seguimiento', $id_orden_compra);
            } else {
                $path = path_enid('pedido_seguimiento', $id_orden_compra);
                if ($numero_boleto > 0) {
                    $path = path_enid('area_cliente_compras', $id_orden_compra);
                }
            }
        }
        return $path;
    }
    function seccion_saldos_pendientes($data, $saldo_por_cobrar)
    {

        if (es_cliente($data)) {
            return "";
        }
        $text_saldo = (es_administrador($data)) ? 'saldo por cobrar' : 'total por pagar';
        $clase_saldos = _text_('col-sm-4 ml-auto text-uppercase h4', _strong, _between_md);
        return flex($text_saldo, money($saldo_por_cobrar), $clase_saldos);
    }
    function sin_leads()
    {

        $texto = 'Listo terminamos! no hay más leads de esta lista por hoy!';
        $r[] = d($texto, _text_('h3 text-uppercase black font-weight-bold', _6auto));

        $link = format_link(
            'Ver promociones disponibles',
            [

                "data-toggle" => "tab",
                "href" => "#promo_pendiente"
            ]
        );

        $imagen  = img(
            [
                "src" => "https://media.giphy.com/media/3orif8pKLiSeJP0paw/giphy.gif",
                "class" => "mt-5 mx-auto"
            ]
        );

        $r[] = d($link, _text_(_4auto, 'mt-5'));
        $r[] = d($imagen, _6auto);
        return d($r, 'mt-5 col-md-12 text-center border-secondary p-0');
    }
    function sin_leads_promociones()
    {

        $texto = 'Listo terminamos! no hay más leads de esta lista por hoy!';
        $r[] = d($texto, _text_('h3 text-uppercase black font-weight-bold', _6auto));
        $r[] = d("Aquí hay otra cosas que puedes hacer para aumentar tus ventas", _text_(_6auto, 'mt-5 mb-5'));
        $r[] = d(format_link(
            'Ver recursos',
            [

                "data-toggle" => "tab",
                "href" => "#recursos"
            ]
        ), 6, 1);



        return d($r, 'mt-5 col-md-12 text-center border-secondary p-0');
    }

    function render_resumen_lead($recibos, $recompensas,  $param, $data, $es_promocion = 0)
    {

        $perfil = $param['perfil'];
        $restricciones = $data['restricciones']['orden_entregada'];

        $total = 0;
        $saldo_por_cobrar = 0;
        $ordenes_canceladas = 0;
        $ordenes_en_proceso = 0;
        $transacciones = 0;
        $linea_en_proceso = [];
        $usuarios = [];
        $recibos_ventas = [];
        $ids_ordenes_compra = array_column($recibos, 'id_orden_compra');
        $articulos_en_orden_compra = array_count_values($ids_ordenes_compra);
        $pos = 0;


        $id_orden_compra_actual = 0;
        $total_montos_proceso  = [];

        $total_comisiones  = 0;


        foreach ($recibos as $row) {

            $id_servicio = $row['id_servicio'];
            $cobro_secundario = $row["cobro_secundario"];
            $transacciones++;
            $usuario_venta = prm_def($row, 'usuario', []);
            $usuarios[] = $usuario_venta;
            $monto_a_pagar = $row["monto_a_pagar"];
            $num_ciclos_contratados = $row["num_ciclos_contratados"];
            $monto_a_pagar = ($monto_a_pagar * $num_ciclos_contratados) + $row["costo_envio_cliente"];
            $status = $row["status"];

            $saldo_cubierto = $row['saldo_cubierto'];
            $es_lista_negra = es_orden_lista_negra($row);

            $es_orden_en_proceso = true;

            $ordenes_canceladas = totales($ordenes_canceladas, false);

            $ordenes_en_proceso = totales($ordenes_en_proceso, $es_orden_en_proceso);
            $id_orden_compra = $row["id_orden_compra"];
            $flag_pago_comision = $row["flag_pago_comision"];

            $entrega = $row["fecha_registro"];
            $es_orden_entregada = es_orden_entregada($row, $restricciones);
            $extra = ($es_orden_entregada) ? " entregado" : "";
            $extra = ($es_lista_negra) ? " lista_negra white" : $extra;

            $articulos_en_compra = articulos_en_compra($articulos_en_orden_compra, $id_orden_compra);
            $recibos_ventas = conteo_servicio($recibos_ventas, $id_servicio, $num_ciclos_contratados);

            if ($saldo_cubierto > 0 && !$es_lista_negra && $flag_pago_comision < 1) {

                $extra = 'pago_en_proceso black';
                $saldo_por_cobrar = $saldo_por_cobrar + $row['comision_venta'];
                $total += $monto_a_pagar;
            }


            $img = imagenes_articulos_orden_compra(
                $articulos_en_compra,
                $row,
                $pos,
                $recibos
            );

            $tipo_lead  = 1;
            if ($es_promocion  > 0) {
                $tipo_lead  = 2;
            }
            $monto_compra = monto_compra(
                $cobro_secundario,
                $data,
                $recompensas,
                $articulos_en_compra,
                $id_orden_compra,
                $pos,
                $recibos,
                $tipo_lead
            );



            $monto = $monto_compra["monto"];

            $comisiones = comision_producto_orden_compra(
                $cobro_secundario,
                $monto,
                $articulos_en_compra,
                $row,
                $pos,
                $recibos,
                $data,
                $perfil
            );

            $comision = $comisiones["comision"];
            $comision_final = $comisiones["comision_final"];


            $numero_recibo = span(_text_("#", $id_orden_compra), 'd-md-block d-none');
            $nombre_cliente = format_nombre($row['usuario_cliente']);
            $cliente =  d(_text_(strong('Cliente'), $nombre_cliente));

            $contenido = [];
            $class = 'strong text-uppercase';
            $se_entregara = d('Se entregará', $class);
            $se_entrego = d('Se Entregó', $class);
            $str_fecha_contra_entrega = ($es_orden_en_proceso) ? $se_entregara : $se_entrego;
            $str_fecha_contra_entrega = $str_fecha_contra_entrega;
            $usurio_entrega = (array_key_exists('usuario_entrega', $row)) ? $row['usuario_entrega'] : [];
            $fecha_contra_entrega = _d($str_fecha_contra_entrega, format_fecha($entrega, 1));
            $formato_reparidor = format_nombre($usurio_entrega);
            $text_usuario_entrega = (es_data($usurio_entrega)) ? d($formato_reparidor) : '';
            $fecha_contra_entrega = _d($fecha_contra_entrega, $text_usuario_entrega);

            $izquierdo = [
                $img,
                $numero_recibo,
                $comision,
                $cliente

            ];

            $seccion_izquieda = d($izquierdo, 'd-flex flex-column black');

            $derecho = [
                $monto_compra["seccion"]
            ];

            $seccion_derecha = d($derecho, 'd-flex flex-column');
            $contenido[] = flex($seccion_izquieda, $seccion_derecha, '', 'col-lg-4', 'col-lg-8 text-right');

            $path = path_enid('pedidos_recibo', $id_orden_compra);
            $config = [
                'id' => $id_orden_compra,
                'class' => _text_('border border-secondary p-2 col-sm-12 mt-3 ', $extra),

            ];


            $line = d(append($contenido), $config);



            if ($id_orden_compra != $id_orden_compra_actual) {

                if ($es_orden_en_proceso) {

                    $total_montos_proceso[] = $monto_compra;
                    $linea_en_proceso[] = $line;
                    $total_comisiones = $total_comisiones + $comision_final;
                }

                $id_orden_compra_actual = $id_orden_compra;
            }

            $pos++;
        }




        return append($linea_en_proceso);
    }

    function totales_ordenes_compra($data, $total_montos_proceso, $total_montos_compra, $total_comisiones, $numero_usuarios, $numero_vendedores)
    {

        $es_administrador  = es_administrador($data);
        $descuentos = array_sum(array_column($total_montos_compra, "descuento"));
        $monto_cobro = array_sum(array_column($total_montos_compra, "monto"));
        $utilidad_prevista = array_sum(array_column($total_montos_proceso, "utilidad_en_proceso"));
        $utilidad_entregado = array_sum(array_column($total_montos_compra, "utilidad_entregado"));
        $utilidad_entregado_transporte = $utilidad_entregado - 200;

        $monto_total = flex(
            "Total en ventas",
            money($monto_cobro),
            _between,
            'f11 black',
            'display-6 black'
        );

        $seccion_utilidad_transporte = flex(
            "Utilidad menos transporte",
            money($utilidad_entregado_transporte),
            _between,
            'f11 black',
            'display-6 black'
        );

        $seccion_utilidad = flex(
            "Utilidad",
            money($utilidad_entregado),
            _between,
            'f11 black',
            'display-6 black'
        );

        $seccion_utilidad_en_proceso = flex(
            "Utilidad prevista",
            money($utilidad_prevista),
            _between,
            'f11 black',
            'display-6 black'
        );

        $seccion_descuentos = flex(
            "Descuentos aplicados",
            money($descuentos),
            _between,
            'f11 black',
            'display-6 black'
        );

        $seccion_pago_comisiones = flex(
            "Total pago comisiones",
            money($total_comisiones),
            _between,
            'f11 black',
            'display-6 black'
        );

        $seccion_numero_vendedores = flex(
            "Vendedores que enviaron pedidos",
            $numero_usuarios,
            _between,
            'f11 black',
            'display-6 black'
        );

        $seccion_numero_vendedores_efectivos = flex(
            "Vendedores que lograron ventas",
            $numero_vendedores,
            _between,
            'f11 black',
            'display-6 black'
        );


        $seccion_resumen = [
            $monto_total,
            $seccion_utilidad_transporte,
            $seccion_utilidad,
            $seccion_utilidad_en_proceso,
            $seccion_descuentos,
            $seccion_pago_comisiones,
            $seccion_numero_vendedores,
            $seccion_numero_vendedores_efectivos
        ];
        $seccion_utilidad = d($seccion_resumen, 'mt-5 d-flex flex-column col-sm-6 p-0');
        return ($es_administrador) ? $seccion_utilidad :  '';
    }
    function imagenes_articulos_orden_compra($articulos_en_compra, $row, $pos, $recibos)
    {

        $img = [];
        if ($articulos_en_compra > 0) {

            $a = 0;
            $posicion_final = $pos + $articulos_en_compra;
            foreach ($recibos as $row) {

                if ($a >= $pos && $a < $posicion_final) {

                    $img[] = img(["src" => $row["url_img_servicio"], "class" => "d-block pedido_img"]);
                }
                $a++;
            }
        } else {

            $img[] = img(["src" => $row["url_img_servicio"], "class" => "d-block pedido_img"]);
        }

        return d($img, 'd-flex');
    }
    function articulos_en_compra($articulos_en_orden_compra, $id_orden_compra)
    {

        $articulos = 0;
        foreach ($articulos_en_orden_compra  as $key => $val) {

            if ($key == $id_orden_compra) {

                $articulos = $val;
                break;
            }
        }
        return $articulos;
    }
    function en_lista_negra($es_lista_negra, $linea_cambio_lista_negra, $line)
    {

        if ($es_lista_negra) {

            $linea_cambio_lista_negra[] = $line;
        }

        return $linea_cambio_lista_negra;
    }
    function en_cancelacion($es_lista_negra, $linea_canceladas, $line)
    {

        if (!$es_lista_negra) {

            $linea_canceladas[] = $line;
        }

        return $linea_canceladas;
    }
    function compras_pedidos($ordenes_por_estados, $tb_fechas, $conversion,  $saldos, $seccion_administrador_montos)
    {


        $render = [
            $conversion,
            $tb_fechas,
            $seccion_administrador_montos,
            $saldos,
            $ordenes_por_estados
        ];

        return d(d_c($render, 'row'), 12);
    }

    function conteo_servicio($recibos_ventas, $id_servicio, $num_ciclos_contratados)
    {

        if (es_data($recibos_ventas)) {

            $index = search_bi_array($recibos_ventas, "id_servicio", $id_servicio);
            if ($index === FALSE) {

                $recibos_ventas[] =
                    [
                        "id_servicio" => $id_servicio,
                        "cantidad" => $num_ciclos_contratados
                    ];
            } else {

                $recibos_ventas[$index]['cantidad'] = ($recibos_ventas[$index]['cantidad'] + $num_ciclos_contratados);
            }
        } else {
            $recibos_ventas[] =
                [
                    "id_servicio" => $id_servicio,
                    "cantidad" => $num_ciclos_contratados
                ];
        }
        return $recibos_ventas;
    }



    function descuento_por_orden_compra($recompensas, $id_orden_compra)
    {
        return search_bi_array($recompensas, "id_orden_compra", $id_orden_compra, "descuento", 0);
    }

    function monto_compra(
        $cobro_secundario,
        $data,
        $recompensas,
        $articulos_en_compra,
        $id_orden_compra_actual,
        $pos,
        $recibos,
        $formato_lead = 0
    ) {

        $restricciones = $data['restricciones']['orden_entregada'];
        $monto_orden_compra = 0;
        $monto_orden_compra_cancelado = 0;
        $costos = 0;
        $descuento = descuento_por_orden_compra($recompensas, $id_orden_compra_actual);
        $saldo_cubierto = 0;
        $es_orden_cancelada = false;
        $es_orden_entregada = false;
        $fecha = "";

        $lead_ubicacion    = 0;
        $lead_catalogo     = 0;
        $lead_promo_regalo = 0;


        if ($articulos_en_compra > 0) {
            $a = 0;
            $posicion_final = $pos + $articulos_en_compra;
            foreach ($recibos as $row) {

                if ($a >= $pos && $a < $posicion_final) {

                    $es_orden_entregada = es_orden_entregada($row, $restricciones);
                    $es_orden_cancelada = es_orden_cancelada($row);
                    $saldo_cubierto = $saldo_cubierto  + $row["saldo_cubierto"];
                    $costos = $costos + $row["costo"];

                    if (!$es_orden_cancelada) {

                        $monto_orden_compra = $monto_orden_compra + $row["monto_a_pagar"];
                        $fecha = $row["fecha_pago"];

                        $lead_ubicacion    = $lead_ubicacion + $row["lead_ubicacion"];
                        $lead_catalogo     = $lead_catalogo + $row["lead_catalogo"];
                        $lead_promo_regalo = $lead_promo_regalo +  $row["lead_promo_regalo"];
                    } else {

                        $monto_orden_compra_cancelado =
                            $monto_orden_compra_cancelado + $row["monto_a_pagar"];
                    }
                }

                $a++;
            }
        }

        $monto = ($monto_orden_compra - $descuento);
        $monto_cancelado = ($monto_orden_compra_cancelado - $descuento);

        $comision = ($es_orden_cancelada) ? 0 :  comision_porcentaje($monto, 10);
        $utilidad = ($monto - $costos -  $comision - 100);
        $utilidad_entregado = (!$es_orden_cancelada && $saldo_cubierto > 0) ? $utilidad : 0;
        $utilidad_en_proceso = (!$es_orden_cancelada && !$es_orden_entregada) ? $utilidad : 0;
        $utilidad = ($es_orden_cancelada) ? 0 : $utilidad;

        $texto_pagado = d('Pagado', 'badge mt-4 mb-2 bg-dark white');
        $texto_en_proceso = d('En proceso', 'badge mt-4 mb-2 bg-success white');
        $texto_orden_cancelada = d('Orden cancelada', 'badge mt-4 mb-2 bg-danger white');

        $se_pago_texto = ($saldo_cubierto > 0) ? $texto_pagado : $texto_en_proceso;
        $se_pago_texto = (!$es_orden_cancelada) ? $se_pago_texto : $texto_orden_cancelada;


        $texto_money_aplicado = d(money($monto), 'display-6 strong');
        $texto_money_aplicado_cancelado = d(money($monto_cancelado), 'display-6 strong');
        $texto_money_aplicado =
            ($es_orden_cancelada) ? $texto_money_aplicado_cancelado : $texto_money_aplicado;



        $texto_money = d(del(money($monto_orden_compra)), 'display-7 black');
        $texto_money_cancelado = d(del(money($monto_orden_compra_cancelado)), 'display-7 black');
        $texto_money = ($es_orden_cancelada) ? $texto_money_cancelado : $texto_money;


        $texto_money = ($descuento > 0) ? $texto_money  : "";

        $formato_utilidad = _text_('Utilidad', money($utilidad));

        $texto_utilidad = "";
        if ($formato_lead < 1) {
            $texto_utilidad = span($formato_utilidad, 'white blue_enid3 p-2');
            $texto_utilidad = (es_administrador($data)) ? $texto_utilidad : '';
        }


        $texto_monto_secundario = _text_('+', money($cobro_secundario));
        $texto_monto_secundario = d($texto_monto_secundario, 'display-5 blue_enid');
        $texto_aumento = ($cobro_secundario > $monto) ? $texto_monto_secundario : '';

        $notificacion_envio = "";


        switch ($formato_lead) {
            case 1:
                $notificacion_envio = format_link(
                    "Notificar envío de catálogo",
                    [

                        "class" => "pull-right col-md-5 notificacion_envio_catalogo mt-5",
                        "id" => $id_orden_compra_actual
                    ]
                );

                break;
            case 2:
                $notificacion_envio = format_link(
                    "Notificar envío de promoción",
                    [

                        "class" => "pull-right col-md-5 notificacion_envio_promocion mt-5",
                        "id" => $id_orden_compra_actual
                    ]
                );
                break;
            default:
                break;
        }

        $text = [
            $se_pago_texto,
            $texto_money,
            $texto_aumento,
            $texto_money_aplicado,
            $texto_utilidad,
            $notificacion_envio
        ];

        $seccion =  d_c($text, ['class' => 'text-right text-uppercase']);


        return [
            "seccion" => $seccion,
            "monto" => $monto,
            "descuento" => $descuento,
            "utilidad" => $utilidad,
            "utilidad_en_proceso" => $utilidad_en_proceso,
            "monto_cancelaciones" => $monto_orden_compra_cancelado,
            "utilidad_entregado" => $utilidad_entregado,
            "fecha" => $fecha

        ];
    }

    function conversion($data, $ordenes_en_proceso, $ordenes_canceladas, $ordenes_pagadas, $transacciones)
    {

        if (es_cliente($data)) {
            return "";
        }
        $porcentaje_conversion = number_format(porcentaje_total($ordenes_pagadas, $transacciones), 2);
        $porcentaje_caida = number_format(porcentaje_total($ordenes_canceladas, $transacciones), 2);
        $porcentaje_ordenes_entra = number_format(porcentaje_total($ordenes_en_proceso, $transacciones), 2);

        $base = 'text-center';
        $response[] = flex('Artículos', $transacciones, _text_(_between, 'mt-2 border-bottom botder-md-0 text-uppercase'), $base, $base, 'flex-row');
        $response[] = flex('en proceso', $ordenes_en_proceso, _text_(_between, 'mt-2 border-bottom botder-md-0 text-uppercase'), $base, $base, 'flex-row');
        $response[] = flex('Canceladas', $ordenes_canceladas, _text_(_between, 'mt-2 border-bottom botder-md-0 text-uppercase'), $base, $base, 'flex-row');
        $response[] = flex('compras', $ordenes_pagadas, _text_(_between, 'mt-2 border-bottom botder-md-0 text-uppercase'), $base, $base, 'flex-row');
        $response[] = flex('% cancelación', $porcentaje_caida, _text_(_between, 'mt-2 border-bottom botder-md-0 text-uppercase'), $base, $base, 'flex-row');
        $response[] = flex('% por entregar', $porcentaje_ordenes_entra, _text_(_between, 'mt-2 border-bottom botder-md-0 text-uppercase'), $base, $base, 'flex-row');
        $response[] = flex('% Conversión', $porcentaje_conversion, _text_(_between, 'mt-2 border-bottom botder-md-0 text-uppercase'), $base, $base, 'flex-row');


        return d($response, 'd-md-flex pt-1 pb-1 bg_reporte w-100');
    }

    function totales($actual, $evaluacion)
    {
        if ($evaluacion) {

            $actual++;
        }
        return $actual;
    }


    function fechas_ventas_recibos($recibos, $ops_tipo_orden, $tipo_orden)
    {

        $fechas = array_column($recibos, "fecha");
        $fechas = array_reverse($fechas);

        $calback = function ($n) {
            return substr($n, 0, 10);
        };

        $fechas = array_map($calback, $fechas);
        $ventas_fecha = array_count_values($fechas);
        $response = [];
        $utilidad_final = 0;
        $total_entregas = 0;
        $base = 'mt-5 flex-column border text-center border-secondary p-2';
        foreach ($ventas_fecha as $fecha =>  $entregas) {


            $total = totales_por_fecha($fecha, $recibos);
            $utilidad_final = $utilidad_final + $total;
            $total_entregas = $total_entregas + $entregas;
            $listado = [
                d($fecha),
                d(
                    $entregas,
                    [
                        "class" => "strong",
                        "title" => "Número de pedidos entregados",
                    ]
                ),
                d(
                    money($total),
                    [
                        "class" => "fp9 strong",
                        "title" => "Utilidad después de gastos",
                    ]
                )
            ];

            $response[] = d($listado, $base);
        }


        $listado = [
            d("Utilidad Total", 'display-6 black'),
            d(money($utilidad_final)),
        ];
        $response[] = d($listado, $base);




        $listado_entregas = [
            d("Entregas", 'display-6 black'),
            d($total_entregas),
        ];
        $response[] = d($listado_entregas, $base);
        return append($response);
    }

    function totales_por_fecha($fecha, $recibos)
    {

        $total = -200;
        foreach ($recibos as $row) {

            $fecha_recibo = new DateTime($row["fecha"]);
            $fecha_formato  = date_format($fecha_recibo, 'Y-m-d');
            if ($fecha === $fecha_formato) {

                $total = $total + $row["utilidad"];
            }
        }
        return $total;
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

            $total =
                $saldo_pendiente +
                porcentaje(
                    $saldo_pendiente,
                    3.7,
                    2,
                    0
                );

            $response = path_enid(
                "paypal_enid",
                $total,
                1
            );
        }

        return $response;
    }


    function get_saldo_pendiente(
        $monto,
        $ciclos,
        $cubierto,
        $envio_cliente,
        $envio_sistema,
        $tipo_entrega
    ) {


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

            foreach ($param as $recibo) {
                $response = [
                    "saldo_pendiente" => (($recibo["precio"] * $recibo["num_ciclos_contratados"]) + $recibo["costo_envio_cliente"]),
                    "cuenta_correcta" => 1,
                    "resumen" => $recibo["resumen_pedido"],
                    "costo_envio_cliente" => $recibo["costo_envio_cliente"],
                    "flag_envio_gratis" => $recibo["flag_envio_gratis"],
                    "id_recibo" => $recibo["id"],
                    "id_usuario" => $recibo["id_usuario"],
                    "id_usuario_venta" => $recibo["id_usuario_venta"],
                    "id_servicio" => $recibo['id_servicio']
                ];
            }
        }

        return $response;
    }

    function carga_estado_compra($data, $id_status, $id_orden_compra, $vendedor = 0)
    {

        $texto = texto_status_orden($data, $id_status, $vendedor);

        $detalles = text_icon(_money_icon, "Detalles de tu compra");
        $text_icono = ($vendedor == 1) ? "Detalle de la compra" : $detalles;

        $texto_completo = flex($text_icono, $texto, "d-flex flex-column");

        $text = tab(
            $texto_completo,
            "#tab_renovar_servicio",
            [
                "class" => 'resumen_pagos_pendientes mt-4 mb-4 fp8',
                "id" => $id_orden_compra,
            ]
        );

        return d($text, 'col-md-4');
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
            _titulo(mayorque($modalidad, 0, "Ventas", "Compras"));
    }

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

        return d($resumen, "informacion_resumen_envio");
    }


    function format_concepto($productos_orden_compra, $deuda, $tipos_entrega)
    {


        $r[] = d(imagenes_orden_compra($productos_orden_compra), 'mx-auto text-center');
        $ticket_pago = ticket_pago($deuda, $tipos_entrega);
        $r[] = $ticket_pago['checkout'];


        return [
            'checkout_resumen' => d($r, 'bg-light p-5 w-100'),
            'checkout' => $ticket_pago
        ];
    }

    function get_format_punto_encuentro($data_complete, $recibo)
    {

        $r = [];
        if (
            es_data($data_complete) &&
            array_key_exists("punto_encuentro", $data_complete) &&
            es_data($data_complete["punto_encuentro"])
        ) {

            $p = $data_complete["punto_encuentro"][0];
            $costo_envio = $p["costo_envio"];

            $r[] = d(h("LUGAR DE ENCUENTRO", 3, "top_30 underline "), 1);
            $x[] = d(
                $p["tipo"] . " " . $p["nombre"] . " " . "NÚMERO " . $p["numero"] . " COLOR " . $p["color"],
                "top_20",
                1
            );
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
            a_enid(
                'CANCELAR COMPRA',
                [
                    "class" => "cancelar_compra",
                    "id" => $id_recibo,
                    "modalidad" => '0',
                ]
            ),
            "top_20",
            1
        );

        return append($t);
    }

    function getPayButtons($data, $url_request, $id_usuario_venta, $checkout)
    {

        $id_orden_compra = $data["id_orden_compra"];
        $tipo_entrega = $checkout["tipo_entrega"];

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
                'href' => path_enid('pedido_seguimiento', _text($id_orden_compra, '&domicilio=1&asignacion=1')),
                'class' => 'black'
            ]
        );
        $text_descuento = ($tipo_entrega == 2) ? $texto_cambio_contra_entrega : $text_descuento;




        $response[] = _titulo(
            $text_descuento,
            1
        );

        return d($response, "col-lg-12 seccion_compra p-0");
    }

    function get_vista_cliente($data)
    {

        $modalidad = $data["modalidad"];
        $ordenes = $data["ordenes"];

        $r[] = d(get_text_modalidad($modalidad, $ordenes), 'mt-5');
        $text = ($modalidad == 1) ? "ÚLTIMAS VENTAS" : "ÚLTIMAS COMPRAS";
        $boton = btn($text, ["class" => "ver_mas_compras_o_ventas mt-5 mb-5 col-sm-3"]);
        $r[] = d(d($boton, 12), 13);

        $r[] = create_listado_compra_venta($data);
        $r[] = d(place("contenedor_ventas_compras_anteriores"), 13);

        return d($r);
    }

    function create_listado_compra_venta($data)
    {

        $list = [];
        $ordenes = $data["ordenes"];
        $modalidad = $data["modalidad"];
        $id_perfil = $data["id_perfil"];

        $hay_ordenes = es_data($data["ordenes"]);
        if (fx($data, "modalidad,id_usuario") && $hay_ordenes) {


            foreach ($ordenes as $row) {

                $id_orden_compra = $row["id_orden_compra"];
                $imagen = img(
                    [
                        "src" => $row["url_img_servicio"],
                        "class" => 'imagen_articulo_compras',
                    ]
                );

                $t = a_enid($imagen, path_enid("producto", $row["id_servicio"]));
                $status = $row["status"];
                $t = _text_($t, carga_estado_compra($data, $status, $id_orden_compra, $modalidad));

                if ($id_perfil == 3) {

                    $url = path_enid("pedidos_recibo", $id_orden_compra);
                    $avanzado = btn("AVANZADO", [], 1, 1, 0, $url);
                    $t = _text_($t, $avanzado);
                }

                $clase = 'align-items-center d-md-flex border 
                          border border-secondary mt-4 mb-4 
                          p-4 justify-content-between min_block text-center';

                $list[] = d(d($t, $clase), 1);
            }
        }


        return append($list);
    }

    function get_view_compras($status_enid_service, $compras, $tipo)
    {

        $tipo_transaccion = search_bi_array(
            $status_enid_service,
            "id_estatus_enid_service",
            $tipo,
            "nombre"
        );

        $tipo_solicitud = d(d(_titulo($tipo_transaccion), 12), 13);

        $r = [];
        foreach ($compras as $row) {

            $response = [];
            $url_imagen = $row["url_img_servicio"];

            $response[] = img(
                [
                    "src" => $url_imagen,
                    "onerror" => "this.src='../img_tema/portafolio/producto.png'",
                    "class" => "col-md-12"
                ]
            );

            $monto_a_pagar = $row["monto_a_pagar"];
            $response[] = d(_titulo(money($monto_a_pagar), 2), 12);
            $r[] = d($response, "border-bottom mt-5 p-5 text-center row mt-5");
        }

        array_unshift($r, $tipo_solicitud);
        return d($r, 6, 1);
    }

    function rastreo_compra($data, $id_orden_compra)
    {


        $seccion[] =
            format_link(
                "Rastrea tu orden",
                [

                    "href" => path_enid('pedido_seguimiento', _text($id_orden_compra)),
                ],
                1,
                0
            );

        $seccion[] = format_link(
            "CAMBIAR LA DIRECCIÓN DE ENTREGA",
            [

                "href" => path_enid('procesar_ubicacion', $id_orden_compra),
                'class' => 'mt-3 cursor_pointer',
            ],
            0,
            0
        );


        $domicilios = $data["domicilios"];
        $tiene_domicilio = (tiene_domilio($domicilios, 1) > 0);
        if (!$tiene_domicilio) {

            $texto = "Ups! parece que 
            aún no nos indicas donde 
            debemos llevar tu pedido";
            $seccion[] = d($texto,  'red_enid strong text-center mt-3');
        }

        return d($seccion, 'col-sm-12 seccion_adicionales_compra');
    }

    function repartidor_disponible(array $repartidores_en_entrega, array $repartidores)
    {

        $id_usuario = 1;
        if (es_data($repartidores)) {

            $array_repartidores_entrega = array_column($repartidores_en_entrega, 'id_usuario_entrega');
            $array_repartidores_entrega = array_unique($array_repartidores_entrega);

            if (es_data($array_repartidores_entrega) && $array_repartidores_entrega[0] < 1) {

                $id_usuario = $repartidores[0];
            } else {

                $ocupados = array_intersect($repartidores, $array_repartidores_entrega);
                $disponibles = elimina_ocupados($repartidores, $ocupados);
                $id_usuario = proximo_disponible($disponibles, $id_usuario);
            }
        }

        return $id_usuario;
    }

    function elimina_ocupados($array_repartidores, $ocupados)
    {

        if (es_data($array_repartidores)) {

            for ($a = 0; $a < count($ocupados); $a++) {

                if (array_key_exists($a, $ocupados)) {

                    $ocupado = $ocupados[$a];
                    $index = array_search($ocupado, $array_repartidores);
                    if ($index !== false) {
                        unset($array_repartidores[$index]);
                    }
                }
            }
        }

        return $array_repartidores;
    }

    function proximo_disponible($disponibles, $id_usuario)
    {

        foreach ($disponibles as $row) {

            if ($row > 0) {
                $id_usuario = $row;
            }
            break;
        }

        return $id_usuario;
    }

    function tracker_franja_horaria($recibos)
    {

        $fecha_contra_entrega = array_column($recibos, 'fecha_contra_entrega');
        $fecha_hora = array_unique($fecha_contra_entrega);

        $response = [];
        if (es_data($fecha_contra_entrega)) {

            $text = flex_md(
                'entrega programada el',
                format_fecha($fecha_contra_entrega[0], 1),
                _between_md,
                '',
                _strong
            );
            $response[] = _titulo($text, 5);
        }
        foreach ($recibos as $row) {

            $id_recibo = $row['id'];
            $pedido = d(_text_('#', $id_recibo));
            $num_ciclos_contratados = $row['num_ciclos_contratados'];
            $img = img(
                [
                    "src" => $row['url_img_servicio'],
                    'class' => 'w_50'
                ]
            );

            $contenido = [];
            $contenido[] = d($pedido);
            $articulos = flex('Artículos ', $num_ciclos_contratados, _between, 'mr-2');
            $contenido[] = d($articulos);
            $contenido[] = d(_text_($img, 'Rastrear pedido'));
            $linea = d($contenido, _text_('d-md-flex', _between_md, 'border p-2'));
            $response[] = a_enid(
                $linea,
                [

                    'href' => path_enid('pedido_seguimiento', $id_recibo),
                    'class' => 'black'
                ]

            );
        }
        return append($response);
    }

    function identificador($dias)
    {

        $mayor = 0;
        foreach ($dias as $row) {

            if ($row > $mayor) {

                $mayor = $row;
            }
        }
        return $mayor;
    }

    function format_top_semanal($fechas, $titulo, $class = '')
    {

        $dias = [];

        foreach ($fechas as $row) {

            $fecha = $row["fecha"];
            $total = $row["total"];
            $numero_dia = intval(date_create($fecha)->format("w"));
            $dias[$numero_dia] = array_key_exists($numero_dia, $dias) ? ($dias[$numero_dia] + $total) : $total;
        }

        $dias_texto = [
            "Domingo", "Lunes", "Martes",
            "Miércoles", "Jueves", "Viernes", "Sábado"
        ];

        $a = 0;
        $total_ventas = 0;


        $mayor = identificador($dias);
        foreach ($dias_texto as $row) {

            if (array_key_exists($a, $dias)) {
                $clase_extra = ($dias[$a] == $mayor) ? 'mayor' : '';

                $top_dia[] = flex(
                    $row,
                    $dias[$a],
                    'flex-column',
                    'strong black text-uppercase',
                    $clase_extra
                );

                $total_ventas = $total_ventas + $dias[$a];
            } else {

                $top_dia[] = flex($row, 0, 'flex-column', 'strong black text-uppercase');
            }

            $a++;
        }

        $clase_top = 'd-flex justify-content-between 
        align-items-center w-100 text-center col-lg-10 col-lg-offset-1';

        $classe_completa = _text_($clase_top, $class);
        $contenido[] = d(d($titulo, $classe_completa), 'row mt-5 mb-5');
        $contenido[] = d(d($top_dia, $clase_top), 'row mt-5 mb-5');

        return [
            "render" => append($contenido),
            "dias" => $dias,
            "totales" => $total_ventas
        ];
    }

    function top($articulos, $top_horas, $articulos_cancelados, $fechas, $fechas_cancelaciones, $ventas_hoy, $ventas_menos_7)
    {

        $response = [];
        if (es_data($articulos)) {

            $format_semanal =
                format_top_semanal(
                    $fechas,
                    'Dias - ventas',
                    'text-uppercase strong black'
                );

            $ventas = $format_semanal["dias"];
            $totales_ventas = $format_semanal["totales"];

            $response[] = $format_semanal["render"];
            $top = flex(_titulo('Ventas', 4), _titulo("Artículo", 4), _between);
            $contenido_top[] = d($top);

            foreach ($articulos as $row) {

                $url_img_servicio = $row['url_img_servicio'];
                $img = img(
                    [
                        "src" => $url_img_servicio,
                        "class" => "img_servicio_def p-2 w_50",
                    ]
                );

                $top = flex(_titulo($row['total']), $img, _between);
                $contenido_top[] = d($top);
            }


            $top_articulos = d($contenido_top, 'col-md-8 mt-5 mb-5');
            $top_horas_ventas = d(formato_horas_ventas($top_horas), 'col-md-4 mt-5 mb-5');


            $response[] = d(d([$top_articulos, $top_horas_ventas], 'col-md-10 col-md-offset-1'), 'row mt-5 mb-5');

            $formato_semanal_caidas =
                format_top_semanal(
                    $fechas_cancelaciones,
                    'Días - cancelaciones',
                    'text-uppercase red_enid strong'
                );

            $response[] = $formato_semanal_caidas["render"];
            $caidas = $formato_semanal_caidas["dias"];
            $totales_caidas = $formato_semanal_caidas["totales"];

            $response[] = formato_dias_caidas($ventas, $caidas, $totales_ventas, $totales_caidas, $ventas_hoy, $ventas_menos_7);
        }

        return d($response, 12);
    }

    function formato_horas_ventas($top_horas)
    {


        $response[] = flex('franja horaria', 'ventas en hora', _text_(_between, 'text-uppercase blue_enid3 white strong p-2'));
        foreach ($top_horas as $row) {

            $formato = 'Y-m-d H:i:s';
            $hora = $row["hora"];

            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $fecha_hora = DateTime::createFromFormat($formato, _text($hoy, ' ', $hora, ':00:00'));


            $total = $row["total"];

            $response[] = flex($fecha_hora->format('H:i'), $total, _text_(_between, 'text-center mt-3dae'), 'underline black strong');
        }

        return append($response);
    }

    function formato_dias_caidas($ventas, $caidas, $totales_ventas, $totales_caidas, $ventas_hoy, $ventas_menos_7)
    {

        $response = [];
        $total_negativo = 0;
        $dias_negativos = 0;

        $total_positivos = 0;
        $dias_positivos = 0;


        for ($a = 0; $a < 7; $a++) {

            $numero_caidas = array_key_exists($a, $caidas) ? $caidas[$a] : 0;
            $numero_ventas = array_key_exists($a, $ventas) ? $ventas[$a] : 0;

            $diferencia = (intval($numero_ventas) - intval($numero_caidas));
            if ($diferencia < 0) {

                $total_negativo = ($total_negativo + ($diferencia * -1));
                $dias_negativos++;
            } else {

                $total_positivos = ($total_positivos + $diferencia);
                $dias_positivos++;
            }

            $response[] = d($diferencia, 'strong black text-uppercase text-center');
        }

        $clase = 'd-flex justify-content-between 
        align-items-center w-100 text-center 
        col-lg-10 col-lg-offset-1 strong black 
        text-uppercase border-bottom';

        $contenido[] = d(d("Diferencia", $clase), 'row mt-5 mb-5');
        $contenido[] = d(d($response, $clase), 'row mt-5 mb-5');

        $despliegue_caidas[] = flex("Hoy", $ventas_hoy, "flex-column");
        $despliegue_caidas[] = flex("Hace 7", $ventas_menos_7, "flex-column");


        $despliegue_caidas[] = flex("Ventas en periodo", $totales_ventas, "flex-column");
        $despliegue_caidas[] = flex("Caidas en periodo", $totales_caidas, "flex-column");
        $despliegue_caidas[] = flex("Caidas contra entregas", $total_negativo, "flex-column red_enid");
        $despliegue_caidas[] = flex("Entregas contra caidas", $total_positivos, "flex-column black");
        $despliegue_caidas[] = flex("Días positivos", $dias_positivos, "flex-column black");
        $despliegue_caidas[] = flex("Días negativos", $dias_negativos, "flex-column red_enid");


        $contenido[] = d(d($despliegue_caidas, $clase), 'row mt-5 mb-5');


        return append($contenido);
    }
    function sintesis_compras(&$servicios, &$recibos, &$linea_cambio_lista_negra, &$tota_cancelaciones)
    {

        $totales = 0;
        $response = [];
        if (es_data($servicios)) {

            sksort($servicios, 'cantidad');
            foreach ($servicios as $row) {

                $id_servicio = $row['id_servicio'];
                $cantidad = $row["cantidad"];

                $totales = $totales + $cantidad;
                $path_imagen_servicio = search_bi_array(
                    $recibos,
                    "id_servicio",
                    $id_servicio,
                    "url_img_servicio",
                    ""
                );

                $img = img(
                    [
                        "src" => $path_imagen_servicio,
                        "class" => "mx-auto d-block pedido_img"
                    ]
                );

                $link = path_enid('producto', $id_servicio);
                $link_imagen = a_enid($img, $link);

                $fila = flex(
                    $link_imagen,
                    _titulo($cantidad, 2),
                    _text_(_between, 'border'),
                    '',
                    'mr-3'
                );

                $response[] = d($fila, 13);
            }
            $response[] = d(p(_text_('Cancelaciones', strong($tota_cancelaciones)), 'ml-auto mt-5 black text-uppercase'), 13);
            $response[] = d(p(_text_('Ordenes en lista negra', count($linea_cambio_lista_negra)), 'ml-auto black text-uppercase'), 13);
            $response[] = d(p(_text_('Artículos vendidos', $totales), 'ml-auto black text-uppercase strong p-2 border border-dark'), 13);
        }
        return d($response, 'mt-5');
    }
}
