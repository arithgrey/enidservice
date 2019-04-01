<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function create_estaciones($array, $flag_envio_gratis)
    {

        $l = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];
            $costo_envio = $row["costo_envio"];

            $l[] = div($nombre,
                [
                    "class" =>
                        "nombre_estacion cursor_pointer punto_encuentro",
                    "id" => $id,
                    "nombre_estacion" => $nombre,
                    "costo_envio" => $costo_envio,
                    "flag_envio_gratis" => $flag_envio_gratis


                ]);
        }


        $r[] = place("nombre_linea_metro");
        $r[] = place("nombre_estacion_punto_encuentro");
        $r[] = place("cargos_por_entrega");
        $r[] = place("mensaje_cobro_envio");
        $r[] = guardar("CONTINUAR", ["class" => "btn_continuar_punto_encuentro"]);
        $x[] = place("quien_recibe");
        $x[] = div(append_data($l), ["class" => "contenedor_estaciones"],1);

        return div(append_data($r), ["class" => 'resumen_encuentro']) . append_data($x);
    }

}