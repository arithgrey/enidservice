<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render($data)
    {

        $response[] = d(seccion_izquierda($data), 'col-md-4 d-none d-md-block');
        $response[] = d(seccion_noticias_notificaciones(), 'col-md-8 d-md-block');
        $id_usuario = $data["id_usuario"];
        $response[] = hiddens(
            [
                "name" => "id_usuario",
                "class" => "id_usuario",
                "value" => $id_usuario
            ]
        );
        return d($response, 10, 1);

    }

    function seccion_noticias_notificaciones()
    {

        $response[] = place('seccion_sugerencias');
        $response[] = d(d("", "seccion_noticias"), 13);

        return append($response);

    }

    function seccion_izquierda($data)
    {

        $clase = 'col-md-8 mt-5 col-md-offset-2';
        $r[] = seccion_estadisticas($data);
        $response[] = d(d($r), $clase);
        $response[] = d(posiciones(), $clase);
        $response[] = d(conexiones(), $clase);
        $response[] = d(nuba_seller_club(), $clase);
        $response[] = d(enid_service_web(), $clase);

        return append($response);

    }

    function seccion_estadisticas($data)
    {

        $r[] = d(_titulo("estadísticas", 4), "mt-5");
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


        $link_ventas = a_texto('Mis ventas',
            [
                'class' => 'text-center ',
                'href' => path_enid('pedidos')
            ]
        );
        $text_ventas = text_icon(_bomb_icon, $link_ventas);
        $texto_top = 'Identifica tus ordenes de compras enviadas';
        $texto_ventas = flex(
            $text_ventas, $texto_top, 'flex-column', "", "fp8 mt-3 text-secondary");

        $link_top_ventas = a_texto('Top ventas',
            [
                'class' => 'text-center black',
                'href' => path_enid('top_competencias', 2)
            ]
        );

        $icono_top = text_icon(_estrellas_icon, $link_top_ventas);
        $texto_top = 'Mira qué posición ocupas en la tabla';
        $texto_top_ventas = flex(
            $icono_top, $texto_top, 'flex-column', "", "fp8 mt-3 text-secondary");

        $r[] = d(
            d_c(
                [
                    $seccion_meta,
                    $ventas_actuales,
                    $restantes,
                    $texto_ventas,
                    $texto_top_ventas
                ],
                'f11 col-lg-12 mx-auto mt-5'), 'row black');
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
        $path = path_enid("nuba_seller",0,1);
        $response[] = d(a_enid($imagen, ["href" => $path, "target" => "_black"]));
        $response[] = a_enid('Nuba seller club', ["href" => $path, "target" => "_black", "class" => "black"]);

        return append($response);
    }
    function enid_service_web()
    {

        $imagen = img(path_enid("pagina_enid_service_facebook"));
        $path = path_enid("enid_service_facebook",0,1);
        $response[] = d(a_enid($imagen, ["href" => $path, "target" => "_black"]));

        $response[] = a_enid('Enid service', ["href" => $path, "target" => "_black", "class" => "black"]);

        return append($response);
    }

}

