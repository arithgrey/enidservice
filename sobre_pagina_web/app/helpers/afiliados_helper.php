<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {
    function botones_ver_mas()
    {

        $link_whatsApp =  format_link("Explicamé tu proyecto", [
            "href" => path_enid("whatsapp_catalogo_pagina_web", 0, 1),
            "class" => "border mt-5",
            "onclick" => "log_operaciones_externas(47)",
            "target" => "_blank"
        ]);



        $mensaje_messenger = format_link(
            "Explicamé tu proyecto",
            [
                "href" => path_enid('facebook_descuento', 0, 1),
                "class" => "white facebook_trigger p-2 borde_amarillo bg_black p-1  mt-3",
                "onclick" => "log_operaciones_externas(47)",
                "target" => "_black"
            ]
        );


        $link_whatsApp = (is_mobile()) ? $link_whatsApp : $mensaje_messenger;

        $response[] = d($link_whatsApp, 12);


        return append($response);
    }
}
