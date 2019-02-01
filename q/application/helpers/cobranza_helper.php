<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('invierte_date_time')) {

        function texto_costo_envio_info_publico($flag_envio_gratis, $costo_envio_cliente, $costo_envio_vendedor)
        {
            $response = [];
            if ($flag_envio_gratis > 0) {


                $response["cliente"]                = "ENTREGA GRATIS!";
                $response["cliente_solo_text"]      = "ENTREGA GRATIS!";
                $response["ventas_configuracion"]   = "TU PRECIO YA INCLUYE EL ENVÍO";
            } else {
                $response["ventas_configuracion"]   = "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO";
                $text                               = "MÁS " . $costo_envio_cliente . " MXN DE ENVÍO";
                $response["cliente_solo_text"]      = "MÁS " . $costo_envio_cliente . " MXN DE TU ENTREGA";
                $response["cliente"] = $text;
            }
            return $response;
        }
        function valida_fecha_entrega($fecha_entrega)
        {

            $response = 0;
            $hoy = date("Y-m-d");
            $dias_entrega = date_difference($hoy, $fecha_entrega);
            if (strlen($fecha_entrega) == 10 && $dias_entrega >= 0 && $dias_entrega <= 4) {
                $response = 1;
            }
            return $response;
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
            ];
            return in_array($horario_entrega, $horarios);
        }
    }

