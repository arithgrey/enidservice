<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $link_facebook = format_link(
            "Facebook",
            [
                "href" => path_enid("fotos_clientes_facebook", 0, 1),
                "target" => "_black",
                "class" => "click_facebook_clientes"
            ],
            0
        );

        $link_instagram = format_link(
            "Instagram",
            [
                "href" => path_enid("fotos_clientes_instagram", 0, 1),
                "target" => "_black",
                "class" => "click_instagram_clientes"
            ],
            0
        );


        $link_whatsApp = format_link(
            "Whatsapp",
            [
                "href" => path_enid('whatsapp', 0, 1),
                "class" => "whatsapp_trigger",
                "target" => "_black"
            ],
            0
        );


        $class = "justify-content-between align-items-center w-100 d-flex mb-3";
        $redes_sociales = d([$link_facebook, $link_instagram, $link_whatsApp], $class);
        $response[] = d($redes_sociales, 10, 1);
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
