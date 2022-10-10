<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function pedidos_en_proceso($data, $recibos, $es_reparto = 0)
    {

        $f = 0;
        $ventas_posteriores = [];
        $ventas_hoy = [];
        $es_cliente = es_cliente($data);
        $response = "";
        $lineas = 0;

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

                        $linea = linea_compra_productos(
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

                    $linea = linea_compra($row, $es_cliente, $data, $id_orden_compra, $es_reparto);
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

        return $response;
            
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
    function linea_compra(
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
        $nombre_vendedor = (!$es_vendedor && !$es_cliente) ? $agenda :
            '';
        $identificador = flex($orden, $nombre_vendedor, 'flex-column', "strong h5 mt-5");
        $seccion_imagenes = flex($imagenes, $identificador, 'flex-column black', '', 'fp8');
        $text = flex($seccion_imagenes, $total_seccion, _between);

        $desglose_pedido = path_enid("pedidos_recibo", $id_orden_compra);
        $tracker = path_enid("pedido_seguimiento", $id_orden_compra);
        $url = ($es_cliente || $es_reparto > 0) ? $tracker : $desglose_pedido;
        $extra_class = ($es_hoy || $es_menor || $es_cliente) ? '' : 'venta_futura d-none';

        return d(a_enid($text, $url), _text_("border-bottom", $extra_class));
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

            $titulo = es_repartidor($data) ? 'Próximas entregas' : 'Tus ventas en proceso';
            $titulo = es_cliente($data) ? 'Tus pedidos en curso' : $titulo;

            $response[] = d(_titulo($titulo));
            $response[] = append($ventas_hoy);
            $response[] = append($ventas_posteriores);
            $opciones = _text_(_mas_opciones_bajo_icon, 'fa-2x mt-3 mas_ventas_notificacion');
            $response[] = d(icon($opciones), 'text-center ');

            $menos_opciones = _text_(_mas_opciones_icon, 'fa-2x mt-3 menos_ventas_notificacion d-none');
            $response[] = d(icon($menos_opciones), 'text-center');
        }
        return d($response, "seccion_ventas_pendientes");
    }

}
