<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {
    function botones_ver_mas()
    {

        $link_productos =  format_link("Explora nuestros artículos", [
            "href" => path_enid("search", _text("/?q2=0&q=&order=", rand(0, 8), '&page=', rand(0, 5))),
            "class" => "border mt-5",
            "onclick" => "log_operaciones_externas(36)"
        ]);

        $link_clientes =  format_link("Conoce nuestros clientes", [
            "href" => path_enid("clientes"),
            "class" => "border mt-4",
            "onclick" => "log_operaciones_externas(37)"
        ]);


        $link_facebook =  format_link("Facebook", [
            "href" => path_enid("facebook", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_',
            "onclick" => "log_operaciones_externas(35)"
        ], 0);

        $link_instagram =  format_link("Instagram", [
            "href" => path_enid("fotos_clientes_instagram", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_',
            "onclick" => "log_operaciones_externas(34)"
        ], 0);


        $response[] = d(hr(), 12);
        $response[] = d($link_productos, 4, 1);
        $response[] = d($link_clientes, 4, 1);
        $response[] = d($link_facebook, 4, 1);
        $response[] = d($link_instagram, 4, 1);

        return append($response);
    }
}
