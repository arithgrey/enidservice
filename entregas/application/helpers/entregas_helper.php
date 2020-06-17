<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function calendario_entregas($data)
    {
        $proximas_entregas = $data['proximas_entregas'];
        $franja[] = franja_entregas($proximas_entregas, $data);
        $franja_horaria[] = append($franja);

        $response[] = d($franja_horaria, 12);
        return append($response);

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

                $abrir_en_google = $nota_pedido['abrir_en_google'];
                $maps_link = $nota_pedido['maps_link'];
                $descripcion_domicilio = $nota_pedido['descripcion_domicilio'];
                $nombre_vendedor = $nota_pedido['nombre_vendedor'];
                $nombre_cliente = $nota_pedido['nombre_cliente'];
                $nombre_usuario_entrega = $nota_pedido['nombre_usuario_entrega'];
                $orden = d(_text('#', $id_recibo), 'text-center');
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

                $desglose_pedido = path_enid("pedidos_recibo", $row["id_recibo"]);
                $tracker = path_enid("pedido_seguimiento", $row["id_recibo"]);
                $url = ($es_reparto > 0) ? $tracker : $desglose_pedido;
                $link = a_enid($text,
                    [
                        'href' => $url,
                        'class' => 'col-md-4 col-md-offset-4'
                    ]
                );
                $pedido = [];
                $pedido[] = d($link, "row border-bottom mb-5");

                if ($abrir_en_google > 0) {
                    $seccion_maps = d($maps_link, 'col-md-4 col-md-offset-4');
                    $pedido[] = d($seccion_maps, "row mt-1 mb-5 ");
                }

                if ($es_hoy || $es_menor) {
                    $filtros = _text_($filtro, $filtros_direccion);
                    $ventas_hoy[] = d($pedido, $filtros);
                }

                $f++;
            }


            if (es_data($recibos)) {

                $r[] = d(_titulo(_text_(count($recibos), 'Entregas en proceso')), 'mb-5');
                $r[] = reporte_reparto($ids_usuario_entrega, $repartidores, $data);

                $filtros_reparto[] = d(icon(_text_(_repato_icon, 'fa-2x filtro_menos_opciones text-secondary')),
                    ['class' => 'mx-auto '], 13);
                $filtros_reparto[] = d(icon(_text_(_repato_icon, 'fa-2x filtro_mas_opciones black d-none')),
                    ['class' => 'mx-auto '], 13);

                $filtros_ubicacion[] = d(icon(_text_(_maps_icon, 'fa-2x filtro_sin_ubicacion text-secondary')),
                    ['class' => 'mx-auto '], 13);

                $filtros_ubicacion[] = d(icon(_text_(_maps_icon, 'fa-2x filtro_ubicacion d-none')),
                    ['class' => 'mx-auto '], 13);


                $ubicacion = append($filtros_reparto);
                $reparto = append($filtros_ubicacion);
                $r[] = d(d(flex($ubicacion, $reparto, _between), 'col-md-4 col-md-offset-4'), 13);
                $r[] = append($ventas_hoy);

            }

        }

        return d($r, 'mt-5 col-md-12 text-center border-secondary p-0');
    }

    function reporte_reparto(&$ids_usuarios_entregas, &$repartidores, &$data)
    {

        $entregas_asignadas = array_count_values($ids_usuarios_entregas);
        $response = [];
        $es_administrador = es_administrador($data);
        if ($es_administrador){

            foreach ($entregas_asignadas as $clave => $valor) {

                $nombre_usuario_entrega = search_bi_array($repartidores, 'id', $clave, 'nombre_usuario_entrega');
                $contenido = flex($nombre_usuario_entrega, $valor, _text_(_between,'border-bottom'),'text-uppercase');
                $response[] = d(d($contenido ,4,1),13);

            }
        }

        return d($response,'mb-5');

    }

    function nota_pedido($total, $dia_entrega, $es_contra_entrega,
                         $es_contra_entrega_domicilio_sin_direccion,
                         $ubicacion, $text_entrega, $row)
    {
        $response = [];
        $response[] = d($total);
        $response[] = $dia_entrega;
        $tipo_entrega = $row['tipo_entrega'];
        $abrir_en_google = 0;
        $maps_link = '';
        $solicitar_ubicacion = 0;
        $nombre_usuario_entrega = '';

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
        $nombre_vendedor = (strlen($vendedor) > 0) ? $text_vendedor : '';

        $usuario_entrega = $row['usuario_entrega'];
        $usuario_entrega = format_nombre($usuario_entrega);
        $nombre_usuario_entrega = $usuario_entrega;
        $usuario_cliente = $row['usuario_cliente'];
        $nombre_cliente = format_nombre($usuario_cliente);
        $telefono_cliente = phoneFormat(pr($usuario_cliente, 'tel_contacto'));

        $cliente = d(_text_(strong('cliente'), $nombre_cliente, $telefono_cliente), 'text-uppercase black');
        $repartidor = d(_text_(strong('Entregará'), $usuario_entrega), 'text-uppercase black');
        $nombre_repartidor = (strlen($usuario_entrega) > 0) ? $repartidor : '';


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
                $response = d(_text_('Estación del metro', $nombre),
                    'mb-5 text-uppercase strong black text-center'
                );
            }
        } else {
            $response = d('(Pedir ubicación)', 'text-danger mb-5');
        }
        return $response;
    }

    function descripcion_entregas_domicilio($row, $id_domicilio, $data_domicilio,
                                            $es_contra_entrega, $ubicacion, $text_entrega,
                                            $es_contra_entrega_domicilio_sin_direccion)
    {
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
                    'class' => 'text-uppercase black mt-3'
                ];

                $text = format_link('abrir en google maps', $conf);

            }
        }
        return $text;
    }

}
