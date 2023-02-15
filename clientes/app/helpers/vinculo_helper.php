<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

      

                
        $response[] = d(foto_link($data), 10, 1);
        $response[] = d(add_imgs_cliente_empresa($data), 10, 1);
        return d($response, " bg_black shadow  text-center");
    }

    function add_imgs_cliente_empresa($data)
    {

        $imagenes_clientes = $data["imagenes_clientes"];
        $response = [];
        foreach ($imagenes_clientes as $row) {

            $link = get_path($row["nombre_imagen"]);
            $response[] = d(img($link),  'col-sm-3 col-xs-6');
        }

        $texto_imagenes  = d(_text("#",count($imagenes_clientes)),'white');
        $contenido[] = d(d($texto_imagenes, 13), 12);
        $contenido[] = d(d($response, 13), 12);
        return append($contenido);
    }

    function foto_link($data)
    {
        $response = [];
        $es_administrador = es_administrador($data);
        if ($data["in_session"] > 0 && $es_administrador) {

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
