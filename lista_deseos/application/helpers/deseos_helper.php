<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_temporadas')) {
        function get_format_temporadas()
        {
            $response = append_data([
                div("Apparel", ["class" => "slide-label"]),

                div(img([
                    "src" => "../img_tema/preferencias/preferencias-1.jpg",
                    "class" => "from-left"
                ]), ["class" => "slide-image animate"]),

                div(get_format_temporada(), ["class" => "slide-content"])

            ]);
            return $response;

        }

    }
    if (!function_exists('get_format_images_preferencias')) {
        function get_format_images_preferencias()
        {

            $response = append_data([
                div("Bags", ["class" => "slide-label"]),
                div(img([
                        "src" => "../img_tema/preferencias/preferencias-2.jpg",
                        "class" => "from-left"
                    ])
                    , ["class" => "slide-image animate"]),

                div(get_format_slide_accesorios(), ["class" => "slide-content"])

            ]);
            return $response;

        }

    }
    if (!function_exists('get_format_images')) {
        function get_format_images()
        {

            $r[] = div("Diferentes estilos", ["class" => "slide-label"]);
            $r[] = div(img(["src" => "../img_tema/preferencias/preferencias-4.jpg",
                "class" => "from-left",
                "alt" => "image-3"]), ["class" => "slide-image animate"]);


            $r[] = div(append_data([
                div(
                    heading_enid("Encuentra entre múltiples opciones", 3,

                        ["class" => "from-bottom"]),
                    ["class" => "animate"]),

                p("Para Dama y Caballero"),

                heading_enid(
                    "Mira las opciones", 3,
                    [
                        "class" => "shop-now",
                        "href" => "../search"],
                    1)

            ]),
                ["class" => "slide-content"]);

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

            $r[] = br();
            $r[] = get_msj_busqueda_error();
            $r[] = get_btw(
                heading_enid("UPS AÚN NO HAZ AGREGADO PRODUCTOS A TU LISTA", 2, ["class" => "strong"]),
                anchor_enid("Explorar ahora!",
                    [
                        "href" => "../",
                        "style" => "color: #040174;text-decoration: none;font-size: 1.5em;text-decoration: underline;"
                    ]),
                "col-lg-4 col-lg-offset-4"
            );

            return append_data($r);


        }
    }
    if (!function_exists('get_format_productos_deseados')) {
        function get_format_productos_deseados($productos_deseados)
        {

            $r[] = div(get_menu(), ["class" => "col-lg-2"]);
            $r[] = div(get_lista_deseo($productos_deseados), ["class" => "col-lg-7"]);
            $r[] = get_btw(
                heading_enid("TU LISTA DE DESEOS", 3, ["class" => 'titulo_lista_deseos']),
                anchor_enid("EXPLORAR MÁS ARTÍCULOS", ["href" => "../search/?q2=0&q="], 1),
                "col-lg-3"
            );

            return append_data($r);

        }

    }
    if (!function_exists('get_format_slide_accesorios')) {
        function get_format_slide_accesorios()
        {

            $r[] = div(div("Accesorios", ["class" => "product-type from-bottom"]), ["class" => "animate"]);
            $r[] = div(heading_enid("Lo que usas en viajes", 2, ["class" => "from-bottom"]), ["class" => "animate"]);
            $r[] = heading_enid("Explorar tienda", 3, ["class" => "shop-now", "href" => "../search"]);
            return append_data($r);

        }
    }
    if (!function_exists('get_format_temporada')) {
        function get_format_temporada()
        {

            $r[] = div(div("Nueva temporada", ["class" => "product-type from-bottom"]), ["class" => "animate"]);
            $r[] = div(heading_enid("ENCUENTRA", 2, ["class" => "from-bottom"]), ["class" => "animate"]);
            $r[] = div(heading_enid(
                "ROPA PARA CADA OCACIÓN", 2,
                ["class" => "from-bottom"]),
                ["class" => "animate"]);

            $r[] = heading_enid(
                "EXPLORAR TIENDA", 2,
                ["class" => "from-bottom"]);

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

            return div($text, ['class' => "col-lg-4"]);

        }

    }
    if (!function_exists('get_format_clasificaciones')) {

        function get_format_clasificaciones($row)
        {

            $extra = (array_key_exists("id_usuario", $row) && !is_null($row["id_usuario"])) ? "selected_clasificacion" : "";
            $preferencia_ = "preferencia_" . $row['id_clasificacion'];

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
                ["id" => "mis_ventas", "href" => "?q=preferencias", "class" => 'btn_mis_ventas']);

            $articulos_deseados
                = anchor_enid(
                "TU LISTA DE ARTÍCULOS DESEADOS",
                ["id" => "mis_compras", "href" => "../lista_deseos",
                    "class" => 'btn_cobranza mis_compras']);

            $list = [$preferencias, $articulos_deseados];
            return ul($list);
        }

    }
    if (!function_exists('get_lista_deseo')) {
        function get_lista_deseo($productos_deseados)
        {

            $l = "";
            foreach ($productos_deseados as $row) {

                $id_servicio = $row["id_servicio"];
                $url = "../producto/?producto=" . $id_servicio;
                $src_img = $row["url_img_servicio"];

                $id_error = "imagen_" . $id_servicio;
                $config = [

                    'src' => $src_img,
                    'id' => $id_error,
                    'style' => 'width:100%!important;height:250px!important;',
                    'onerror' => "reloload_img( '" . $id_error . "','" . $src_img . "');"
                ];

                $img = img($config);
                $img_link = anchor_enid($img, ["src" => $url]);
                $div = div($img_link, ['class' => 'col-lg-4']);
                $l .= $div;
            }
            return $l;
        }
    }
    if (!function_exists('get_msj_busqueda_error')) {
        function get_msj_busqueda_error()
        {

            return div(img(
                [
                    "src" => "https://media.giphy.com/media/VTXzh4qtahZS/giphy.gif",
                    "style" => "border-radius:100%;"
                ]),
                [
                    "class" => "col-lg-4 col-lg-offset-4",
                    "style" => "background:#011220;padding:20px;"

                ],
                1);

        }
    }

}