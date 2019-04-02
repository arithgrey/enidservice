<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function create_listado_linea_metro($array)
    {
        $r = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];
            $icon = $row["icon"];

            $img = img([
                "src" => $icon,
                "id" => $id,
                "class" => "cursor_pointer linea_metro",
                "nombre_linea" => $nombre
            ]);
            $r[] = div($img, 3);
        }
        return append_data($r);
    }

    function create_listado_metrobus($array)
    {
        $r = [];
        foreach ($array as $row) {

            $nombre = $row["nombre"];
            $id = $row["id"];
            $numero = $row["numero"];


            $linea = div("LINEA " . $numero, [
                "id" => $id,
                "class" => "cursor_pointer linea_metro nombre_linea_metrobus top_20",
                "nombre_linea" => $nombre
            ]);

             $r[] = div($linea, 3);
        }
        return append_data($r);
    }


}