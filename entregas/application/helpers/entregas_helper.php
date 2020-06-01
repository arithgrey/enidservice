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

    function calendario($data)
    {
        $fecha = horario_enid();
        $proximas_entregas = $data['proximas_entregas'];
        $hoy = $fecha->format('Y-m-d');
        $franja_horaria = [];

        for ($a = 0; $a < 6; $a++) {

            $fecha = add_date($hoy, $a);
            $franja = [];
            $franja[] = franja_horaria($fecha, $proximas_entregas);
            $franja_horaria[] = append($franja);

        }

        $response[] = d(_titulo('Próximas entregas', 2), 12);
        $response[] = d($franja_horaria, 12);
        return append($response);

    }


    function franja_entregas($recibos, $data)
    {

        $r = [];
        $es_reparto = 1;
        $f = 0;
        $ventas_posteriores = [];
        $ventas_hoy = [];
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

                $text_entrega = _text_('Se entregará en ', $dias, 'días!');
                $text_entrega_paso = _text_('Pendiente desde hace', $dias, 'días');
                $text_entrega = (!$es_mayor) ? $text_entrega_paso : $text_entrega;
                $id_recibo = $row['id_recibo'];

                $ubicacion = $row['ubicacion'];
                if ($dias == 1 && $es_mayor) {
                    $text_entrega = 'Se entregará mañana';
                } elseif ($dias == 1 && !$es_mayor) {
                    $text_entrega = 'La entrega fué ayer';
                } elseif ($ubicacion > 0) {
                    $text_entrega = '';
                }


                $tipo_entrega = $row['tipo_entrega'];
                $es_contra_entrega = $row['es_contra_entrega'];
                $es_contra_entrega_domicilio_sin_direccion = false;
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

                $es_formato_hora = (($tipo_entrega == 1) || ($tipo_entrega == 2 && $format_hora));
                $hora_entrega = ($es_formato_hora) ? format_hora($fecha_contra_entrega) : '';
                $notificacion_hoy = ($hoy === $fecha_entrega) ? '' : $text_entrega;

                $es_hoy = ($hoy === $fecha_entrega) ? 'bg-dark white' : '';
                $dia_entrega = d(_text_($notificacion_hoy, $hora_entrega), _text_('strong', $es_hoy));

                $imagenes = d(img($row["url_img_servicio"]), 'w-25 mx-auto mt-5');
                $totales_recibo = money($row["total"]);
                $total = d($totales_recibo, "black");
                $id_usuario_entrega = $row['id_usuario_entrega'];


                $ubicacion = $row['ubicacion'];

                $text_total = nota_pedido(
                    $total,
                    $dia_entrega,
                    $es_contra_entrega,
                    $es_contra_entrega_domicilio_sin_direccion,
                    $id_usuario_entrega,
                    $ubicacion,
                    $text_entrega,
                    $row
                );


                $orden = d(_text('#', $id_recibo), 'text-center');

                $text = _d($imagenes, $orden, $text_total);

                $desglose_pedido = path_enid("pedidos_recibo", $row["id_recibo"]);
                $tracker = path_enid("pedido_seguimiento", $row["id_recibo"]);
                $url = ($es_reparto > 0) ? $tracker : $desglose_pedido;


                $linea = d(a_enid($text, $url), "border-bottom");
                if ($es_hoy || $es_menor) {
                    $ventas_hoy[] = $linea;
                }

                $f++;
            }

            if (es_data($recibos)) {

                $titulo = 'Entregas en proceso';
                $r[] = d(_titulo($titulo));
                $r[] = append($ventas_hoy);

            }

        }

        return d($r, 'mt-5 col-md-12 text-center border-secondary p-0');
    }

    function nota_pedido($total, $dia_entrega, $es_contra_entrega,
                         $es_contra_entrega_domicilio_sin_direccion,
                         $id_usuario_entrega, $ubicacion, $text_entrega, $row)
    {
        $text_total = [];
        $text_total[] = d($total);
        $text_total[] = $dia_entrega;

        $tipo_entrega = $row['tipo_entrega'];

        switch ($tipo_entrega) {
            case 1:

                $id_punto_encuentro = $row['id_punto_encuentro'];
                if ($id_punto_encuentro > 0) {
                    $punto_encuentro = $row['data_punto_encuentro'];
                    if (es_data($punto_encuentro)) {
                        $nombre = $punto_encuentro["nombre"];
                        $text_total[] = d(_text_('Estación del metro', $nombre), 'mb-5 text-uppercase strong black text-center');
                    }
                } else {
                    $text_total[] = d('(Pedir ubicación)', 'text-danger mb-5');
                }

                break;

            case 2:

                $id_domicilio = $row['id_domicilio'];
                $data_domicilio = $row['data_domicilio'];

                if ($es_contra_entrega) {
                    $text_total[] = ($ubicacion < 1) ? '' : d($text_entrega);
                    if ($es_contra_entrega_domicilio_sin_direccion && $ubicacion < 1) {
                        $text_total[] = d('(Pedir ubicación)', 'text-danger mb-5');
                    } else if ($ubicacion > 0) {
                        $text_ubicacion = text_ubicacion($row['data_ubicacion']);
                        $text_total[] = d($text_ubicacion, 'mb-5 black text-center');
                    } else if ($id_domicilio > 0) {
                        $text_domicilio = text_domicilio($data_domicilio);
                        $text_total[] = d($text_domicilio, 'mb-5 black text-center');
                    }
                }
                break;

            default:
                break;
        }


        return $text_total;


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

    function text_ubicacion($domicilio)
    {
        $response = prm_def($domicilio, 'ubicacion');
        $response = valida_texto_maps($response, 0);

        return $response;
    }

    function franja_horaria($fecha, $proximas_entregas)
    {


        $horarios = array_horarios();
        $horario_enid = horario_enid();
        $hora_actual = $horario_enid->format('H');
        $hoy = $horario_enid->format('Y-m-d');
        $es_hoy = ($hoy == $fecha);


        $str_fecha = ($es_hoy) ? 'Hoy ' : format_fecha($fecha);
        $fecha_titulo = d($str_fecha, _strong);
        $fechas_contra_entrega = (es_data($proximas_entregas)) ? array_column($proximas_entregas, 'fecha_contra_entrega') : [];
        $hay_ordenes_ocultas = 0;
        $total_dia = 0;
        foreach ($horarios as $row) {

            $total_pedidos_franja_horaria = busqueda_horario($row, $fecha, $fechas_contra_entrega);
            $extra = ($total_pedidos_franja_horaria > 0) ? 'text-white bg-primary strong f11 entregas_franja_horaria cursor_pointer' : '';
            if ($total_pedidos_franja_horaria > 0) {

                $total_dia = ($total_dia + $total_pedidos_franja_horaria);
            }

            $text_entregas_franja_horaria = ($total_pedidos_franja_horaria > 0) ? $total_pedidos_franja_horaria : '';

            $franja = _text($fecha, ' ', $row);
            $horario = date_create($row)->format('H');
            $extra_franja_horaria = ($es_hoy && $hora_actual > $horario) ? 'opciones_ocultas d-none' : '';
            if ($es_hoy && $hora_actual > $horario) {
                $hay_ordenes_ocultas++;
            }
            $config = [
                'class' => _text_('border-bottom mt-5', $extra, $extra_franja_horaria)
            ];
            if (($total_pedidos_franja_horaria > 0)) {
                $config['onclick'] = 'busqueda_ordenes_franja_horaria("' . $franja . '")';
            }
            $response[] = d(
                _d($row, $text_entregas_franja_horaria), $config
            );

        }

        $str_total = ($total_dia > 0) ? $total_dia : '';
        $entregas_programadas = d($str_total);
        $text = ($total_dia > 0) ? 'Entregas programadas' : 'Sin entregas';
        $bottom = ($total_dia > 0) ? '' : 'mb-4';
        $str_entregas = d($text, _text_('fp8 text-uppercase', $bottom));
        $totales = d(_text_($str_entregas, $entregas_programadas), 'border-bottom');
        if ($hay_ordenes_ocultas > 0) {
            array_unshift($response, icon(_text_(_mas_opciones_bajo_icon, 'mostrar_todo')));
        }
        array_unshift($response, $totales);
        array_unshift($response, $fecha_titulo);

        return d($response, 'border col-md-2 text-center border-secondary p-0');
    }

    function busqueda_horario($horario, $fecha_calendario, $lista_horarios)
    {

        $pedidos_en_horario = 0;
        foreach ($lista_horarios as $row) {
            $fecha_entrega = date_create($row)->format('Y-m-d');
            if ($fecha_entrega == $fecha_calendario) {
                $hora_entrega = date_create($row)->format('H:i');
                if ($hora_entrega == $horario) {

                    $pedidos_en_horario++;
                }
            }
        }
        return $pedidos_en_horario;
    }


}
