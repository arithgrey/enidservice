<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function create_estaciones_configurador($array, $lista_negra)
    {

        $l = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];

            if (search_bi_array($lista_negra, "id_punto_encuentro", $id) !== false) {

                $l[] = ajustar(d($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro",
                        "id" => $id,
                        "nombre_estacion" => $nombre

                    ]
                ), icon("fa agregar_punto  fas fa-plus-square ", ["id" => $id]));

            } else {

                $l[] = ajustar(d($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro",
                        "id" => $id,
                        "nombre_estacion" => $nombre
                    ]
                ), icon("fa quitar_punto  fa fa-minus ", ["id" => $id]));


            }


        }

        return d(append($l));
    }

    function create_estaciones($array, $es_envio_gratis, $lista_negra)
    {

        $l = [];
        $negra = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];
            $index = search_bi_array($lista_negra, "id_punto_encuentro", $id);

            if ($index !== false) {

                $negra[] = d($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro   mx-auto mt-2 w-50",
                        "id" => $id,
                        "nombre_estacion" => $nombre,
                        "costo_envio" => $row["costo_envio"],
                        "flag_envio_gratis" => $es_envio_gratis

                    ]
                );

            } else {

                $l[] = d($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro  mx-auto mt-2 w-50 ",
                        "id" => $id,
                        "nombre_estacion" => $nombre,
                        "costo_envio" => $row["costo_envio"],
                        "flag_envio_gratis" => $es_envio_gratis

                    ]
                );

            }


        }


        //$r[] = place("nombre_linea_metro");
        //$r[] = place("nombre_estacion_punto_encuentro");
        //$r[] = place("cargos_por_entrega");
        //$r[] = place("mensaje_cobro_envio");
        $r[] = btn("CONTINUAR", ["class" => "btn_continuar_punto_encuentro"]);
        //$x[] = place("quien_recibe");




        $x[] = append($l);
        //$response[] = d(append($r), 'resumen_encuentro');
        //$response[] = d(append($x), 'resumen_mensaje_pago');
        //return append($response);
        return append($x);

    }

}