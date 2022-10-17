<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function valida_fecha_entrega($fecha_entrega)
    {

        $response = false;
        $hoy = date("Y-m-d");
        $dias_entrega = date_difference($hoy, $fecha_entrega);
        $len = strlen($fecha_entrega) == 10;
        if (($len && $dias_entrega >= 0) && $dias_entrega <= 30) {
            $response = true;
        }

        return $response;
    }

    function valida_horario_entrega($horario_entrega)
    {
        $horarios = [
            "08:00",
            "08:30",
            "09:00",
            "09:30",
            "10:00",
            "10:30",
            "11:00",
            "11:30",
            "12:00",
            "12:30",
            "13:00",
            "13:30",
            "14:00",
            "14:30",
            "15:00",
            "15:30",
            "16:00",
            "16:30",
            "17:00",
            "17:30",
            "18:00",
            "18:30",
            "19:00",

        ];

        return in_array($horario_entrega, $horarios);
    }
}

