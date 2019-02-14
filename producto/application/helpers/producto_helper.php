<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('invierte_date_time')) {
        function valida_maximo_compra($flag_servicio, $existencia)
        {

            if ($flag_servicio == 1) {
                return 100;
            } else {
                return $existencia;
            }
        }
        if (!function_exists('get_url_imagen_post')) {
            function get_url_imagen_post($id_servicio)
            {
                return "http://enidservice.com/inicio/imgs/index.php/enid/imagen_servicio/" . $id_servicio . "/";
            }
        }
        if (!function_exists('costruye_meta_keyword')) {
            function costruye_meta_keyword($servicio)
            {

                $metakeyword = $servicio["metakeyword"];
                $metakeyword_usuario = $servicio["metakeyword_usuario"];
                $nombre_servicio = $servicio["nombre_servicio"];
                $descripcion = $servicio["descripcion"];


                $array = explode(",", $metakeyword);
                array_push($array, $nombre_servicio);
                array_push($array, $descripcion);
                array_push($array, " precio ");
                if (strlen(trim($metakeyword_usuario)) > 0) {
                    array_push($array, $metakeyword_usuario);
                }
                $meta_keyword = implode(",", $array);
                return strip_tags($meta_keyword);
            }
        }
        if (!function_exists('select_cantidad_compra')) {
            function select_cantidad_compra($flag_servicio, $existencia)
            {

                $config = [
                    "name" => "num_ciclos",
                    "class" => "telefono_info_contacto form-control"
                ];

                $select = "<select " . add_attributes($config) . ">";
                for ($a = 1; $a < valida_maximo_compra($flag_servicio, $existencia); $a++) {

                    $select .= "<option value=" . $a . ">" . $a . "</option>";
                }
                $select .= "</select>";
                return $select;
            }
        }
        if (!function_exists('get_text_periodo_compra')) {
            function get_text_periodo_compra($flag_servicio)
            {
                if ($flag_servicio == 0) {
                    return "Piezas";
                }
            }
        }
        /*
        if (!function_exists('get_text_periodo_compra')) {
            function get_text_periodo_compra($flag_servicio, $existencia)
            {
                $response = ($flag_servicio == 1) ? 100 : $existencia;
                return $response;
            }
        }
        */
        if (!function_exists('get_text_costo_envio')) {
            function get_text_costo_envio($flag_servicio, $param)
            {

                if ($flag_servicio == 0) {
                    return $param["text_envio"]["cliente"];
                }
            }
        }
        if (!function_exists('get_descripcion_servicio')) {
            function get_descripcion_servicio($descripcion, $flag_servicio)
            {

                $servicio = ($flag_servicio == 1) ? "SOBRE EL SERVICIO" : "SOBRE EL PRODUCTO";
                if (strlen(trim(strip_tags($descripcion))) > 10) {
                    $text = heading_enid($servicio, 2, ["class" => 'titulo_sobre_el_producto strong']);
                    $text .= div(p(strip_tags($descripcion)));
                    return $text;
                }
            }

        }
        if (!function_exists('get_contacto_cliente')) {
            function get_contacto_cliente($proceso_compra, $tel_visible, $in_session, $usuario)
            {

                $inf = "";
                if ($tel_visible == 1 && $proceso_compra == 0) {
                    $usr = $usuario[0];
                    $ftel = 1;
                    $ftel2 = 1;
                    $tel = (strlen($usr["tel_contacto"]) > 4) ? $usr["tel_contacto"] : $ftel = 0;
                    $tel2 = (strlen($usr["tel_contacto_alterno"]) > 4) ? $usr["tel_contacto_alterno"] : $ftel2 = 0;
                    if ($ftel == 1) {

                        $lada = (strlen($usr["tel_lada"]) > 0) ? "(" . $usr["tel_lada"] . ")" : "";
                        $contacto = $lada . $tel;
                        $inf .= div(icon("fa fa-phone") . $contacto);
                    }
                    if ($ftel2 == 1) {
                        $lada = (strlen($usr["lada_negocio"]) > 0) ? "(" . $usr["lada_negocio"] . ")" : "";
                        $inf .= div(icon('fa fa-phone') . $lada . $tel2);
                    }
                    return div($inf, 1);
                }
            }
        }
        if (!function_exists('get_entrega_en_casa')) {

            function get_entrega_en_casa($entregas_en_casa, $flag_servicio)
            {

                $text = "";
                if ($entregas_en_casa == 1) {
                    $text = ($flag_servicio == 1) ? "EL VENDEDOR TAMBIÉN BRINDA ATENCIÓN EN SU NEGOCIO" : "TAMBIÉN PUEDES ADQUIRIR TUS COMPRAS EN EL NEGOCIO DEL VENDEDOR";
                }
                return $text;
            }

        }
        if (!function_exists('crea_nombre_publicador_info')) {
            function crea_nombre_publicador_info($usuario, $id_usuario)
            {

                $nombre = $usuario[0]["nombre"];
                $tienda = '../search/?q3=' . $id_usuario . '&vendedor=' . $nombre;
                $a = anchor_enid(
                    "POR " . strtoupper($nombre),
                    [
                        "href" => $tienda,
                        'class' => 'informacion_vendedor_descripcion'
                    ]);

                return "VENDEDOR " . $a;

            }
        }
        if (!function_exists('get_tipo_articulo')) {
            function get_tipo_articulo($flag_nuevo, $flag_servicio)
            {

                $usado = div(li('- ARTÍCULO USADO'), 1);
                $text = ($flag_servicio == 0 && $flag_nuevo == 0) ? $usado : "";
                return $text;
            }
        }
        if (!function_exists('valida_informacion_precio_mayoreo')) {
            function valida_informacion_precio_mayoreo($flag_servicio, $venta_mayoreo)
            {

                return ($flag_servicio == 0 && $venta_mayoreo == 1) ? "VENTAS MAYORISTAS " . icon('fa fa-check-circle') : "";

            }
        }
        if (!function_exists('creta_tabla_colores')) {

            function creta_tabla_colores($text_color, $flag_servicio)
            {

                $final = "";
                if ($flag_servicio == 0) {
                    $arreglo_colores = explode(",", $text_color);
                    $num_colores = count($arreglo_colores);
                    $info_title = "";

                    if ($num_colores > 0) {
                        $info_title = ($num_colores > 1) ? "COLORES DISPONIBLES" : "COLOR DISPONIBLE";
                    }
                    $info = "";
                    $v = 0;
                    for ($z = 0; $z < count($arreglo_colores); $z++) {
                        $color = $arreglo_colores[$z];
                        $style = "background:$color;height:40px; ";
                        $info .= div("", ["style" => $style, "class" => "col-lg-4"]);
                        $v++;
                    }
                    if ($v > 0) {

                        $final = "";
                        $final .= div($info_title, ["class" => 'informacion_colores_disponibles']);
                        $final .= $info;
                        $final = div($final, ['class' => 'contenedor_informacion_colores']);

                    }
                    return div($final, 1);
                }

            }

        }
        if (!function_exists('get_text_diponibilidad_articulo')) {
            function get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml = '')
            {
                if ($flag_servicio == 0 && $existencia > 0) {
                    $text = "APRESÚRATE! SOLO HAY " . $existencia . " EN EXISTENCIA ";
                    $text = div($text, ['class' => 'text-en-existencia']);
                    if (strlen($url_ml) > 10) {
                        $text .= "<?=br()?>" . anchor_enid("Adquiéralo en Mercado libre", ["href" => $url_ml, "class" => "black"]);
                    }
                    return $text;
                }
            }
        }
        if (!function_exists('valida_editar_servicio')) {
            function valida_editar_servicio($usuario_servicio, $id_usuario, $in_session, $id_servicio)
            {

                $editar = "";
                if ($in_session == 1) {
                    $href = "../planes_servicios/?action=editar&servicio=" . $id_servicio;
                    $editar_button = div(anchor_enid(icon('fa fa-pencil') . "EDITAR", ["href" => $href]), ["class" => 'a_enid_black_sm editar_button']);
                    $editar = ($id_usuario == $usuario_servicio) ? $editar_button : "";
                }
                return $editar;
            }
        }
        if (!function_exists('valida_text_servicio')) {
            function valida_text_servicio($flag_servicio, $precio_unidad, $id_ciclo_facturacion)
            {

                $text = "1 Pza " . $precio_unidad . "MXN";
                if ($flag_servicio == 1) {

                    $text = ($id_ciclo_facturacion != 9 && $precio_unidad > 0) ? $precio_unidad . "MXN" : "A CONVENIR";

                } else {

                    $text = ($precio_unidad > 0) ? $precio_unidad . "MXN" : "A CONVENIR";
                }
                return $text;
            }

        }
        if (!function_exists('construye_seccion_imagen_lateral')) {
            function construye_seccion_imagen_lateral($param, $nombre_servicio, $url_youtube)
            {

                $preview = "";
                $z = 0;
                $imgs_grandes = "";

                foreach ($param as $row) {

                    $id_imagen      = $row["id_imagen"];
                    $url            = "../imgs/index.php/enid/imagen/" . $id_imagen;
                    $extra_class    = "";
                    $extra_class_contenido = '';

                    if ($z == 0) {
                        $extra_class = ' active ';
                        $extra_class_contenido = ' in active ';
                    }

                    $producto_tab = "#imagen_tab_" . $z;
                    $producto_tab_s = "imagen_tab_" . $z;


                    $id_error = "imagen_" . $z;
                    $img_pro = [
                        'src' => $url,
                        'alt' => $nombre_servicio,
                        'id' => $id_error,
                        'class' => 'imagen-producto',
                        'onerror' => "reloload_img( '" . $id_error . "','" . $url . "');"
                    ];

                    $preview .= anchor_enid(img($img_pro),
                        [
                            'id' => $z,
                            'data-toggle' => 'tab',
                            'class' => ' preview_enid ' . $extra_class,
                            'href' => $producto_tab
                        ]


                    );

                    $id_error = "imagen_" . $id_imagen;
                    $image_properties = [
                        'src' => $url,
                        'id' => $id_error,
                        "class" => "imagen_producto_completa",
                        'onerror' => "reloload_img( '" . $id_error . "','" . $url . "');"
                    ];
                    $imgs_grandes .= div(img($image_properties),
                        [
                            "id" => $producto_tab_s,
                            "class" => "tab-pane fade zoom " . $extra_class_contenido . " "
                        ]);

                    $z++;

                }
                $response["preview"] = $preview;
                $response["num_imagenes"] = count($param);
                $response["imagenes_contenido"] = $imgs_grandes;
                return $response;
            }
        }
        if (!function_exists('valida_url_youtube')) {

            function valida_url_youtube($url_youtube, $is_mobile)
            {

                $url = "";
                if (strlen($url_youtube) > 5) {

                    $height = ($is_mobile == 0) ? "600px" : "400px";
                    $url = iframe([
                        "width" => '100%',
                        "height" => $height,
                        "src" => $url_youtube,
                        "frameborder" => '0',
                        "allow" => 'autoplay'

                    ]);
                }
                return $url;
            }
        }
        if (!function_exists('get_info_producto')) {
            function get_info_producto($q2)
            {

                $id_producto = 0;
                if (isset($q2) && $q2 != null) {
                    $id_producto = $q2;
                }
                return $id_producto;
            }
        }
        if (!function_exists('get_tienda_vendedor')) {
            function get_tienda_vendedor($proceso_compra, $id_vendedor)
            {

                if ($proceso_compra == 0) {
                    return anchor_enid(
                        "Ir a la tienda del vendedor",
                        [
                            'href' => "../search/?q3=" . $id_vendedor,
                            'class' => "a_enid_black"
                        ]
                        ,
                        1,
                        1
                    );
                }
            }

        }
        if (!function_exists('get_solicitud_informacion')) {
            function get_solicitud_informacion($proceso_compra, $id_servicio)
            {

                //if ($proceso_compra == 0) {
                    return anchor_enid(
                        div("SOLICITAR INFORMACIÓN", ['class' => 'black_enid_background white padding_1'], 1),
                        [
                            "href" => "../pregunta?tag=" . $id_servicio
                        ]).br();
                //}
            }
        }
        if (!function_exists('agregar_lista_deseos')) {

            function agregar_lista_deseos($proceso_compra, $in_session)
            {

                if ($proceso_compra == 0) {

                    $btn = anchor_enid(div("AGREGAR A TU LISTA DE DESEOS " . icon("fa fa-gift fa-x2"),
                        ["class" => "a_enid_black"], 1),
                        [
                            'class' => 'agregar_a_lista',
                            'href' => "../login/"
                        ]
                    );

                    if ($in_session == 1) {
                        $btn = div(div(
                            "AGREGAR A TU LISTA DE DESEOS" . icon('fa fa-gift'),
                            ["class" => "a_enid_black agregar_a_lista_deseos"]
                            , 1
                        ),
                            ["id" => 'agregar_a_lista_deseos_add']
                        );

                    }
                    return $btn;

                }
            }
        }
        if (!function_exists('get_tiempo_entrega')) {
            function get_tiempo_entrega($proceso_compra, $tiempo_entrega)
            {

                return ($proceso_compra == 0) ? div($tiempo_entrega, 1) : "";
            }
        }
        if (!function_exists('get_nombre_vendedor')) {
            function get_nombre_vendedor($proceso_compra, $usuario, $id_vendedor)
            {

                return ($proceso_compra == 0) ? div(crea_nombre_publicador_info($usuario, $id_vendedor), 1) . place("separador") : "";

            }
        }


    }