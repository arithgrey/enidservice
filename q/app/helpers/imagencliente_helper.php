<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function formato_referencias($ids_en_muestra, $imagenes_clientes, $id_servicio)
    {

        $response[] = d("Selecciona la imagen a mostrar", "strong col-sm-12 mb-3");
        $response[] = d(_text_(format_link(
            "ó Genera algunas aquí",
        [
            "class" => "selecciona_imagenes_aleatorias",
            "id" => $id_servicio
        ])),'col-sm-12 mb-5');
        foreach ($imagenes_clientes as $row) {

            $id_imagen = $row["id_imagen"];
            if (!in_array($id_imagen, $ids_en_muestra)) {
                $link = _text("../img_tema/clientes/", $row["nombre_imagen"]);
                $response[] = d(img($link),
                    [
                        "class" => "col-xs-6  imagen_referencia_muestra cursor_pointer",
                        "id_servicio" => $id_servicio,
                        "id" => $id_imagen
                    ]
                );

            }

        }
        return append($response);

    }
}
