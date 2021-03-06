<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function create_listado_linea_metro_configurador($data, $lista_negra)
    {
        $r = [];
        $negra = [];
        $base  ='col-md-3 mt-4';
        foreach ($data as $row) {

            $id = $row["id"];
            $index = search_bi_array($lista_negra, "id_linea_metro", $id);
            $img = img(
                [
                    "src" => $row["icon"],
                    "id" => $id,
                    "class" => "cursor_pointer linea_metro puntos_encuentro",
                    "nombre_linea" => $row["nombre"],
                ]
            );

            $accion = ($index !== false) ?
                'agregar_linea fa fa-plus-square fa-2x '
                :
                'fa fa-minus fa-2x quitar_linea ';

            $icono = icon(_text($accion), ["id" => $id]);

            if ($index !== false) {

                $negra[] = d(ajustar($img, $icono), $base);

            } else {

                $r[] = d(ajustar($img, $icono), $base);
            }
        }

        $activas[] = d(_titulo("LINEAS DEL METRO DONDE HACES ENTREGAS",4),12);
        $activas[] = append($r);

        $pausa[] = d(_titulo("LINEAS DE METRO EN PAUSA", 4),'col-sm-12 mt-5');
        $pausa[] = append($negra);

        $response[] =  d($activas,13);
        $response[] =  d($pausa,13);

        return append($response);
    }

    function create_listado_linea_metro($data, $lista_negra, $param)
    {
        $r = [];
        foreach ($data as $row) {

            $id = $row["id"];
            $index = search_bi_array($lista_negra, "id_linea_metro", $id);
            $extra_clase_imagen = ($index !== false) ? '' : ' lm bb_hv filter_g';
            $img = img(
                [
                    "src" => $row["icon"],
                    "id" => $id,
                    "class" => "cursor_pointer linea_metro lm " . $extra_clase_imagen,
                    "nombre_linea" => $row["nombre"],
                ]
            );

            if ($index !== false) {

            } else {

                $ext = (prm_def($param, "is_mobile")) ? "w-100" : "w-50";

                $r[] = d(
                    $img,
                    _text(
                        " mx-auto mt-2 ", $ext
                    )
                );
            }
        }

        return append($r);
    }

    function create_listado_metrobus($array)
    {
        $r = [];
        foreach ($array as $row) {

            $linea = d(
                add_text("LINEA ", $row["numero"]),
                [
                    "id" => $row["id"],
                    "class" => "cursor_pointer linea_metro nombre_linea_metrobus top_20",
                    "nombre_linea" => $row["nombre"],
                ]
            );

            $r[] = d($linea, 3);
        }

        return append($r);
    }
}