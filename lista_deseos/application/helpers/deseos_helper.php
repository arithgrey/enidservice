<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_deseos($data)
    {

        $r[] = hrz(menu(), list_clasificaciones($data), 2);
        $r[] = hr();
        $r[] = slider_preferencias();
        $r[] = hr();
        return append($r);

    }

    function slider_preferencias()
    {

        $r[] = ul(
            [
                li(format_temporadas(), "single-slide slide-2 active"),
                li(format_images_preferencias(), "single-slide slide-3"),
                li(format_images(), "single-slide slide-4"),

            ],
            "slides"
        );

        $r[] = btw(

            d(img(
                [
                    "src" => "../img_tema/preferencias/up-arrow.png"
                ]
            ), "slide-nav-up")
            ,
            d(img(
                [
                    "src" => "../img_tema/preferencias/up-arrow.png"
                ]
            ), "slide-nav-down")
            ,
            "slider-nav"
        );

        $response = d(append($r), ["id" => "slider"]);
        return d($response, 8, 1);

    }


    function productos_deseados($productos, $externo = 0)
    {

        return d(format_productos_deseados($productos, $externo), "mt-5");

    }

    function format_temporadas()
    {
        return _text(
            d("Apparel", "slide-label"),

            d(
                img(
                    [
                        "src" => "../img_tema/preferencias/preferencias-1.jpg",
                        "class" => "from-left"
                    ]
                ), "slide-image animate"
            ),

            d(
                temporada()
                ,
                "slide-content"
            )
        );

    }

    function format_images_preferencias()
    {

        return _text(
            d("Bags", "slide-label"),
            d(
                img(
                    [

                        "src" => "../img_tema/preferencias/preferencias-2.jpg",
                        "class" => "from-left"
                    ]
                )
                ,
                "slide-image animate"
            ),
            d(
                format_slide_accesorios()
                ,
                "slide-content"
            )
        );

    }

    function format_images()
    {

        $r[] = d("Diferentes estilos", "slide-label");
        $r[] = d(
            img(
                [
                    "src" => "../img_tema/preferencias/preferencias-4.jpg",
                    "class" => "from-left",
                    "alt" => "image-3"
                ]
            ),
            "slide-image animate"
        );


        $str = _text(
            d(
                h("Encuentra entre múltiples opciones", 3, "from-bottom")
                ,
                "animate"
            )
            ,
            p("Para Dama y Caballero")
            ,
            h(
                "Mira las opciones", 3,
                [
                    "class" => "shop-now",
                    "href" => "../search"
                ],
                1
            )
        );

        $r[] = d($str, "slide-content");

        return append($r);

    }


    function list_clasificaciones($data)
    {
        $is_mobile = $data["is_mobile"];
        $preferencias = $data["preferencias"];
        $tmp = $data["tmp"];

        $r = [];
        if ($is_mobile == 1) {
            $r[] = $tmp;
        }
        $r[] = '<div class="col-lg-8">';

        $t = 0;
        $z = 0;
        foreach ($preferencias as $row):

            if ($z == 0):

                $r[] = '<div class="col-lg-4">';

            endif;
            $r[] = format_clasificaciones($row);
            $z++;
            if ($z == 9):
                $r[] = '</div>';
                $z = 0;
            endif;
            $t++;
            if ($r == 26):
                $r[] = '</div>';
            endif;
        endforeach;

        $r[] = '</div>';

        if ($is_mobile == 1) {
            $r[] = $tmp;
        }
        return append($r);

    }

    function sin_productos()
    {


        $r[] = busqueda_error();
        $r[] = h("UPS! AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA", 3);
//
        $r[] = a_enid(btn("Explorar ahora!",
            [

                "class" => "mt-5"

            ]
        ), path_enid("home"));
        return d($r, 'col-sm-4 col-sm-offset-4 mt-5  mt-md-3 text-center');


    }

    function format_productos_deseados($productos_deseados, $externo)
    {


        $r[] = d(menu(), 2);
        $r[] = d(lista_deseo($productos_deseados, $externo), 7);
        $r[] = btw(
            _titulo("TU LISTA DE DESEOS")
            ,
            a_enid("EXPLORAR MÁS ARTÍCULOS", path_enid('search'))
            ,
            3
        );

        return append($r);

    }


    function format_slide_accesorios()
    {

        $r[] = d(d("Accesorios", "product-type from-bottom"), "animate");
        $r[] = d(h("Lo que usas en viajes", 2, "from-bottom"), "animate");
        $r[] = h("Explorar tienda", 3, ["class" => "shop-now", "href" => path_enid("search")]);
        return append($r);

    }


    function temporada()
    {

        $r[] = d(d("Nueva temporada", "product-type from-bottom"), "animate");
        $r[] = d(h("ENCUENTRA", 2, "from-bottom"), "animate");
        $r[] = d(h("ROPA PARA CADA OCACIÓN", 2, "from-bottom"), "animate");
        $r[] = h("EXPLORAR TIENDA", 2, "from-bottom");
        return append($r);

    }

    function format_preferencias()
    {

        $text = _text(
            h("TUS PREFERENCIAS E INTERESES"),
            p("CUÉNTANOS TUS INTERESES PARA  MEJORAR TU EXPERIENCIA")
        );

        return d($text, 4);

    }


    function format_clasificaciones($row)
    {

        $extra = (
            array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ?
            "selected_clasificacion" : "";
        $preferencia_ = _text("preferencia_", $row['id_clasificacion']);

        $class = _text(
            'list-preferencias item_preferencias ',
            $preferencia_,
            ' ',
            $extra,
            ' '
        );
        $config = [
            'class' => $class,
            'id' => $row['id_clasificacion']
        ];

        $extraIcon = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ? icon("fa fa-check-circle-o ") : "";
        $clasificacion = d(append([$extraIcon, $row["nombre_clasificacion"]]), $config);
        return d($clasificacion, 1);


    }


    function menu()
    {
        $preferencias = a_enid(
            "TUS PREFERENCIAS E INTERESES",
            [
                "id" => "mis_ventas",
                "href" => "?q=preferencias",
                "class" => 'btn_mis_ventas'
            ]
        );

        $deseos
            = a_enid(
            "TU LISTA DE ARTÍCULOS DESEADOS",
            [
                "id" => "mis_compras",
                "href" => "../lista_deseos",
                "class" => 'btn_cobranza mis_compras'
            ]
        );

        return ul([$preferencias, $deseos]);
    }


    function lista_deseo($productos_deseados, $externo)
    {

        $response = [];
        foreach ($productos_deseados as $row) {


            $id = ($externo > 0) ? $row["id_usuario_deseo_compra"] : $row["id"];
            $descripcion = $row["descripcion"];
            $id_producto = $row["id_servicio"];

            $precio = $row["precio"];
            $articulos = $row["articulos"];
            $descripcion = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($descripcion));
            $descripcion = htmlentities($descripcion, ENT_QUOTES, "UTF-8");
            $descripcion = substr($descripcion, 40);
            $text_envio = ($row["flag_envio_gratis"] > 0) ? "Envio gratis!" : "Más 100mxn de envio";


            $r = [];
            $r[] = d(img($row["url_img_servicio"]), "col-sm-3 border");
            $x = [];


            $url_servicio = get_url_servicio($id_producto);
            $nombre_servicio = $row["nombre_servicio"];
            $x[] = h(a_enid($nombre_servicio,
                [
                    "href" => $url_servicio,
                    "target" => "_blank",
                    "class" => "black"
                ]
            ), 4);
            $x[] = str_repeat(icon("fa fa-star"), 5);
            $x[] = d($row["deseado"] . " veces comprado", "label-rating");

            $str_reseñas = _text(
                $row["valoracion"],
                " reseñas"
            );
            $path_servicio = _text($url_servicio, "#opiniones");
            $opiniones = a_enid($str_reseñas, $path_servicio);
            $x[] = d($opiniones, "label-rating");


            $text_productos = ($articulos > 1) ? $articulos . " productos " : " un producto";
            $text_cancelar = _text(" Cancelar ", $text_productos);

            $tipo = ($externo < 1) ? "cancela_productos('{$id}');" : "cancela_productos_deseados('{$id}');";
            $opiniones = d(
                $text_cancelar,
                [
                    "class" => "cursor_pointer hover_black",
                    "onclick" => $tipo
                ]
            );
            $x[] = d($opiniones, "label-rating");
            $x[] = p($descripcion);
            $r[] = d($x, 6);
            $z = [];
            $text_precio = $precio * $articulos;
            $z[] = h(money($text_precio));
            $z[] = d($text_envio, "text-success text-center");
            $z[] = frm_pre_pedido($id, $id_producto, "", 5, 0, 1, $articulos);

            $r[] = d($z, 3);
            $response[] = d($r,'col-md-12 mb-5');
            $response[] = d('','col-md-12 mt-5 mb-5 border-bottom');


        }
        return d($response,'row');
    }

    function frm_pre_pedido($id, $id_servicio, $extension_dominio = "", $ciclo_facturacion, $is_servicio, $q2, $num_ciclos)
    {

        $url = path_enid('producto', _text($id_servicio, "&pre=1"));
        $r[] = '<form action="' . $url . '" method="POST" >';
        $r[] = hiddens(["class" => "id_servicio", "name" => "id_servicio", "value" => $id_servicio]);
        $r[] = hiddens(["class" => "extension_dominio", "name" => "extension_dominio", "value" => $extension_dominio]);
        $r[] = hiddens(["class" => "ciclo_facturacion", "name" => "ciclo_facturacion", "value" => $ciclo_facturacion]);
        $r[] = hiddens(["class" => "is_servicio", "name" => "is_servicio", "value" => $is_servicio]);
        $r[] = hiddens(["class" => "q2", "name" => "q2", "value" => $q2]);
        $r[] = hiddens(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = hiddens(["class" => "carro_compras", "name" => "carro_compras", "value" => 1]);
        $r[] = hiddens(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id]);
        $r[] = btn("Comprar ", [], 1, 1, 0, get_url_servicio($id_servicio));
        $r[] = form_close();

        return append($r);

    }


    function busqueda_error()
    {

        return img(
            [
                "src" => "https://media.giphy.com/media/VTXzh4qtahZS/giphy.gif",
                "class" => "",

            ]
        );

    }
}
