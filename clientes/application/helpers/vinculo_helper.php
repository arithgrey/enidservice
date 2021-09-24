<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $response[] = foto_link($data);
        $response[] = add_imgs_cliente_empresa($data);
        return d($response," bg_black shadow p-5 text-center");

    }

    function add_imgs_cliente_empresa($data)
    {

        $imagenes_clientes = $data["imagenes_clientes"];
        $response = [];
        foreach ($imagenes_clientes as $row) {

            $link = get_path($row["nombre_imagen"]);
            $response[] = img($link);

        }

        return append($response);
    }

    function foto_link($data)
    {
        $response = [];
        if ($data["in_session"] > 0) {

            $response[] = format_link("Agrega foto", ["class" => "anexar_foto_link"]);
            $response[] = d("", "formulario_fotos_clientes ");
        }

        return append($response);

    }

    function get_path($nombre_imagen)
    {

        return _text("../img_tema/clientes/", $nombre_imagen);

    }

}

