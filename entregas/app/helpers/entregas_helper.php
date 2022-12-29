<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function sin_cierre_reparto($data, $recibos, $es_reparto = 0)
    {

        if (!es_data($recibos)) {

            return sin_entregas_agendadas();
        }
        $f = 0;
        $ventas_posteriores = [];
        $ventas_hoy = [];
        $es_cliente = es_cliente($data);
        $response = "";
        $lineas = 0;
        $totales = 0;

        if (es_administrador_o_vendedor($data)) {
            $data_complete[] = d(format_link(
                "notificar todos los pedidos como entregados",
                [
                    "class" => "notificacion_entregados",
                ]
            ),"col-sm-4 col-sm-offset-4 mt-3");
        }

        if (es_data($recibos)) {


            $ids_orden_compra = array_count_values(array_column($recibos, "id_orden_compra"));
            sksort($recibos, "fecha_contra_entrega", true);
            $a = 0;
            $id_anterior = 0;

            foreach ($recibos as $row) {

                $id_orden_compra = $row['id_orden_compra'];
                $total = total_orden_compra($ids_orden_compra, $id_orden_compra);
                $fecha_entrega = date_create($row['fecha_contra_entrega'])->format('Y-m-d');
                $fecha = horario_enid();
                $hoy = $fecha->format('Y-m-d');
                $es_mayor = ($fecha_entrega > $hoy);
                $dias = date_difference($hoy, $fecha_entrega);
                $es_menor = ($dias > 0 && !$es_mayor);
                $es_hoy = ($hoy === $fecha_entrega) ? 'bg-dark white' : '';


                if ($total > 1) {
                    $linea = "";
                    if ($id_anterior !== $id_orden_compra) {

                        $linea = linea_compra_productos_reparto(
                            $recibos,
                            $id_orden_compra,
                            $es_cliente,
                            $data,
                            $es_reparto,
                            $total
                        );
                        $id_anterior = $id_orden_compra;
                    }
                } else {

                    $linea = linea_compra_reparto($row, $es_cliente, $data, $id_orden_compra, $es_reparto);
                }


                if ($es_hoy || $es_menor) {

                    $ventas_hoy[] = $linea;
                } else {

                    $ventas_posteriores[] = $linea;
                }

                $f++;
            }

            $response = ayuda_tipo_entrega($recibos, $data, $ventas_hoy, $ventas_posteriores);
        }


        $data_complete[] =  d($response, 4, 1);
        return d($data_complete,'mt-5');
    }


    function ayuda_notificacion(
        $data,
        $usuario_entrega,
        $total,
        $dia_entrega,
        $es_contra_entrega,
        $id_usuario_entrega,
        $ubicacion,
        $total_articulos,
        $es_contra_entrega_domicilio_sin_direccion
    ) {

        $text_total = [];
        $icon = '';
        $es_cliente = es_cliente($data);
        if ($id_usuario_entrega > 0) {

            $icono = icon(_entregas_icon);
            $nombre_repatidor = format_nombre($usuario_entrega);
            $texto_icono = flex($icono, $nombre_repatidor, "justify-content-end", "mr-1");
            $icon = ($es_cliente) ? '' : $texto_icono;
        }

        $text_total[] = d($total, "ml-auto h4 strong");
        if ($total_articulos > 0) {
            $clases = _text_("black", "justify-content-end text-secondary mt-2");
            $text_total[] = flex($total_articulos, "artículos", $clases, "mr-1");
        }

        $text_total[] = d($icon, "black");
        $text_total[] = $dia_entrega;


        $sin_ubicacion = ($es_contra_entrega_domicilio_sin_direccion && $ubicacion < 1);
        $clase_notificacion_ubiacion =
            'text-danger text-danger border p-1 border-danger border-top-0 border-right-0 border-left-0';
        $texto_sin_direccion = d('Falta la dirección', $clase_notificacion_ubiacion);
        $text_total[] = ($sin_ubicacion) ? $texto_sin_direccion : '';


        return $text_total;
    }
    function ayuda_tipo_entrega($recibos, $data, $ventas_hoy, $ventas_posteriores)
    {

        $response = [];
        if (es_data($recibos)) {

            $descuentos_recibos = $data["descuentos_recibos"];
            $ids_orden_compra = array_column($recibos, "id_orden_compra");
            $ordenes_compra = count(array_unique($ids_orden_compra));
            $arreglo_totales = array_column($recibos, "total");
            $suma_por_cobrar = array_sum($arreglo_totales);
            $suma_descuentos = array_sum(array_column($descuentos_recibos, 'descuento'));

            $total_ordenes_compra = count(array_unique(array_column($recibos, "id_orden_compra")));

            $total_gastos_entregas = $total_ordenes_compra * 100;
            $total_por_cobrar = ($suma_por_cobrar - $suma_descuentos);
            $total_pago_comisiones = comision_porcentaje($total_por_cobrar, 10);

            $utilidad_costos_pedidos = utilidad_costos_pedidos($recibos);
            $utilidad_costos_pedidos_descuentos = $utilidad_costos_pedidos - $suma_descuentos;

            $ganancias = $utilidad_costos_pedidos_descuentos -
                $total_pago_comisiones - $total_gastos_entregas;


            $titulo =  _text_('Próximas entregas', $ordenes_compra);
            $response[] = d(_titulo($titulo, 2, 'bg_black white text-center p-2'));
            if (es_administrador($data)) {
                $response[] = d(
                    _text_("Total por cobrar", money($total_por_cobrar)),
                    'display-6 black'
                );
                $response[] = del(_text_("Total", money($suma_por_cobrar)), 'f11');
                $response[] = d(_text_("Descuentos", money($suma_descuentos)), 'f11 ');
                $response[] = d(_text_("Utilidad Glogal", money($utilidad_costos_pedidos)), 'f11 ');
                $response[] = d(_text_("Pago de comisiones", money($total_pago_comisiones)), 'f11 ');
                $response[] = d(_text_("Pago de entregas", money($total_gastos_entregas)), 'f11 ');
                $response[] = d(_text_("Utilidad", money($ganancias)), 'f11 ');
                $ganancias_gas =  $ganancias - 200;
                $response[] = d(_text_("Utilidad menos Gas", money($ganancias_gas)), 'f13 black ');
            }
            $response[] = append($ventas_hoy);
            $response[] = append($ventas_posteriores);
            $opciones = _text_(_mas_opciones_bajo_icon, 'fa-2x mt-3 mas_ventas_notificacion');
            $response[] = d(icon($opciones), 'text-center ');

            $menos_opciones = _text_(_mas_opciones_icon, 'fa-2x mt-3 menos_ventas_notificacion d-none');
            $response[] = d(icon($menos_opciones), 'text-center');
        }

        return append($response);
    }
    function utilidad_costos_pedidos($recibos)
    {

        $utilidad = 0;
        foreach ($recibos as $row) {

            $precio = $row["precio"];
            $costo = $row["costo"];
            $num_ciclos_contratados = $row["num_ciclos_contratados"];

            $precios_finales = ($precio * $num_ciclos_contratados);
            $costos_finales = ($costo * $num_ciclos_contratados);
            $utilidad_actual = ($precios_finales - $costos_finales);


            $utilidad = $utilidad + $utilidad_actual;
        }

        return $utilidad;
    }
    function utilidad_precio_servicio($precio, $costo, $articulos = 1)
    {


        $precio_articulos  = $precio * $articulos;
        $costo_articulos = $costo * $articulos;
        $utilidad = ($precio_articulos - $costo_articulos);
        return $utilidad;
    }

    function linea_compra_productos_reparto($recibos, $id, $es_cliente, $data, $es_reparto, $total)
    {

        $recibo = [];
        $a = 0;
        $id_orden = 0;
        $total_orden_compra = 0;
        $total_articulos = 0;

        foreach ($recibos as $row) {

            $id_orden_compra = $row['id_orden_compra'];
            if ($id_orden_compra == $id) {
                $total_articulos = ($total_articulos + $row["num_ciclos_contratados"]);
                $id_orden = $id_orden_compra;
                $total_orden_compra = ($total_orden_compra + $row["total"]);

                if ($a < 1) {

                    $recibo = $row;
                } else {
                    $a = 0;
                }
            }
        }

        return linea_compra_reparto(
            $recibo,
            $es_cliente,
            $data,
            $id_orden,
            $es_reparto,
            $total_orden_compra,
            $total_articulos
        );
    }
    function formato_hora_contra_entrega($es_contra_entrega, $row, $ubicacion)
    {
        $format_hora = 0;
        if ($es_contra_entrega) {
            $es_contra_entrega_domicilio_sin_direccion = $row['es_contra_entrega_domicilio_sin_direccion'];
            $format_hora = 1;
            if ($es_contra_entrega_domicilio_sin_direccion) {
                $format_hora = 0;
            }
            if ($ubicacion > 0) {
                $format_hora = 1;
            }
        }
        return $format_hora;
    }

    function formato_texto_entrega($text_entrega, $row, $dias, $es_mayor)
    {

        $ubicacion = $row['ubicacion'];
        if ($dias == 1 && $es_mayor) {
            $text_entrega = 'Se entregará mañana';
        } elseif ($dias == 1 && !$es_mayor) {
            $text_entrega = 'La entrega fué ayer';
        } elseif ($ubicacion > 0) {
            $text_entrega = '';
        }
        return $text_entrega;
    }
    function linea_compra_reparto(
        $row,
        $es_cliente,
        $data,
        $id_orden_compra,
        $es_reparto,
        $total_orden_compra = 0,
        $total_articulos = 0
    ) {


        $fecha_contra_entrega = $row['fecha_contra_entrega'];
        $fecha_entrega = date_create($fecha_contra_entrega)->format('Y-m-d');
        $fecha = horario_enid();
        $hoy = $fecha->format('Y-m-d');
        $es_mayor = ($fecha_entrega > $hoy);
        $dias = date_difference($hoy, $fecha_entrega);
        $es_menor = ($dias > 0 && !$es_mayor);

        $text_entrega = _text_('Se entregará en ', $dias, 'días!');
        $text_entrega_paso = _text_('La fecha de entrega fué hace ', $dias, 'días!');
        $text_entrega = (!$es_mayor) ? $text_entrega_paso : $text_entrega;

        $ubicacion = $row['ubicacion'];
        $text_entrega = formato_texto_entrega($text_entrega, $row, $dias, $es_mayor);

        $tipo_entrega = $row['tipo_entrega'];
        $es_contra_entrega = $row['es_contra_entrega'];

        $format_hora = formato_hora_contra_entrega($es_contra_entrega, $row, $ubicacion);

        $es_formato_hora = (($tipo_entrega == 1) || ($tipo_entrega == 2 && $format_hora));
        $hora_entrega = ($es_formato_hora) ? format_hora($fecha_contra_entrega) : '';
        $notificacion_hoy = ($hoy === $fecha_entrega) ? 'Se entregá hoy! ' : $text_entrega;

        $es_hoy = ($hoy === $fecha_entrega) ? 'bg-dark white' : '';
        $dia_entrega = d(_text_($notificacion_hoy, $hora_entrega), _text_('badge mt-4 mb-4', $es_hoy));
        $imagenes = d(img($row["url_img_servicio"]), "w_50");

        $descuento_recompensa = $row["descuento_recompensa"];
        $total_orden_compra = $total_orden_compra - $descuento_recompensa;
        $totales_recibo = ($total_orden_compra > 0) ? money($total_orden_compra) : money($row["total"]);
        $total = d($totales_recibo, "text-left black");
        $id_usuario_entrega = $row['id_usuario_entrega'];

        $usuario_entrega = ($es_cliente) ? [] : $row['usuario_entrega'];
        $ubicacion = $row['ubicacion'];
        $es_contra_entrega_domicilio_sin_direccion = $row["es_contra_entrega_domicilio_sin_direccion"];

        $text_total = ayuda_notificacion(
            $data,
            $usuario_entrega,
            $total,
            $dia_entrega,
            $es_contra_entrega,
            $id_usuario_entrega,
            $ubicacion,
            $total_articulos,
            $es_contra_entrega_domicilio_sin_direccion

        );

        $total_seccion = d($text_total, 'd-flex flex-column');
        $orden = _text('ORDEN #', $id_orden_compra);
        $es_vendedor = es_vendedor($data);
        $agenda = flex("Agenda", $row['nombre_vendedor'], "flex-column");
        $nombre_vendedor = (!$es_vendedor && !$es_cliente) ? $agenda : '';
        $identificador = flex($orden, $nombre_vendedor, 'flex-column', "strong h5 mt-5");
        $seccion_imagenes = flex($imagenes, $identificador, 'flex-column black', '', 'fp8');
        $text = flex($seccion_imagenes, $total_seccion, _between);

        $desglose_pedido = path_enid("pedidos_recibo", $id_orden_compra);
        $tracker = path_enid("pedido_seguimiento", $id_orden_compra);
        $url = ($es_cliente || $es_reparto > 0) ? $tracker : $desglose_pedido;
        $extra_class = ($es_hoy || $es_menor || $es_cliente) ? '' : 'venta_futura d-none';

        return d(a_enid($text, $url), _text_("border border-secondary p-2 col-sm-12 mt-3", $extra_class));
    }
    function total_orden_compra($ids_orden_compra, $id)
    {

        $total = 0;
        foreach ($ids_orden_compra as $clave => $valor) {

            if (intval($id) === $clave) {

                $total = $valor;
            }
        }
        return $total;
    }
    function text_tiempo_entrega($dias, $es_mayor, $ubicacion)
    {
        $response = '';
        if ($dias == 1 && $es_mayor) {
            $response = 'Se entregará mañana';
        } elseif ($dias == 1 && !$es_mayor) {
            $response = 'La entrega fué ayer';
        } elseif ($ubicacion > 0) {
            $response = '';
        }
        return $response;
    }

    function formato_hora($es_contra_entrega, $ubicacion, $row)
    {
        $response = 0;
        $es_contra_entrega_domicilio_sin_direccion = false;
        if ($es_contra_entrega) {
            $es_contra_entrega_domicilio_sin_direccion = $row['es_contra_entrega_domicilio_sin_direccion'];
            $response = 1;
            if ($es_contra_entrega_domicilio_sin_direccion) {
                $response = 0;
            }
            if ($ubicacion > 0) {
                $response = 1;
            }
        }
        return [
            'formato_hora' => $response,
            'es_contra_entrega_domicilio_sin_direccion' => $es_contra_entrega_domicilio_sin_direccion
        ];
    }

    function franja_entregas($recibos, $data)
    {

        $r = [];
        $es_reparto = 1;
        $f = 0;
        $ventas_hoy = [];
        $ids_usuario_entrega = [];
        $repartidores = [];

        $proximas_entregas = [];
        if (es_data($recibos)) {

            sksort($recibos, "fecha_contra_entrega", true);
            foreach ($recibos as $row) {

                $fecha_contra_entrega = $row['fecha_contra_entrega'];
                $fecha_entrega = date_create($fecha_contra_entrega)->format('Y-m-d');
                $fecha = horario_enid();

                $hoy = $fecha->format('Y-m-d');
                $es_mayor = ($fecha_entrega > $hoy);

                $dias = date_difference($hoy, $fecha_entrega);
                $es_menor = ($dias > 0 && !$es_mayor);
                $id_recibo = $row['id_recibo'];

                $ubicacion = $row['ubicacion'];
                $text_entrega = text_tiempo_entrega($dias, $es_mayor, $ubicacion);
                $tipo_entrega = $row['tipo_entrega'];
                $es_contra_entrega = $row['es_contra_entrega'];

                $format_hora = formato_hora($es_contra_entrega, $ubicacion, $row);
                $es_contra_entrega_domicilio_sin_direccion = $format_hora['es_contra_entrega_domicilio_sin_direccion'];
                $es_formato_hora = (($tipo_entrega == 1) || ($tipo_entrega == 2 && $format_hora['formato_hora']));
                $hora_entrega = ($es_formato_hora) ? format_hora($fecha_contra_entrega) : '';
                $notificacion_hoy = ($hoy === $fecha_entrega) ? '' : $text_entrega;

                $es_hoy = ($hoy === $fecha_entrega) ? 'bg-dark white' : '';
                $dia_entrega = d(_text_($notificacion_hoy, $hora_entrega), _text_('strong', $es_hoy));

                $imagenes = d(img($row["url_img_servicio"]), 'w-50 mx-auto');
                $totales_recibo = money($row["total"]);
                $total = d($totales_recibo, "black");
                $id_usuario_entrega = $row['id_usuario_entrega'];
                $ubicacion = $row['ubicacion'];


                $nota_pedido = nota_pedido(
                    $total,
                    $dia_entrega,
                    $es_contra_entrega,
                    $es_contra_entrega_domicilio_sin_direccion,
                    $ubicacion,
                    $text_entrega,
                    $row
                );

                $id_orden_compra = $row["id_orden_compra"];
                $abrir_en_google = $nota_pedido['abrir_en_google'];
                $maps_link = $nota_pedido['maps_link'];
                $descripcion_domicilio = $nota_pedido['descripcion_domicilio'];
                $nombre_vendedor = $nota_pedido['nombre_vendedor'];
                $nombre_cliente = $nota_pedido['nombre_cliente'];
                $nombre_usuario_entrega = $nota_pedido['nombre_usuario_entrega'];
                $orden = d(_text('#', $id_orden_compra), 'text-center');
                $usuario_entrega = $nota_pedido['usuario_entrega'];
                $solicitar_ubicacion = $nota_pedido['solicitar_ubicacion'];

                $icon = d(icon(_text_(_entregas_icon, 'fa-2x')), 'black text-right');
                $indicador_entrega = ($id_usuario_entrega > 0) ? $icon : '';
                $filtro = ($id_usuario_entrega > 0) ? 'reparto_asignado' : '';
                $filtros_direccion = ($solicitar_ubicacion > 0) ? 'ubicacion_asignada' : '';

                if ($id_usuario_entrega > 0) {

                    $ids_usuario_entrega[] = $id_usuario_entrega;
                    $repartidores[] = [
                        'id' => $id_usuario_entrega,
                        'nombre_usuario_entrega' => $nombre_usuario_entrega
                    ];
                }


                $text = _d(
                    $indicador_entrega,
                    $imagenes,
                    $orden,
                    $nombre_cliente,
                    $nombre_vendedor,
                    $usuario_entrega,
                    $descripcion_domicilio

                );

                $id_orden_compra = $row["id_orden_compra"];
                $desglose_pedido = path_enid("pedidos_recibo", $id_orden_compra);
                $tracker = path_enid("pedido_seguimiento", $id_orden_compra);
                $url = ($es_reparto > 0) ? $tracker : $desglose_pedido;
                $link = a_enid(
                    $text,
                    [
                        'href' => $url,
                        'class' => 'col-md-4 col-md-offset-4'
                    ]
                );
                $pedido = [];
                $pedido[] = d($link, "row border-bottom mb-5");

                $indicador = _text('linea_', $id_usuario_entrega);

                if ($abrir_en_google > 0) {
                    $seccion_maps = d($maps_link, 'col-md-4 col-md-offset-4');
                    $pedido[] = d($seccion_maps, "row mt-1 mb-5 ");
                }

                if ($es_hoy || $es_menor) {

                    $filtros = _text_(
                        $filtro,
                        $filtros_direccion,
                        'ubicacion_asignada se_entrega_hoy ',
                        $indicador
                    );

                    $ventas_hoy[] = d($pedido, $filtros);
                } else {

                    $proximas_entregas[] = d(
                        $pedido,
                        'ubicacion_asignada se_entregara_despues d-none',
                        $indicador
                    );
                }

                $f++;
            }


            if (es_data($recibos)) {

                $extregas = a_enid(
                    'Ordenes liberadas',
                    [
                        'href' => path_enid('pedidos_reparto'),
                        'class' => 'strong black underline'
                    ]
                );

                $texto = (count($recibos) > 1) ? 'Entregas' : "Entrega";
                $texto_entregas = _text_(count($recibos), $texto, ' en proceso');
                $clase = 'display-4 white bg_black col-md-4 col-md-offset-4 col-sm-12';
                $r[] = d(d($texto_entregas, $clase), 'mb-5 row');
                $r[] = d($extregas, 'mb-5');
                $r[] = reporte_reparto($ids_usuario_entrega, $repartidores, $data);


                $link_proximas_entregas =
                    a_enid(
                        'Ver entregas que serán mañana',
                        [
                            'class' => 'black underline diplay-6'
                        ]
                    );
                $r[] = d(
                    $link_proximas_entregas,
                    'mostrar_proximas_entregas'
                );
                $link_entregas = a_enid(
                    'Ver entregas por liberar hoy',
                    [
                        'class' => ' black underline'
                    ]
                );
                $r[] = d(
                    $link_entregas,
                    'entregas_por_liberar_hoy d-none diplay-6'
                );

                $filtros_reparto[] = d(
                    icon(_text_(_repato_icon, 'fa-2x filtro_menos_opciones text-secondary')),
                    ['class' => 'mx-auto '],
                    13
                );
                $filtros_reparto[] = d(
                    icon(_text_(_repato_icon, 'fa-2x filtro_mas_opciones black d-none')),
                    ['class' => 'mx-auto '],
                    13
                );

                $filtros_ubicacion[] =
                    d(
                        icon(_text_(_maps_icon, 'fa-2x filtro_sin_ubicacion text-secondary')),
                        ['class' => 'mx-auto '],
                        13
                    );

                $filtros_ubicacion[] = d(
                    icon(_text_(_maps_icon, 'fa-2x filtro_ubicacion d-none')),
                    ['class' => 'mx-auto '],
                    13
                );


                $ubicacion = append($filtros_reparto);
                $reparto = append($filtros_ubicacion);
                $r[] = d(d(flex($ubicacion, $reparto, _between), 'col-md-4 col-md-offset-4'), 13);
                $r[] = append($ventas_hoy);
                $r[] = append($proximas_entregas);
            }
        } else {


            return sin_entregas_agendadas();
        }

        return d($r, 'mt-5 col-md-12 text-center border-secondary p-0');
    }

    function sin_entregas_agendadas()
    {

        $texto = 'Ups! parece que algo anda mal, no hay ventas, tenemos que regresar a conseguir clientes!';
        $r[] = d($texto, _text_('h3 text-uppercase black font-weight-bold', _6auto));

        $link = format_link(
            'Ver artículos disponibles',
            [
                'href' => path_enid('home')
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
        $r[] = d(format_link(
            "Actividades recién notificadas",
            [
                "href" => path_enid("busqueda"),
                "class" =>  "mt-5"
            ],
            0
        ), 4, 1);

        return d($r, 'mt-5 col-md-12 text-center border-secondary p-0');
    }
    /**/

    function reporte_reparto(&$ids_usuarios_entregas, &$repartidores, &$data)
    {

        $entregas_asignadas = array_count_values($ids_usuarios_entregas);
        $response = [];
        $es_administrador = es_administrador($data);
        if ($es_administrador) {

            foreach ($entregas_asignadas as $clave => $valor) {

                $nombre_usuario_entrega = search_bi_array($repartidores, 'id', $clave, 'nombre_usuario_entrega');
                $contenido = flex($nombre_usuario_entrega, $valor, _text_(_between, 'border-bottom'), 'text-uppercase');
                $response[] = d(d($contenido, 4, 1), ['class' => 'row repartidor cursor_pointer black_cursor_pointer', 'id' => $clave]);
            }
        }

        return d($response, 'mb-5');
    }

    function nota_pedido(
        $total,
        $dia_entrega,
        $es_contra_entrega,
        $es_contra_entrega_domicilio_sin_direccion,
        $ubicacion,
        $text_entrega,
        $row
    ) {
        $response = [];
        $response[] = d($total);
        $response[] = $dia_entrega;
        $tipo_entrega = $row['tipo_entrega'];
        $abrir_en_google = 0;
        $maps_link = '';
        $solicitar_ubicacion = 0;


        switch ($tipo_entrega) {
            case 1:

                $id_punto_encuentro = $row['id_punto_encuentro'];
                $response[] = descripcion_entregas_puntos_encuentro($id_punto_encuentro, $row);

                break;

            case 2:

                $id_domicilio = $row['id_domicilio'];
                $data_domicilio = $row['data_domicilio'];
                $descripcion_domicilio = descripcion_entregas_domicilio(
                    $row,
                    $id_domicilio,
                    $data_domicilio,
                    $es_contra_entrega,
                    $ubicacion,
                    $text_entrega,
                    $es_contra_entrega_domicilio_sin_direccion
                );
                $abrir_en_google = $descripcion_domicilio['abrir_en_google'];
                $maps_link = $descripcion_domicilio['maps_link'];
                $response[] = $descripcion_domicilio['texto_direccion'];
                $solicitar_ubicacion = $descripcion_domicilio['solicitar_ubicacion'];

                break;

            default:
                break;
        }

        $vendedor = prm_def($row, 'nombre_vendedor', '');
        $text_vendedor = d(_text_(strong('Agenda'), $vendedor), 'text-uppercase black');
        $nombre_vendedor = (str_len($vendedor, 0)) ? $text_vendedor : '';

        $usuario_entrega = $row['usuario_entrega'];
        $usuario_entrega = format_nombre($usuario_entrega);
        $nombre_usuario_entrega = $usuario_entrega;
        $usuario_cliente = $row['usuario_cliente'];
        $nombre_cliente = format_nombre($usuario_cliente);
        $telefono_cliente = phoneFormat(pr($usuario_cliente, 'tel_contacto'));

        $cliente = d(_text_(strong('cliente'), $nombre_cliente, $telefono_cliente), 'text-uppercase black');
        $repartidor = d(_text_(strong('Entregará'), $usuario_entrega), 'text-uppercase black');
        $nombre_repartidor = (str_len($usuario_entrega, 0)) ? $repartidor : '';


        return
            [
                'descripcion_domicilio' => $response,
                'abrir_en_google' => $abrir_en_google,
                'maps_link' => $maps_link,
                'nombre_vendedor' => $nombre_vendedor,
                'usuario_entrega' => $nombre_repartidor,
                'solicitar_ubicacion' => $solicitar_ubicacion,
                'nombre_cliente' => $cliente,
                'telefono_cliente' => $telefono_cliente,
                'nombre_usuario_entrega' => $nombre_usuario_entrega
            ];
    }

    function descripcion_entregas_puntos_encuentro($id_punto_encuentro, $row)
    {
        $response = '';
        if ($id_punto_encuentro > 0) {
            $punto_encuentro = $row['data_punto_encuentro'];
            if (es_data($punto_encuentro)) {
                $nombre = $punto_encuentro["nombre"];
                $response = d(
                    _text_('Estación del metro', $nombre),
                    'mb-5 text-uppercase strong black text-center'
                );
            }
        } else {
            $response = d('(Pedir ubicación)', 'text-danger mb-5');
        }
        return $response;
    }

    function descripcion_entregas_domicilio(
        $row,
        $id_domicilio,
        $data_domicilio,
        $es_contra_entrega,
        $ubicacion,
        $text_entrega,
        $es_contra_entrega_domicilio_sin_direccion
    ) {
        $abrir_en_google = 0;
        $response = '';
        $maps_link = '';
        $solicitar_ubicacion = 0;
        if ($es_contra_entrega) {
            $response = ($ubicacion < 1) ? '' : d($text_entrega);
            if ($es_contra_entrega_domicilio_sin_direccion && $ubicacion < 1) {
                $response = d('(Pedir ubicación)', 'text-danger mb-5');
                $solicitar_ubicacion++;
            } else if ($ubicacion > 0) {

                $text_ubicacion = prm_def($row['data_ubicacion'], 'ubicacion');
                $response = d($text_ubicacion, 'mb-5 black text-center');
                $maps_link = texto_maps($text_ubicacion, 0);
                $abrir_en_google++;
            } else if ($id_domicilio > 0) {

                $text_domicilio = text_domicilio($data_domicilio);
                $response = d($text_domicilio, 'mb-5 black text-center');
            }
        }
        return
            [
                'texto_direccion' => $response,
                'abrir_en_google' => $abrir_en_google,
                'maps_link' => $maps_link,
                'solicitar_ubicacion' => $solicitar_ubicacion
            ];
    }


    function text_domicilio($domicilio)
    {

        $response = '';
        if (es_data($domicilio)) {

            $calle = $domicilio['calle'];
            $entre_calles = $domicilio['entre_calles'];
            $numero_exterior = $domicilio['numero_exterior'];
            $asentamiento = $domicilio['asentamiento'];
            $municipio = $domicilio['municipio'];
            $ciudad = $domicilio['ciudad'];
            $cp = $domicilio['cp'];
            $numero_interior = $domicilio['numero_interior'];

            $response = _text_(
                $calle,
                '#',
                $numero_exterior,
                'Interior',
                '#',
                $numero_interior,
                $asentamiento,
                ', ',
                $municipio,
                $ciudad,
                'C.P.',
                $cp,
                'referencia o entre calles',
                $entre_calles

            );
        }
        return $response;
    }

    function texto_maps($domicilio)
    {
        $ubicacion_arreglo = explode(' ', $domicilio);
        $text = '';
        foreach ($ubicacion_arreglo as $row) {
            if (strpos($row, 'https') !== FALSE) {

                $conf = [
                    'href' => $row,
                    'target' => '_blank',
                    'class' => 'text-uppercase black mt-3 border border-info text-center'
                ];

                $text = format_link('abrir en google maps', $conf);
            }
        }
        return $text;
    }
}
