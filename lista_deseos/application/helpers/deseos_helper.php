<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_deseos')) {
        function render_deseos($data)
        {

            $r[] = d(get_menu(), 2);
            $r[] = d(list_clasificaciones($data), 10);
            $r[] = hr();
            $r[] = format_slider_preferencias();
            $r[] = hr();
            return append($r);

        }

    }

    if (!function_exists('format_slider_preferencias')) {
        function format_slider_preferencias()
        {


            $r[] = ul([
                li(format_temporadas(), "single-slide slide-2 active"),
                li(format_images_preferencias(), "single-slide slide-3"),
                li(format_images(), "single-slide slide-4"),

            ],
                "slides"
            );

            $r[] = btw(

                d(img(["src" => "../img_tema/preferencias/up-arrow.png"]), "slide-nav-up")
                ,
                d(img(["src" => "../img_tema/preferencias/up-arrow.png"]), "slide-nav-down")
                ,
                "slider-nav"
            );


            $response = d(append($r), ["id" => "slider"]);
            return d($response, 8, 1);


        }

    }
    if (!function_exists('productos_deseados')) {
        function productos_deseados($productos)
        {

            return d(format_productos_deseados($productos), "top_20");

        }

    }

    if (!function_exists('format_temporadas')) {
        function format_temporadas()
        {
            $response = append([
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
                    format_temporada()
                    ,
                    "slide-content"
                )

            ]);
            return $response;

        }

    }
    if (!function_exists('format_images_preferencias')) {
        function format_images_preferencias()
        {

            $response = append([
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

            ]);
            return $response;

        }

    }
    if (!function_exists('format_images')) {
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


            $r[] = d(append([
                d(
                    h("Encuentra entre múltiples opciones", 3,  "from-bottom")
                    ,
                    "animate"
                ),

                p("Para Dama y Caballero"),

                h(
                    "Mira las opciones", 3,
                    [
                        "class" => "shop-now",
                        "href" => "../search"],
                    1)

            ]),
                "slide-content");

            return append($r);

        }

    }
    if (!function_exists('list_clasificaciones')) {

        function list_clasificaciones($data)
        {
            $is_mobile =  $data["is_mobile"];
            $preferencias =  $data["preferencias"];
            $tmp =  $data["tmp"];

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
    }
    if (!function_exists('sin_productos')) {

        function sin_productos()
        {


            $r[] = d(get_msj_busqueda_error(), 1);
            $r[] = h("UPS AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA", 3);
            $r[] = btn("Explorar ahora!",
                [

                    "class" => "top_20"

                ], 1, 1, 0, path_enid("home")
            );
            return d(append($r), 4, 1);


        }
    }
    if (!function_exists('format_productos_deseados')) {
        function format_productos_deseados($productos_deseados)
        {


            $r[] = d(get_menu(), 2);
            $r[] = d(lista_deseo($productos_deseados), 7);
            $r[] = btw(
                h("TU LISTA DE DESEOS", 3, 'titulo_lista_deseos')
                ,
                a_enid("EXPLORAR MÁS ARTÍCULOS", ["href" => "../search/?q2=0&q="], 1)
                ,
                3
            );

            return append($r);

        }

    }
    if (!function_exists('format_slide_accesorios')) {
        function format_slide_accesorios()
        {

            $r[] = d(d("Accesorios", "product-type from-bottom"), "animate");
            $r[] = d(h("Lo que usas en viajes", 2, "from-bottom"), "animate");
            $r[] = h("Explorar tienda", 3, ["class" => "shop-now", "href" => path_enid("search")]);
            return append($r);

        }
    }
    if (!function_exists('format_temporada')) {
        function format_temporada()
        {

            $r[] = d(d("Nueva temporada", "product-type from-bottom"), "animate");
            $r[] = d(h("ENCUENTRA", 2, "from-bottom"), "animate");
            $r[] = d(h("ROPA PARA CADA OCACIÓN", 2, "from-bottom"), "animate");
            $r[] = h("EXPLORAR TIENDA", 2, "from-bottom");
            return append($r);

        }
    }
    if (!function_exists('format_preferencias')) {
        function format_preferencias()
        {

            $text = append([
                h("TUS PREFERENCIAS E INTERESES"),
                p("CUÉNTANOS TUS INTERESES PARA  MEJORAR TU EXPERIENCIA")
            ]);

            return d($text, 4);

        }

    }
    if (!function_exists('format_clasificaciones')) {

        function format_clasificaciones($row)
        {

            $extra = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ? "selected_clasificacion" : "";
            $preferencia_ = "preferencia_" . $row['id_clasificacion'];

            $config = [
                'class' => 'list-preferencias item_preferencias ' . $preferencia_ . ' ' . $extra . ' ',
                'id' => $row['id_clasificacion']
            ];

            $extraIcon = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ? icon("fa fa-check-circle-o ") : "";
            $clasificacion = d(append([$extraIcon, $row["nombre_clasificacion"]]), $config);
            return d($clasificacion, 1);


        }
    }

    if (!function_exists('get_menu')) {

        function get_menu()
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

    }
    if (!function_exists('lista_deseo')) {
        function lista_deseo($productos_deseados)
        {

            $response = [];
            foreach ($productos_deseados as $row) {


                $id = $row["id"];
                $id_producto = $row["id_servicio"];
                $descripcion = $row["descripcion"];
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
                $x[] = h(a_enid($row["nombre_servicio"], ["href" => $url_servicio, "target" => "_blank", "class" => "black"]), 4);
                $x[] = str_repeat(icon("fa fa-star"), 5);
                $x[] = d($row["deseado"] . " veces comprado", "label-rating");

                $opiniones = a_enid($row["valoracion"] . " reseñas",$url_servicio . "#opiniones"   );
                $x[] = d($opiniones, "label-rating");


                $text_productos = ($articulos > 1) ? $articulos . " productos " : " un producto";
                $opiniones = d(" Cancelar " . $text_productos,
                    [
                        "class" => "cursor_pointer hover_black",
                        "onclick" => "cancela_productos('{$id}');"
                    ]
                );
                $x[] = d($opiniones, "label-rating");
                $x[] = br(3);
                $x[] = p($descripcion);
                $r[] = d(append($x), 6);
                $z = [];
                $text_precio = $precio * $articulos;
                $z[] = h($text_precio . "MXN");
                $z[] = d($text_envio, "text-success text-center");
                $z[] = br();
                $z[] = frm_pre_pedido($id, $id_producto, "", 5, 0, 1, $articulos);
                $z[] = br();
                $z[] = btn("Detalles", [], 1, 1, 0, get_url_servicio($id_producto));
                $r[] = d(append($z), 3);
                $response[] = addNRow(append($r), ["class" => "card "], ["class" => "border top_20"]);

            }
            return append($response);
        }
    }

    function frm_pre_pedido($id, $id_servicio, $extension_dominio = "", $ciclo_facturacion, $is_servicio, $q2, $num_ciclos)
    {

        $url = "../producto/?producto=" . $id_servicio . "&pre=1";
        $r[] = '<form action="' . $url . '" method="POST" >';

        $r[] = input_hidden(["class" => "id_servicio", "name" => "id_servicio", "value" => $id_servicio]);
        $r[] = input_hidden(["class" => "extension_dominio", "name" => "extension_dominio", "value" => $extension_dominio]);
        $r[] = input_hidden(["class" => "ciclo_facturacion", "name" => "ciclo_facturacion", "value" => $ciclo_facturacion]);
        $r[] = input_hidden(["class" => "is_servicio", "name" => "is_servicio", "value" => $is_servicio]);
        $r[] = input_hidden(["class" => "q2", "name" => "q2", "value" => $q2]);
        $r[] = input_hidden(["class" => "num_ciclos", "name" => "num_ciclos", "value" => $num_ciclos]);
        $r[] = input_hidden(["class" => "carro_compras", "name" => "carro_compras", "value" => 1]);
        $r[] = input_hidden(["class" => "id_carro_compras", "name" => "id_carro_compras", "value" => $id]);
        $r[] = btn("Comprar ", [], 1, 1, 0, get_url_servicio($id_servicio));
        $r[] = form_close();

        return append($r);

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