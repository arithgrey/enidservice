<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function producto_deseado($productos_deseados, $img)
    {

        $response = [];

        foreach ($productos_deseados as $row) {

            $id_producto = $row["id_servicio"];
            $precio = $row["precio"];
            $precio_alto = ($row["precio_alto"] > $precio ) ?  $row["precio_alto"] : ($precio + porcentaje($precio,16));
            $articulos = 1;

            $r = [];
            $url_servicio = get_url_servicio($id_producto);
            $config = ["href" => $url_servicio];

            $nombre_imagen = pr($img, "nombre_imagen");

            $imagen = a_enid(img(get_url_servicio($nombre_imagen, 1)), $config);
            $text_precio = $precio * $articulos;
            $text_precio_alto = $precio_alto * $articulos;


            $seccion_imagen_seleccion_envio =
                flex("", $imagen, _between_start);
            $r[] = d($seccion_imagen_seleccion_envio, "col-xs-5 col-sm-3 p-0");
            $x = [];

            $nombre_servicio = $row["nombre_servicio"];
            $link = a_enid(
                $nombre_servicio,
                [
                    "href" => $url_servicio,
                    "class" => "black"
                ]
            );
            $x[] = h($link, 4, ["class" => "mb-5"]);


            $r[] = d($x, 'col-xs-5');
            $z = [];
            $z[] = h(money($text_precio - 150), 2, 'strong');


            $z[] = h(del(money($text_precio)), 5, ' red_enid');

            if ($precio_alto > $precio) {
                $z[] = h(del(money($text_precio_alto)), 5, ' red_enid');
            }


            $r[] = d($z, 'col-sm-4 text-right d-md-block ');

            $response[] = d($r, 'col-md-12 mb-2');
        }


        return d($response, 13);
    }
    function render_producto_codigo($data)
    {

        $pagina[] =  d(d(
            "Logra tus objetivos ya!",
            "text-center color_grey display-6 mt-5"
        ), 12);
        $pagina[] =  d(d(
            "Aquí tienes un descuento de $150 pesos",
            "text-center display-5 black mt-2 text-uppercase strong"
        ), 12);

        $pagina[] = d(d("", ["id" => "contador", "class" => "bg_black white text-center borde_amarillo p-3 display-6 strongs"]), 'col-xs-12 mt-3     ');


        $id_servicio = $data["id_servicio"];


        $response_agendar[] = format_link(
            d(
                "Tomar la oferta! ",

                'pt-2 pb-2'
            ),
            [
                'class' => 'en_lista_deseos white cursor_pointer',
                "onclick" => "agregar_deseos_sin_antecedente_gbl_btn($id_servicio)"
            ]
        );


        $pagina[] = d(select_cantidad_compra(0, 2, 1), 'd-none');
        $mirar_opciones = format_link(
            "ver más kits!",
            [
                "href" => path_enid("kist-mas-vendidos"),
                "class" => "cursor_pointer"
            ],
            0
        );

        $pagina[] = d(producto_deseado($data["producto"], $data["img"]), 'col-xs-12 mt-5 mb-5');
        $pagina[] = d(flex(append($response_agendar), $mirar_opciones, _text_(_between, 'selectores ')), 'col-xs-12 mb-2 cursor_pointerst');
        $pagina[] = d(d(span("Solo quedan 3 piezas disponibles",'p-1 border_red_b strong')),'col-xs-12 mb-5 mt-2');
        $pagina[] = d(cargando(), 'text-center col-xs-12 mb-3');

        $pagina[] = d(
            "Pagas al recibir tus artículos en tu domicilio",
            'mt-3 col-xs-12  strong f12 mb-4'
        );

        return d(d($pagina, 13), 'col-lg-4 col-lg-offset-4 borde_black mt-5');
    }
}
