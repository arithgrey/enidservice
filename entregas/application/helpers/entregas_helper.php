<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

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

    function franja_horaria($fecha, $proximas_entregas)
    {


        $horarios = array_horarios();
        $fecha_titulo = d(format_fecha($fecha), _strong);
        $fechas_contra_entrega = array_column($proximas_entregas, 'fecha_contra_entrega');

        $total_dia = 0;
        foreach ($horarios as $row) {

            $total_pedidos_franja_horaria = busqueda_horario($row, $fecha, $fechas_contra_entrega);
            $extra = ($total_pedidos_franja_horaria > 0) ? 'text-white bg-primary strong f11 entregas_franja_horaria cursor_pointer' : '';
            if ($total_pedidos_franja_horaria > 0) {

                $total_dia = ($total_dia + $total_pedidos_franja_horaria);
            }

            $text_entregas_franja_horaria = ($total_pedidos_franja_horaria > 0) ? $total_pedidos_franja_horaria : '';

            $franja = _text($fecha, ' ', $row);
            $config = [
                'class' => _text_('border-bottom mt-5', $extra)
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
