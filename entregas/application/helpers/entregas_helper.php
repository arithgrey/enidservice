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
        $response[] = d(format_fecha($fecha), _text_(_strong, 'border-bottom'));
        $fechas_contra_entrega = array_column($proximas_entregas, 'fecha_contra_entrega');

        foreach ($horarios as $row) {


            $total_pedidos_franja_horaria = busqueda_horario($row, $fecha, $fechas_contra_entrega);
            $extra = ($total_pedidos_franja_horaria > 0) ? 'text-white bg-dark' : '';
            $response[] = d(_d($row, $total_pedidos_franja_horaria), _text_('border-bottom mt-5', $extra));

        }
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
