<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render($data)
    {

        $z[] = "<form action='../search' class='mt-5'>";
        $input = input(
            [
                "class" => "input-field mh_50 border border-dark solid_bottom_hover_3 ",
                "placeholder" => "¿Qué artículo agendarás?",
                "name" => "q"
            ]
        );
        $z[] = d(
            _text_(
                icon('fa fa-search icon'),
                $input
            )
            , "input-icons w-100");
        $z[] = form_close();
        $ext = (is_mobile() < 1) ? "" : "top_200";
        $r[] = d($z, _text("mt-5 ", $ext));
        $r[] = d(_titulo("estadísticas", 4), "mt-5");
        $r[] = d(p("Actividades en los últimos 30 días", "text-secondary"));


        $meta_semanal_comisionista = $data['meta_semanal_comisionista'];
        $total_ventas_semana = (es_data($data['ventas_semana'])) ? count($data['ventas_semana']) : 0;

        $restantes = ($meta_semanal_comisionista - $total_ventas_semana);

        $icono_meta = text_icon(_dolar_icon, 'Meta semanal');
        $seccion_meta = flex($icono_meta, $meta_semanal_comisionista, 'flex-column');

        $icono_logros = text_icon(_checked_icon, 'Logros fecha');
        $ventas_actuales = flex($icono_logros, $total_ventas_semana, 'flex-column');

        $icono_restantes = text_icon(_spinner, "restantes");
        $restantes = flex($icono_restantes, $restantes, 'flex-column strong black');


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
                'href' => path_enid('top_competencia')
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
                'f11 col-lg-2 mx-auto text-center mt-5'), 'row black');


        $response[] = d(d($r), 'col-md-10 mt-5 col-md-offset-1');
        $response[] = d(posiciones(), 'col-md-10 mt-5 col-md-offset-1');
        $response[] = d(place('seccion_sugerencias'), 'col-md-10 mt-5 col-md-offset-1');
        $response[] = d(conexiones(), 'col-md-10 mt-5 col-md-offset-1');
        $response[] = d(d("", "seccion_noticias"), 'col-md-10 mt-5 col-md-offset-1');

        return append($response);

    }
    function posiciones()
    {
        $response[] = d(_titulo("Ranking", 4), "mt-5");
        $texto = flex(icon(_flecha_derecha), "Mira qué posición ocupas en la tabla", "", "mr-3");
        $path =  path_enid("conexiones");
        $response[] = d(a_enid($texto, ["class" => "black", "href" => $path]), 'f12 black');
        return append($response);

    }
    function conexiones()
    {
        $response[] = d(_titulo("conexiones", 4), "mt-5");
        $texto = flex(icon(_flecha_derecha), "Todos tus contactos", "", "mr-3");
        $path =  path_enid("seguidores");
        $response[] = d(a_enid($texto, ["class" => "black", "href" => $path]), 'f12 black');
        $response[] = d("Seguidores y cuentas que sigues", 'text-secondary');
        return append($response);

    }
}

