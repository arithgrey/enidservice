<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_slider_preferencias')) {
        function get_format_slider_preferencias()
        {


            $r[] = ul([
                li(get_format_temporadas(), "single-slide slide-2 active"),
                li(get_format_images_preferencias(), "single-slide slide-3"),
                li(get_format_images(), "single-slide slide-4"),

            ],
                "slides"
            );

            $r[] = get_btw(

                div(img(["src" => "../img_tema/preferencias/up-arrow.png"]), "slide-nav-up")
                ,
                div(img(["src" => "../img_tema/preferencias/up-arrow.png"]), "slide-nav-down")
                ,
                "slider-nav"
            );


            $response = div(append_data($r), ["id" => "slider"]);
            return div($response, 8, 1);


        }

    }
    if (!function_exists('get_productos_deseados')) {
        function get_productos_deseados($productos_deseados)
        {
            return div(get_format_productos_deseados($productos_deseados), "top_20");

        }

    }

    if (!function_exists('get_format_temporadas')) {
        function get_format_temporadas()
        {
            $response = append_data([
                div("Apparel", "slide-label"),

                div(
                    img(
                        [
                            "src" => "../img_tema/preferencias/preferencias-1.jpg",
                            "class" => "from-left"
                        ]
                    ), "slide-image animate"
                ),

                div(
                    get_format_temporada()
                    ,
                    "slide-content"
                )

            ]);
            return $response;

        }

    }
    if (!function_exists('get_format_images_preferencias')) {
        function get_format_images_preferencias()
        {

            $response = append_data([
                div("Bags", "slide-label"),
                div(
                    img(
                        [

                            "src" => "../img_tema/preferencias/preferencias-2.jpg",
                            "class" => "from-left"
                        ]
                    )
                    ,
                    "slide-image animate"
                ),

                div(
                    get_format_slide_accesorios()
                    ,
                    "slide-content"
                )

            ]);
            return $response;

        }

    }
    if (!function_exists('get_format_images')) {
        function get_format_images()
        {

            $r[] = div("Diferentes estilos", "slide-label");
            $r[] = div(
                img(
                    [
                        "src" => "../img_tema/preferencias/preferencias-4.jpg",
                        "class" => "from-left",
                        "alt" => "image-3"
                    ]
                ),
                "slide-image animate"
            );


            $r[] = div(append_data([
                div(
                    heading_enid("Encuentra entre múltiples opciones", 3, ["class" => "from-bottom"])
                    ,
                    "animate"
                ),

                p("Para Dama y Caballero"),

                heading_enid(
                    "Mira las opciones", 3,
                    [
                        "class" => "shop-now",
                        "href" => "../search"],
                    1)

            ]),
                "slide-content");

            return append_data($r);

        }

    }
    if (!function_exists('get_list_clasificaciones')) {

        function get_list_clasificaciones($is_mobile, $preferencias, $tmp)
        {

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
                $r[] = get_format_clasificaciones($row);
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
            return append_data($r);

        }
    }
    if (!function_exists('get_format_sin_productos')) {

        function get_format_sin_productos()
        {


            $r[] = div(get_msj_busqueda_error(), 1);
            $r[] = heading_enid("UPS AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA", 3);
            $r[] = guardar("Explorar ahora!",
                [

                    "class" => "top_20"

                ],1,1,0, path_enid("home")
            );
            return div(append_data($r), 4, 1);


        }
    }
    if (!function_exists('get_format_productos_deseados')) {
        function get_format_productos_deseados($productos_deseados)
        {


            $r[] = div(get_menu(), 2);
            $r[] = div(get_lista_deseo($productos_deseados), 7);
            $r[] = get_btw(
                heading_enid("TU LISTA DE DESEOS", 3, 'titulo_lista_deseos')
                ,
                anchor_enid("EXPLORAR MÁS ARTÍCULOS", ["href" => "../search/?q2=0&q="], 1)
                ,
                3
            );

            return append_data($r);

        }

    }
    if (!function_exists('get_format_slide_accesorios')) {
        function get_format_slide_accesorios()
        {

            $r[] = div(div("Accesorios", "product-type from-bottom"), "animate");
            $r[] = div(heading_enid("Lo que usas en viajes", 2, "from-bottom"), "animate");
            $r[] = heading_enid("Explorar tienda", 3, ["class" => "shop-now", "href" => path_enid("search") ]);
            return append_data($r);

        }
    }
    if (!function_exists('get_format_temporada')) {
        function get_format_temporada()
        {

            $r[] = div(div("Nueva temporada", "product-type from-bottom"), "animate");
            $r[] = div(heading_enid("ENCUENTRA", 2, "from-bottom"), "animate");
            $r[] = div(heading_enid(
                "ROPA PARA CADA OCACIÓN", 2,
                ["class" => "from-bottom"]),
                ["class" => "animate"]);

            $r[] = heading_enid("EXPLORAR TIENDA", 2, "from-bottom");
            return append_data($r);

        }
    }
    if (!function_exists('get_format_preferencias')) {
        function get_format_preferencias()
        {

            $text = append_data([
                heading_enid("TUS PREFERENCIAS E INTERESES"),
                p("CUÉNTANOS TUS INTERESES PARA  MEJORAR TU EXPERIENCIA")
            ]);

            return div($text, 4);

        }

    }
    if (!function_exists('get_format_clasificaciones')) {

        function get_format_clasificaciones($row)
        {

            $extra = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ? "selected_clasificacion" : "";
            $preferencia_ = "preferencia_".$row['id_clasificacion'];

            $config = [
                'class' => 'list-preferencias item_preferencias ' . $preferencia_ . ' ' . $extra . ' ',
                'id' => $row['id_clasificacion']
            ];

            $extraIcon = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ? icon("fa fa-check-circle-o ") : "";
            $clasificacion = div(append_data([$extraIcon, $row["nombre_clasificacion"]]), $config);
            return div($clasificacion, 1);


        }
    }

    if (!function_exists('get_menu')) {

        function get_menu()
        {
            $preferencias = anchor_enid(
                "TUS PREFERENCIAS E INTERESES",
                [
                    "id" => "mis_ventas",
                    "href" => "?q=preferencias",
                    "class" => 'btn_mis_ventas'
                ]);

            $articulos_deseados
                = anchor_enid(
                "TU LISTA DE ARTÍCULOS DESEADOS",
                [
                    "id" => "mis_compras",
                    "href" => "../lista_deseos",
                    "class" => 'btn_cobranza mis_compras'
                ]);

            $list = [$preferencias, $articulos_deseados];
            return ul($list);
        }

    }
    if (!function_exists('get_lista_deseo')) {
        function get_lista_deseo($productos_deseados)
        {

            $response = [];
            foreach ($productos_deseados as $row) {


                $id = $row["id"];
                $id_producto = $row["id_servicio"];
                $src_img = $row["url_img_servicio"];
                $nombre_servicio = $row["nombre_servicio"];
                $descripcion = $row["descripcion"];
                $deseado = $row["deseado"];
                $valoracion = $row["valoracion"];
                $precio = $row["precio"];
                $articulos = $row["articulos"];


                $descripcion = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($descripcion));
                $descripcion = htmlentities($descripcion, ENT_QUOTES, "UTF-8");
                $descripcion = substr($descripcion, 40);
                $flag_envio_gratis = $row["flag_envio_gratis"];
                $text_envio = ($flag_envio_gratis > 0) ? "Envio gratis!" : "Más 100mxn de envio";


                $r = [];
                $r[] = div(img($src_img), "col-sm-3 border");
                $x = [];


                $url_servicio = get_url_servicio($id_producto);
                $title = anchor_enid($nombre_servicio, ["href" => $url_servicio, "target" => "_blank", "class" => "black"]);
                $x[] = heading_enid($title, 4);
                $x[] = str_repeat(icon("fa fa-star"), 5);

                $x[] = div($deseado . " veces comprado", "label-rating");


                $opiniones = anchor_enid($valoracion . " reseñas", ["href" => $url_servicio . "#opiniones"]);
                $x[] = div($opiniones, "label-rating");


                $text_productos = ($articulos > 1) ? $articulos . " productos " : " un producto";
                $opiniones = div(" Cancelar " . $text_productos,
                    [
                        "class" => "cursor_pointer hover_black",
                        "onclick" => "cancela_productos('{$id}');"
                    ]);
                $x[] = div($opiniones, "label-rating");

                $x[] = br(3);
                $x[] = p($descripcion);
                $r[] = div(append_data($x), 6);


                $z = [];

                $text_precio = $precio * $articulos;
                $z[] = heading_enid($text_precio . "MXN");
                $z[] = div($text_envio, "text-success text-center" );
                $z[] = br();
                $z[] = get_form_pre_pedido($id, $id_producto, "", 5, 0, 1, $articulos);
                $z[] = br();

                $z[] = guardar("Detalles", [], 1, 1, 0, get_url_servicio($id_producto));
                $r[] = div(append_data($z), 3);

                $response[] = addNRow(append_data($r), ["class" => "card "], ["class" => "border top_20"]);

            }
            return append_data($response);
        }
    }

    function get_form_pre_pedido($id, $id_servicio, $extension_dominio = "", $ciclo_facturacion, $is_servicio, $q2, $num_ciclos)
    {

        $url = "../producto/?producto=" . $id_servicio . "&pre=1";
        $r[] = '<form action="' . $url . '" method="POST" >';

        $r[] = input_hidden(["class" => "plan", "name" => "plan", "value" => $id_servicio]);
        $r[] = input_hidden(["class" => "extension_dominio", "name" => "extension_dominio", "value" => $extension_dominio]);
        $r[] = input_hidden(["class" => "ciclo_facturacion", "name" => "ciclo_facturacion", "value" => $ciclo_facturacion]);
        $r[] = input_hidden(["class" => "is_servicio", "name" => "is_servicio", "value" => $is_servicio]);
        $r[] = input_hidden(["class" => "q2", "name" => "q2", "value" => $q2]);
        $r[] = input_hidden(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["class" => "carro_compras", "name" => "carro_compras", "value" => 1]);
        $r[] = input_hidden(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id]);
        $r[] = guardar("Comprar ", [], 1, 1, 0, get_url_servicio($id_servicio));
        $r[] = form_close();

        return append_data($r);

    }


    if (!function_exists('get_msj_busqueda_error')) {
        function get_msj_busqueda_error()
        {

            return img(
                [
                    "src" => "https://media.giphy.com/media/VTXzh4qtahZS/giphy.gif",
                    "class" => "top_30",
                    "style" => "max-height: 260px;"

                ]
            );

        }
    }

}