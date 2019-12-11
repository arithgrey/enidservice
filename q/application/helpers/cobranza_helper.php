<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

//    function texto_costo_envio_info_publico($envio_gratis, $costo_envio_cliente,$tipo_entrega)
//    {
//
//        if ($envio_gratis > 0) {
//
//            $r = [
//                "cliente" => "ENTREGA GRATIS!",
//                "cliente_solo_text" => "ENTREGA GRATIS!",
//                "ventas_configuracion" => "TU PRECIO YA INCLUYE EL ENVÍO",
//            ];
//
//
//        } else {
//
//            $text = $costo_envio_cliente . " MXN DE ENVÍO";
//            $str = _text(
//                "MÁS ",
//                $costo_envio_cliente,
//                " MXN DE TU ENTREGA"
//            );
//            $r = [
//                "ventas_configuracion" => "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO",
//                "cliente_solo_text" => $str,
//                "cliente" => $text
//            ];
//        }
//
//        return $r;
//    }

    function valida_fecha_entrega($fecha_entrega)
    {


        $r = 0;
        $hoy = date("Y-m-d");
        $dias_entrega = date_difference($hoy, $fecha_entrega);
        $len = strlen($fecha_entrega) == 10;
        if ($len && $dias_entrega >= 0 && $dias_entrega <= 4) {
            $r = 1;
        }

        return $r;
    }

    function valida_horario_entrega($horario_entrega)
    {
        $horarios = [
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
            "16:30",
            "17:00",
            "17:30",
            "18:00",
            "19:00",

        ];

        return in_array($horario_entrega, $horarios);
    }
}

