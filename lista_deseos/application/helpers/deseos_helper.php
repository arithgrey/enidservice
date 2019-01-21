<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('invierte_date_time')) {

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
                    $src_img = "../imgs/index.php/enid/imagen_servicio/" . $id_servicio;

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