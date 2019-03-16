<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_notificacion_subscrito($nombre)
    {

        $r[] = heading("Buen día" . $nombre);
        $r[] = div("Te notificamos que desde este momento puedes consultar más productos y servicios a través de ");
        $r[] = anchor_enid("Enid Service",
            [
                "class" => "btn btn-primary btn-lg",
                "href" => "http://enidservice.com/",
                "target" => "_blank",
                "style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
            ]);

        $r[] = hr();
        $r[] = hr();
        $r[] = div("Desde ahora podrás comprar y vender tus productos o servicios ");
        $r[] = anchor_enid("Accede a tu cuenta aquí!",
            [
                "class" => "btn btn-primary btn-lg",
                "href" => "http://enidservice.com/inicio/login/",
                "target" => "_blank",
                "style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
            ]);

        return append_data($r);
    }
}