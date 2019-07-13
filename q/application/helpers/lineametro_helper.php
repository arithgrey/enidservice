<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function create_listado_linea_metro_configurador($data, $lista_negra)
    {
        $r = [];
        $negra = [];
        foreach ($data as $row) {


            $id = $row["id"];
            $index = search_bi_array($lista_negra, "id_linea_metro", $id);
            if ($index !== false ) {


                $img =
                    img(
                        [
                            "src" => $row["icon"],
                            "id" => $id,
                            "class" => "cursor_pointer linea_metro puntos_encuentro",
                            "nombre_linea" => $row["nombre"]
                        ]
                    );

                $negra[] = d(ajustar($img, icon("agregar_linea fa fa-plus-square fa-2x" ,["id" => $id])), 3);

            } else {

                $img =
                    img(
                        [
                            "src" => $row["icon"],
                            "id" => $id,
                            "class" => "cursor_pointer linea_metro puntos_encuentro",
                            "nombre_linea" => $row["nombre"]
                        ]
                    );

                $r[] = d(ajustar($img, icon("quitar_linea  fa fa-minus fa-2x", ["id" => $id])), 3);


            }


        }


        $response[] = h("LINEAS DE METRO DISPONIBLES",3);
        $response[] = append($r);
        $response[] = br(7);
        $response[] = hr();
        $response[] = h("LINEAS DE METRO EN PAUSA",3);
        $response[] = append($negra);
        return append($response);
    }

    function create_listado_linea_metro($data, $lista_negra)
    {
        $r = [];
        $negra = [];
        foreach ($data as $row) {


            $id = $row["id"];
            $index = search_bi_array($lista_negra, "id_linea_metro", $id);
            if ($index !== false) {


                $img =
                    img(
                        [
                            "src" => $row["icon"],
                            "id" => $id,
                            "class" => "cursor_pointer linea_metro",
                            "nombre_linea" => $row["nombre"]
                        ]
                    );

                $negra[] = d($img, 3);

            } else {

                $img =
                    img(
                        [
                            "src" => $row["icon"],
                            "id" => $id,
                            "class" => "cursor_pointer linea_metro",
                            "nombre_linea" => $row["nombre"]
                        ]
                    );

                $r[] = d($img, 3);


            }


        }
        return append($r);
    }

    function create_listado_metrobus($array)
    {
        $r = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];
            $numero = $row["numero"];


            $linea = d("LINEA " . $numero,
                [
                    "id" => $id,
                    "class" => "cursor_pointer linea_metro nombre_linea_metrobus top_20",
                    "nombre_linea" => $nombre
                ]
            );

            $r[] = d($linea, 3);
        }

        return append($r);
    }


}