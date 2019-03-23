<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_notificacion_interes_compra($vendedor)
    {

        $nombre = strtoupper(trim(get_campo($vendedor, "nombre")));
        $apellido_paterno = strtoupper(trim(get_campo($vendedor, "apellido_paterno")));
        $apellido_materno = strtoupper(trim(get_campo($vendedor, "apellido_materno")));
        $nombre_vendedor = $nombre . " " . $apellido_paterno . " " . $apellido_materno;


        $r[] = heading_enid("Buen día" . $nombre_vendedor, 1, ["class" => "display-4"]);
        $r[] = div("Un cliente está interesado en uno de tus productos que tienes en venta en");
        $r[] = anchor_enid("Enid Service",
            [
                "class" => "btn btn-primary btn-lg",
                "href" => "http://enidservice.com/",
                "target" => "_blank",
                "style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
            ]);
        $r[] = hr(["class" => "my-4"]);
        $r[] = p("Apresúrate, estás a un paso de realizar una nueva venta!");
        $r[] = anchor_enid("Responde a tu cliente aquí!",
            [
                "class" => "btn btn-primary btn-lg",
                "href" => "http://enidservice.com/inicio/login/",
                "target" => "_blank",
                "style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
            ]
        );


        $response[] = div(append_data($r), ["class" => "jumbotron", "style" => "padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;"]);
        $respónse[] = div(img("http://enidservice.com/inicio/img_tema/enid_service_logo.jpg"), ["style" => "width: 30%;margin: 0 auto;"]);

        return append_data($response);

    }
    function get_notificacion_respuesta_cliente(){

    }
}