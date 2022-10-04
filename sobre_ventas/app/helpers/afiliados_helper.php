<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {
    function botones_ver_mas()
    {

        $link_whatsApp =  format_link("Solicita el catálogo por whatsApp", [
            "href" => path_enid("whatsapp_catalogo",0,1),
            "class" => "border mt-5",
            "onclick" => "log_operaciones_externas(46)",
            "target" => "_blank"
        ]);

        $link_productos =  format_link("Explora nuestros artículos", 
        [
            "href" => path_enid("search", _text("/?q2=0&q=&order=", rand(0, 8), '&page=', rand(0, 5))),
            "class" => "border mt-4",
            "onclick" => "log_operaciones_externas(36)"
        ],0);

        $link_clientes =  format_link("Conoce nuestros clientes", [
            "href" => path_enid("clientes"),
            "class" => "border mt-4",
            "onclick" => "log_operaciones_externas(37)"
        ],0);



        $response[] = d($link_whatsApp, 12);
        $response[] = d($link_productos, 12);
        $response[] = d($link_clientes, 12);
        

        return append($response);
    }
}
