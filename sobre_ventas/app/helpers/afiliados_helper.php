<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {
    function botones_ver_mas()
    {

        $link_registro =  format_link("Registra tu cuenta", [
            "href" => path_enid("registro_afiliado",0,1),
            "class" => "border mt-5"            
        ]);

        $link_whatsApp =  format_link("Solicita el catálogo por whatsApp", [
            "href" => path_enid("whatsapp_catalogo",0,1),
            "class" => "mt-3",
            "onclick" => "log_operaciones_externas(46)",
            "target" => "_blank"
        ],2);

       
        $response[] = d($link_registro, 12);
        $response[] = d($link_whatsApp, 12);
        

        return append($response);
    }
}
