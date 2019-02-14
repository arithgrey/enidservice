<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('invierte_date_time')) {


        function create_estaciones($array, $flag_envio_gratis)
        {

            $l = "";
            foreach ($array as $row) {

                $nombre = $row["nombre"];
                $id = $row["id"];
                $costo_envio = $row["costo_envio"];

                $l .= div($nombre,
                    [
                        "class" =>
                            "nombre_estacion cursor_pointer punto_encuentro",
                        "id" => $id,
                        "nombre_estacion" => $nombre,
                        "costo_envio" => $costo_envio,
                        "flag_envio_gratis" => $flag_envio_gratis


                    ]);
            }

            $text = place("nombre_linea_metro") . place("nombre_estacion_punto_encuentro") . place("cargos_por_entrega") . place("mensaje_cobro_envio") . guardar("CONTINUAR", ["class" => "btn_continuar_punto_encuentro"]);
            return div($text, ["class" => 'resumen_encuentro']) . place("quien_recibe") . div($l, ["class" => "contenedor_estaciones"]);
        }

    }