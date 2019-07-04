<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {



    function create_estaciones_configurador($array, $lista_negra)
    {

        $l = [];
        $negra = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];


            $index =  search_bi_array($lista_negra, "id_punto_encuentro", $id);

            if ($index != false){

                $l[] = ajustar(div($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro",
                        "id" => $id,
                        "nombre_estacion" => $nombre

                    ]
                ), icon("fa agregar_punto  fas fa-plus-square ", ["id" => $id ] ));

            }else{

                $l[] = ajustar(div($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro",
                        "id" => $id,
                        "nombre_estacion" => $nombre
                    ]
                ), icon("fa quitar_punto  fa fa-minus ", ["id" => $id ] ));



            }


        }

        return div(append($l));
    }

    function create_estaciones($array, $flag_envio_gratis, $lista_negra)
    {

        $l = [];
        $negra = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];


            $index =  search_bi_array($lista_negra, "id_punto_encuentro", $id);

            if ($index != false){

                $negra[] = div($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro",
                        "id" => $id,
                        "nombre_estacion" => $nombre,
                        "costo_envio" => $row["costo_envio"],
                        "flag_envio_gratis" => $flag_envio_gratis

                    ]
                );

            }else{

                $l[] = div($nombre,
                    [
                        "class" => "nombre_estacion cursor_pointer punto_encuentro",
                        "id" => $id,
                        "nombre_estacion" => $nombre,
                        "costo_envio" => $row["costo_envio"],
                        "flag_envio_gratis" => $flag_envio_gratis

                    ]
                );

            }


        }


        $r[] = place("nombre_linea_metro");
        $r[] = place("nombre_estacion_punto_encuentro");
        $r[] = place("cargos_por_entrega");
        $r[] = place("mensaje_cobro_envio");
        $r[] = guardar("CONTINUAR", ["class" => "btn_continuar_punto_encuentro"]);
        $x[] = place("quien_recibe");


        $x[] = div(
            div(
                input([
                    "class" => "search",
                    "name" => "q"
                ]),
                4
                ,
                1
            ), 13);


        $x[] = div(append($l), "contenedor_estaciones ", 1);

        return div(append($r), 'resumen_encuentro') . div(append($x), 'resumen_mensaje_pago');
    }

}