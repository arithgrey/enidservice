<?php

use BaconQrCode\Renderer\Path\Path;

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render($data)
    {

        $response[] = d(seccion_izquierda($data), 'col-md-3 d-none d-md-block');
        $response[] = d(seccion_noticias_notificaciones(), 'col-md-6 d-md-block border-right');
        $response[] = d(seccion_derecha($data), 'col-md-3 d-none d-md-block');

        $id_usuario = $data["id_usuario"];
        $response[] = hiddens(
            [
                "name" => "id_usuario",
                "class" => "id_usuario",
                "value" => $id_usuario
            ]
        );
        return d($response, 12);
    }

    function seccion_noticias_notificaciones()
    {


        $texto = "Aumenta tus ganancias ofreciendo descuentos";
        $link_descuento = a_enid(
            $texto,
            [
                "href" => path_enid("promociones"),
                "class" => "black underline"
            ]
        );
        $class = (is_mobile()) ? 'row mt-3' : "text-right";
        $response[] = d($link_descuento, $class);
        $response[] = extras_fake();
        $response[] = place('seccion_sugerencias');
        //$response[] = place('seccion_nuevos_ingresos');
        $response[] = d(d("", "seccion_noticias"), 13);

        return append($response);
    }

    function seccion_izquierda($data)
    {

        $clase = 'col-md-12 mt-5';
        $r[] = seccion_estadisticas($data);
        $response[] = d(d($r), $clase);
        $response[] = d(posiciones(), $clase);
        $response[] = d(conexiones(), $clase);
        $response[] = d(nuba_seller_club(), $clase);
        $response[] = d(enid_service_web(), $clase);

        return append($response);
    }
    function seccion_derecha($data)
    {

        $response[] =  penetracion_alcaldias($data);
        $response[] =  extras_clientes();
        return append($response);
    }    
    function extras_clientes()
    {


        $link  = a_enid(
            "Conoce nuestros últimos clientes",
            [
                "href" => path_enid("clientes"),
                "class" => "black fp9 underline",
                "target" => "black"
            ]
        );
        $response[] = d($link, 'mt-5 col-sm-12');

        return append($response);
    }
    function extras_fake()
    {
        $r = [];
        if (is_mobile()) {
            $r[] = d(hr(), 'col-xs-12 p-0');

            $r[] = d(_titulo("¿Tienes duda sobre si un cliente es fake o te ha faltado al respeto?", 5));
            $r[] = d(a_enid('Verificalo o mandalo a lista negra aquí', ['href' => "http://app.enidservices.com/lista-negra", 'target' => '_blanck']));

            $r[] = d(hr(), 'col-xs-12 p-0');

            $link_descuento = a_enid(
                "Mira qué zonas tienen más ventas",
                [
                    "href" => path_enid("indicadores_ubicaciones", 0, 1),
                    "class" => "black underline"
                ]
            );

            $r[] = d($link_descuento, 'mb-3');
        }

        return  d($r, 13);
    }
    function seccion_estadisticas($data)
    {

        $comision_venta = $data["saldo_por_cobrar"];
        $classe_center = 'd-flex p-3 bg_custom_green_ 
        white flex-column  text-uppercase border_black';


        $texto = flex("Saldo por cobrar", money($comision_venta), $classe_center, '', 'display-4');

        $r[] = d(_titulo("¿Tienes duda sobre si un cliente es fake o te ha faltado al respeto?", 5));
        $r[] = d(a_enid('Verificalo o mandalo a lista negra aquí', ['href' => "http://app.enidservices.com/lista-negra", 'target' => '_blanck']));

        $r[] = hr();

        $link_whatsApp_facebook = a_enid(
            "¿Por donde iniciar?",
            [
                "href" => _text(path_enid("sobre_vender"), "#iniciar"),
                "class" => "black underline mb-3"
            ]
        );

        $r[] = d($link_whatsApp_facebook);

        $link_whatsApp_facebook = a_enid(
            "Agiliza tus ventas con WhatsApp y Facebook",
            [
                "href" => path_enid("vender_en_facebook"),
                "class" => "black underline mb-3"
            ]
        );

        $r[] = d($link_whatsApp_facebook);
        $link_descuento = a_enid(
            "Mira qué zonas tienen más ventas",
            [
                "href" => 'http://app.enidservices.com/indicadores-ubicaciones',
                "class" => "black underline mb-3"
            ]
        );

        $r[] = d($link_descuento);

        $link_costo_entrega = a_enid(
            "Calcula el costo de entrega para tus clientes",
            [
                "href" => path_enid("costo_entrega"),
                "class" => "black underline mb-3"
            ]
        );

        $r[] = d($link_costo_entrega);
        $r[] = d($texto, 'mt-5');

        $link_fondos = a_enid(
            "Solicitar saldo",
            [
                "href" => path_enid("solicitud_saldo"),
                "class" => "black underline"
            ]
        );

        $r[] = d($link_fondos, "text-right");

        $link = a_enid(
            "Ver pedidos",
            [
                "href" => path_enid("pedidos"),
                "class" => "black underline"
            ]
        );



        $r[] = d($link, "text-right");

        if (es_administrador($data)) {

            $link_entregas = a_enid(
                "Próximas entregas",
                [
                    "href" => path_enid("entregas"),
                    "class" => "black underline"
                ]
            );
            $r[] = d($link_entregas, "text-right");

            $link_entregas = a_enid(
                "Métricas",
                [
                    "href" => path_enid("reporte_enid"),
                    "class" => "black underline"
                ]
            );
            $r[] = d($link_entregas, "text-right");
        }



        $r[] = d(_titulo("estadísticas", 4));
        $r[] = d(p("Actividades en los últimos 30 días", "text-secondary"));

        $meta_semanal_comisionista = $data['meta_semanal_comisionista'];
        $total_ventas_semana = (es_data($data['ventas_semana'])) ? count($data['ventas_semana']) : 0;

        $restantes = ($meta_semanal_comisionista - $total_ventas_semana);

        $icono_meta = text_icon(_dolar_icon, 'Meta semanal');
        $seccion_meta = flex($icono_meta, $meta_semanal_comisionista, _between);

        $icono_logros = text_icon(_checked_icon, 'Logros fecha');
        $ventas_actuales = flex($icono_logros, $total_ventas_semana, _between);

        $icono_restantes = text_icon(_spinner, "restantes");
        $restantes = flex($icono_restantes, $restantes, 'strong black');


        $link_ventas = a_texto(
            'Mis ventas',
            [
                'class' => 'text-center ',
                'href' => path_enid('pedidos')
            ]
        );
        $text_ventas = text_icon(_bomb_icon, $link_ventas);
        $texto_top = 'Identifica tus ordenes de compras enviadas';
        $texto_ventas = flex(
            $text_ventas,
            $texto_top,
            'flex-column',
            "",
            "fp8 mt-3 text-secondary"
        );

        $link_top_ventas = a_texto(
            'Top ventas',
            [
                'class' => 'text-center black',
                'href' => path_enid('top_competencias', 2)
            ]
        );

        $icono_top = text_icon(_estrellas_icon, $link_top_ventas);
        $texto_top = 'Mira qué posición ocupas en la tabla';
        $texto_top_ventas = flex(
            $icono_top,
            $texto_top,
            'flex-column',
            "",
            "fp8 mt-3 text-secondary"
        );

        $r[] = d(
            d_c(
                [
                    $seccion_meta,
                    $ventas_actuales,
                    $restantes,
                    $texto_ventas,
                    $texto_top_ventas
                ],
                'f11 col-lg-12 mx-auto mt-5'
            ),
            'row black'
        );
        return append($r);
    }

    function posiciones()
    {
        $response[] = d(_titulo("Ranking", 4), "mt-5");
        $texto = flex(icon(_flecha_derecha), "Mira qué posición ocupas en la tabla", "", "mr-3");
        $path = path_enid("conexiones");
        $response[] = d(a_enid($texto, ["class" => "black", "href" => $path]), 'f12 black');
        return append($response);
    }

    function conexiones()
    {
        $response[] = d(_titulo("conexiones", 4), "mt-5");
        $texto = flex(icon(_flecha_derecha), "Todos tus contactos", "", "mr-3");
        $path = path_enid("seguidores");
        $response[] = d(a_enid($texto, ["class" => "black", "href" => $path]), 'f12 black');
        $response[] = d("Seguidores y cuentas que sigues", 'text-secondary');
        return append($response);
    }

    function nuba_seller_club()
    {

        $imagen = img(path_enid("nuba_seller_club"));
        $path = path_enid("nuba_seller", 0, 1);
        $response[] = d(a_enid($imagen, ["href" => $path, "target" => "_black"]));
        $response[] = a_enid('Nuba seller club', ["href" => $path, "target" => "_black", "class" => "black"]);

        return append($response);
    }
    function enid_service_web()
    {

        $imagen = img(path_enid("pagina_enid_service_facebook"));
        $path = path_enid("enid_service_facebook", 0, 1);
        $response[] = d(a_enid($imagen, ["href" => $path, "target" => "_black"]));
        $response[] = a_enid('Enid service', ["href" => $path, "target" => "_black", "class" => "black"]);

        return append($response);
    }
}
