<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function format_simple($data)
    {


        $_response[] = h("SERVICIOS POSTULADOS", 3);

        foreach ($data["servicios"] as $row) {

            $id_servicio = $row["id_servicio"];
            $r = [];
            $r[] = img(
                [
                    "src" => "../imgs/index.php/enid/imagen_servicio/" . $id_servicio,
                    "style" => 'width: 44px!important;height: 44px;',
                ]
            );
            $r[] = d(add_text("alcance", $row["vista"]));


            $_response[] = a_enid(d(
                d(
                    d(
                        append($r), "popup-head-left pull-left"), "popup-head"),
                [
                    "class" => "popup-box chat-popup",
                    "id" => "qnimate",
                    "style" => "margin-top: 4px;"
                ]
            ), ["href" => "../producto/?producto=" . $id_servicio, "class" => 'contenedor_resumen_servicio']);

        }

        return append($_response);


    }

    function render_configurador($data)
    {
        $servicio = $data["servicio"];
        if (es_data($servicio)) {


            $num = $data["num"];
            $num_imagenes = $data["num_imagenes"];
            $s = $servicio[0];
            $id_servicio = $s["id_servicio"];
            $es_servicio = $s["flag_servicio"];

            $precio = $s["precio"];
            $url_productos_publico = "../producto/?producto=" . $id_servicio . "&q2=" . $data["id_usuario"];
            $costo_envio = $data["costo_envio"];

            $comision = 0;
            $utilidad = 0;
            if ($es_servicio < 1) {

                $p_comision = $data["porcentaje_comision"];
                $comision = porcentaje(floatval($precio), $p_comision);
                $comision_num = porcentaje(floatval($precio), $p_comision, 2, 2);
                $utilidad = floatval($precio) - (($es_servicio < 1) ? floatval($costo_envio["costo_envio_vendedor"]) : 0);
                $utilidad = $utilidad - $comision_num;

            }

            $tipo_promocion = ($es_servicio > 0) ? "SERVICIO" : "PRODUCTO";
            $valor_youtube = pr($servicio, "url_vide_youtube");
            $val_youtube = icon('fa fa-pencil text_url_youtube') . $valor_youtube;
            $_nombre_servicio = pr($servicio, "nombre_servicio");

            $r[] = get_heading_servicio($tipo_promocion, $_nombre_servicio, $servicio);
            $r[] = addNRow(menu_config($num, $num_imagenes, $url_productos_publico));
            $r[] = configurador($s, $data, $num,
                $num_imagenes,
                $id_servicio,
                $data["id_perfil"],
                $tipo_promocion,
                $val_youtube,
                $valor_youtube,
                val_class($num, 1, ' active '),
                pr($servicio, 'descripcion'),
                $es_servicio,
                $s["telefono_visible"],
                "¿TAMBIÉN VENDES ESTE PRODUCTO A PRECIOS DE MAYOREO?",
                $precio,
                $costo_envio,
                "COMISIÓN POR VENTA" . $comision . "MXN",
                $utilidad,
                $servicio,
                $_nombre_servicio
            );

            $response[] = agregar_imgs();
            $response[] = d(append($r), "contenedor_global_servicio");
            return append($response);

        }

    }

    function configurador($s, $data, $num,
                          $num_imagenes,
                          $id_servicio,
                          $id_perfil,
                          $tipo_promocion,
                          $val_youtube, $valor_youtube,
                          $ext_1,
                          $n_descripcion,
                          $es_servicio,
                          $tel_visible,
                          $str_envios_mayoreo,
                          $precio,
                          $costo_envio,
                          $str_comision_venta,
                          $utilidad,
                          $servicio,
                          $nnservicio
    )
    {


        $n_titulo = d(
            h("INFORMACIÓN SOBRE TU " . $nnservicio . icon('fa fa-pencil text_desc_servicio icon-pencil'), 5)
            , "top_50 titulo_seccion_producto titulo_producto_servicio", 1
        );

        $in_descripcion = d($n_descripcion, "text_desc_servicio contenedor_descripcion top_30", 1);


        $r[] = conf_entrada(
            h(valida_text_imagenes($tipo_promocion, $num_imagenes), 3),
            $num_imagenes,
            $id_servicio,
            $id_perfil,
            $data["images"],
            $tipo_promocion,
            $val_youtube,
            $valor_youtube,
            $ext_1
        );


        $r[] = conf_producto(
            $n_titulo,
            $in_descripcion,
            $n_descripcion,
            $es_servicio,
            create_colores_disponibles($s["color"]),
            val_class($num, 2, ' active ')
        );


        $r[] = conf_detalle(
            $s["status"], $id_servicio,
            $es_servicio, $id_perfil,
            $s["stock"],
            $s["tiempo_promedio_entrega"],
            $s["entregas_en_casa"],
            $tel_visible,
            $s["contra_entrega"],
            $s["existencia"],
            $s["flag_nuevo"],
            $data["ciclos"],
            $s["id_ciclo_facturacion"],
            $data["has_phone"],
            $str_envios_mayoreo,
            $s["venta_mayoreo"],
            $s["url_ml"],
            $precio, $costo_envio,
            $s["link_dropshipping"],
            $str_comision_venta, $utilidad,
            val_class($num, 4, ' active ')

        );

        $r[] = conf_avanzado(
            $servicio,
            $id_perfil,
            $id_servicio,
            $s["metakeyword_usuario"],
            val_class($num, 3, ' active ')
        );
        return d(append($r), "tab-content");

    }

    function conf_avanzado(
        $servicio,
        $id_perfil,
        $id_servicio,
        $keyword_usuario,
        $extra_3)
    {


        $f[] = format_restablecer($servicio, $id_perfil);
        $f[] = form_tags($id_servicio, $keyword_usuario);
        return d(append($f), ["class" => "tab-pane " . $extra_3, "id" => "tab_terminos_de_busqueda"]);

    }

    function conf_detalle(
        $status, $id_servicio,
        $es_servicio, $id_perfil, $stock,
        $pronostico_entrega,
        $entregas_en_casa,
        $telefono_visible,
        $es_entrega,
        $existencia,
        $es_nuevo,
        $ciclos,
        $id_ciclo_facturacion,
        $has_phone,
        $text_envios_mayoreo,
        $venta_mayoreo,
        $url_ml,
        $precio,
        $costo_envio,
        $link_dropshipping,
        $text_comision_venta,
        $utilidad,
        $ext_4

    )
    {

        $activo_visita_telefono = val_class(1, $telefono_visible, "button_enid_eleccion_active");
        $baja_visita_telefono = val_class(0, $telefono_visible, "button_enid_eleccion_active");


        $t[] = d(d(estado_publicacion($status, $id_servicio), "col-lg-4 top_30 bottom_20", 1), 12);
        $t[] = form_rango_entrega($es_servicio, $id_perfil, $stock);
        $t[] = d(rango_entrega(
                $id_perfil,
                $pronostico_entrega,
                [
                    "name" => "tiempo_entrega"
                    ,
                    "class" => "tiempo_entrega form-control"
                ],
                "DÍAS PROMEDIO DE ENTREGA")
            ,
            6
        );
        $t[] = d(
            form_drop_shipping($id_perfil, $id_servicio, $link_dropshipping)
            ,
            6
        );


        $t[] = d(compras_casa($es_servicio, $entregas_en_casa), 6);
        $t[] = d(telefono_publico($has_phone, $telefono_visible, $activo_visita_telefono, $baja_visita_telefono, $es_servicio), 6);
        $t[] = conf_contra_entrega($es_servicio, $es_entrega, $id_servicio);
        $t[] = uso_disponibilidad($existencia, $es_nuevo, $es_servicio);
        $t[] = seccion_ciclos_facturacion($ciclos, $id_ciclo_facturacion, $es_servicio);
        $t[] = format_venta_mayoreo($es_servicio, $text_envios_mayoreo, $venta_mayoreo);
        $t[] = path_venta_extra($es_servicio, $url_ml);
        $t[] = form_costo_unidad($precio, $es_servicio, $costo_envio);
        $t[] = format_utilidad($es_servicio, $text_comision_venta, $utilidad);
        return d(append($t), ["class" => "tab-pane " . $ext_4, "id" => "tab_info_precios"]);

    }

    function conf_producto(
        $n_titulo_producto,
        $inf_n_descripcion,
        $nueva_descripcion,
        $es_servicio,
        $info_colores,
        $ext_2
    )
    {

        $d[] = $n_titulo_producto;
        $d[] = place("place_tallas_disponibles");
        $d[] = $inf_n_descripcion;
        $d[] = form_descripcion($nueva_descripcion);
        $d[] = format_colores($es_servicio, $info_colores);
        return d(append($d), ["class" => "tab-pane " . $ext_2, "id" => "tab_info_producto"]);

    }

    function conf_entrada(
        $notificacion_imagenes,
        $num_imagenes,
        $id_servicio,
        $id_perfil,
        $images,
        $tipo_promocion,
        $val_youtube,
        $valor_youtube,
        $ext_1)
    {


        $z[] = addNRow($notificacion_imagenes);
        $z[] = addNRow(valida_descartar_promocion($num_imagenes, $id_servicio, $id_perfil));
        $z[] = d($images, ["class" => "contenedor_imagen_muestra"], 1);
        $z[] = h("¿TIENES ALGÚN VIDEO SOBRE TU " . $tipo_promocion . "?", 4);
        $z[] = d(text_icon('fa fa-youtube-play', " VIDEO DE YOUTUBE "), 1);
        $z[] = d($val_youtube, ["class" => "text_video_servicio"], 1);
        $z[] = form_youtube($valor_youtube);
        return d(append($z), ["class" => "tab-pane " . $ext_1, "id" => "tab_imagenes"]);


    }

    function format_restablecer($servicio, $id_perfil)
    {

        if (es_data($servicio) && $id_perfil == 3) {

            return
                d(btn("RESTABLECER PUBLICACIÓN", ["class" => "restablecer", "id" => pr($servicio, "id_servicio")]), "row pull-right bottom_100");
        }
    }

    function format_colores($es_servicio, $inf_colores)
    {
        $r = [];
        if ($es_servicio < 1) {

            $r[] = d("+ AGREGAR COLORES", "underline text_agregar_color top_30 bottom_30 strong", 1);
            $r[] = d($inf_colores, 1);
            $r[] = btw(

                d("", ["id" => "seccion_colores_info"], 1)
                ,
                d("", "place_colores_disponibles", 1)
                ,
                "input_servicio_color"
            );

        }

        return append($r);
    }

    function path_venta_extra($es_servicio, $url_ml)
    {

        $r = [];
        if ($es_servicio < 1) {

            $x[] = d(h("¿CUENTAS CON ALGÚN ENLACE DE PAGO EN MERCADO LIBRE?", 5), 1);
            $x[] = d(
                input(
                    [
                        "type" => "url",
                        "name" => "url_mercado_libre",
                        "class" => "form-control url_mercado_libre",
                        "value" => $url_ml
                    ]
                )
                , 1
            );

            $x[] = btn("GUARDAR", ["class" => "btn_url_ml top_50"], 1);
            $r[] = d(d(append($r, "contenedor_pago_ml top_50"), " col-lg-12 top_50 "), 6);

        }
        return append($r);


    }

    function format_venta_mayoreo($es_servicio, $str_envios_mayoreo, $venta_mayoreo)
    {


        $r = [];
        if ($es_servicio < 1) {

            $x[] = btw(
                h($str_envios_mayoreo, 5)
                ,
                seccion_ventas_mayoreo($venta_mayoreo)
                ,
                "contenedor_inf_servicios seccion_ventas_mayoreo top_50"
            );

            $r[] = d(d(d(append($x), "top_50"), 12), 6);

        }
        return append($r);

    }

    function format_utilidad($es_servicio, $text_comision_venta, $utilidad)
    {

        $r[] = btw(
            h($text_comision_venta, 4)
            ,
            h("GANANCIA FINAL " . $utilidad . "MXN", 2)
            ,
            12
        );

        return d(d(d(append($r), "top_50 bottom_80"), "col-lg-12 shadow border top_30 bottom_80 padding_10 "), 12);
    }

    function seccion_ciclos_facturacion($ciclos, $id_ciclo_facturacion, $es_servicio)
    {

        $x = [];
        if ($es_servicio > 0 && es_data($ciclos)) {


            $r[] = btw(
                h('CICLO DE FACTURACIÓN', 5)
                ,
                icon('fa fa-pencil text_ciclo_facturacion')
                ,
                "display_flex_enid"
                ,
                12


            );
            $r[] = d(nombre_ciclo_facturacion($ciclos, $id_ciclo_facturacion), "top_30");
            $r[] = btw(
                create_select_selected($ciclos,
                    "id_ciclo_facturacion",
                    "ciclo",
                    $id_ciclo_facturacion,
                    "ciclo_facturacion",
                    "ciclo_facturacion form-control"
                )
                ,
                btn("GUARDAR", ['class' => 'btn_guardar_ciclo_facturacion']),
                "input_ciclo_facturacion display_none top_30"
            );


            $x[] = d(append($r), "contenedor_inf_servicios contenedor_inf_servicios_ciclo_facturacion top_30");
        }

        return (count($x) > 0) ? d(d(d(append($x), 12), "top_50"), 6) : "";


    }

    function uso_disponibilidad($existencia, $es_nuevo, $es_servicio)
    {


        $r = [];

        if ($es_servicio < 1) {

            $r = [
                 d(seccion_articulos_disponibles($existencia), 6),
                 d(seccion_uso_producto($es_nuevo), 6)
            ];

        }

        return append($r);

    }

    function seccion_articulos_disponibles($existencia)
    {

        $r[] = btw(
            h('¿ARTÍCULOS DISPONIBLES?', 5, 1)
            ,
            d(text_icon('fa fa-pencil text_cantidad', valida_text_numero_articulos($existencia)), "text_numero_existencia", 1)
            ,
            ""
        );

        $x[] = d(
            input(
                [
                    "type" => "number",
                    "name" => "existencia",
                    "class" => "existencia top_30",
                    "required" => "",
                    "value" => $existencia,
                ]
            ),
            9

        );

        $x[] = d(btn("GUARDAR", ["class" => "es_disponible btn_guardar_cantidad_productos top_30 "]), 3);
        $r[] = d(d(append($x), 13), "input_cantidad seccion_cantidad");
        return d(d(append($r), "top_50"), 12);
    }

    function seccion_uso_producto($es_nuevo)
    {

        $usado = ["No", "Si"];
        $r[] = h("¿ES NUEVO?", 5, 1);
        $r[] = d(
            text_icon('fa fa-pencil text_nuevo',  $usado[$es_nuevo])

            , 1);
        $r[] = btw(

            d(select_producto_usado($es_nuevo), "col-lg-9 top_30")
            ,
            d(btn("GUARDAR", ["class" => "btn_guardar_producto_nuevo es_nuevo top_30 "], 0), 3)
            ,
            "input_nuevo seccion_es_nuevo  row"

        );
        return d(d(append($r), "top_50"), 12);

    }

    function create_vista($s)
    {
        $id_servicio = $s["id_servicio"];
        $in_session = $s["in_session"];

        $id_perfil = (prm_def($s, "id_perfil") > 0) ? $s["id_perfil"] : 0;


        $p[] =
            d(
                img([
                    'src' => $s["url_img_servicio"],
                    'alt' => $s["metakeyword"],
                    'style' => "max-height: 270px !important",
                    'class' => "padding_5 top_10 hover_padding"
                ])
            );


        if ($in_session > 0) {

            $response[] = d(a_enid(append($p), get_url_servicio($id_servicio)));
            $response[] = d(val_btn_edit_servicio($in_session, $id_servicio, $s["id_usuario"], $s["id_usuario_actual"], $id_perfil));
            $response = d(append($response), "producto_enid d-flex flex-column justify-content-center col-lg-3  top_50 px-3 ");


        } else {

            $response = a_enid(
                append($p),
                [
                    "href" => get_url_servicio($id_servicio),
                    "class" => "producto_enid d-flex flex-column justify-content-center col-lg-3  top_50 px-3 "

                ]
            );
        }

        return $response;

    }

    function get_base_empresa($paginacion, $busqueda, $num_servicios, $productos)
    {

        $paginacion = addNRow(d($paginacion, 1));
        $r = [];
        $callback = function ($n) {
            return d($n);
        };

        $r += array_map($callback, $productos);
        $t[] = addNRow(icon("fa fa-search") . "Tu búsqueda de" . $busqueda . "(" . $num_servicios . "Productos)");
        $t[] = addNRow($paginacion);
        $t[] = append($r);

        $bloque[] = addNRow(d(append($t), 1));
        $bloque[] = addNRow($paginacion);
        return append($bloque);

    }

    /*
    function get_text_costo_envio($es_servicio, $costo_envio)
    {

        return ($es_servicio < 1) ? d($costo_envio, 'informacion_costo_envio', 1) : "";

    }
    function get_session_color($color, $es_servicio, $url_info_producto, $extra_color, $existencia, $in_session)
    {

        return add_text(get_numero_colores($color, $es_servicio, $url_info_producto, $extra_color), get_en_existencia($existencia, $es_servicio, $in_session));

    }
    */

    function menu_config($num, $num_imagenes, $url_productos_publico)
    {

        $foto_config = [
            'href' => "#tab_imagenes",
            'data-toggle' => "tab"
        ];
        $precios_config = [
            'href' => "#tab_info_precios",
            'data-toggle' => "tab"
        ];

        $precios_inf = ['href' => "#tab_info_producto",
            'data-toggle' => "tab",
            'id' => 'tab_info_producto_seccion',
            'class' => 'detalle'
        ];

        $meta_inf = ['href' => "#tab_terminos_de_busqueda", 'data-toggle' => "tab"];

        $list = [
            li(a_enid(icon('fa fa-picture-o'), $foto_config), ["class" => valida_active($num, 1)]),
            li(a_enid(icon('fa fa-credit-card'), $precios_config), ["class" => valida_active($num, 4), "style" => valida_existencia_imagenes($num_imagenes)]),
            li(a_enid(icon('fa fa-info detalle'), $precios_inf), ["style" => valida_existencia_imagenes($num_imagenes)]),
            li(a_enid(icon('fa fa-fighter-jet menu_meta_key_words'), $meta_inf),
                ["class" => valida_active($num, 3), "style" => valida_existencia_imagenes($num_imagenes)]
            ),
            li(a_enid(icon("fa fa-shopping-bag") . "VER PUBLICACIÓN",
                [
                    "href" => $url_productos_publico,
                    "target" => "_blank",
                    "style" => 'background: #002565;color: white!important;'
                ]), ["style" => valida_existencia_imagenes($num_imagenes)]
            )
        ];

        return ul($list, "nav nav-tabs");

    }

    function get_config_categorias($data, $param)
    {

        $nivel = "nivel_" . $data["nivel"];
        $config = [
            'class' => 'num_clasificacion ' . $nivel . ' selector_categoria ',
            'size' => '20'
        ];

        if ($param["is_mobile"] > 0) {

            $config = [
                'class' => 'num_clasificacion ' . $nivel . ' num_clasificacion_phone selector_categoria '
            ];
        }


        $select = select_enid(
            $data["info_categorias"],
            "nombre_clasificacion",
            "id_clasificacion",
            $config);
        return $select;

    }

    function get_add_categorias($data, $param)
    {

        $data["padre"] = $param["padre"];
        $select = d(
            text_icon('fa fa-angle-double-right', "AGREGAR NUEVO")
            ,
            [
                "class" => "a_enid_black nueva_categoria_producto top_20",
                "id" => $data["padre"]
            ],
            1);
        return $select;
    }

    function estado_publicacion($status, $id_servicio)
    {

        $text = ($status > 0) ? "PAUSAR PUBLICACIÓN" : "ACTIVAR PUBLICACIÓN";

        return a_enid(
            $text,
            [
                "id" => $id_servicio,
                "status" => $status,
                "class" => 'button_enid_eleccion activar_publicacion'
            ]
        );
    }

    function une_data($data_servicios, $data_intentos_entregas)
    {

        $new_data = [];
        $response = [];
        $a = 0;
        foreach ($data_servicios as $row) {

            $new_data[$a] = $row;
            $key = array_search($row["id_servicio"], array_column($data_intentos_entregas, "id_servicio"));
            if ($key != false) {

                $new_data[$a]["intentos_compras"] = $data_intentos_entregas[$key];

            }

            $a++;
        }


        $z = 0;
        foreach ($new_data as $row) {

            $response[$z] = [

                "id_servicio" => $row["id_servicio"],
                "vista" => $row["vista"],
                "nombre_servicio" => $row["nombre_servicio"],
                "deseado" => $row["deseado"],
                "valoracion" => $row["valoracion"],
            ];

            if (array_key_exists("intentos_compras", $row)) {


                $response[$z] += [

                    "intentos" => $row["intentos_compras"]["intentos"],
                    "punto_encuentro" => $row["intentos_compras"]["punto_encuentro"],
                    "mensajeria" => $row["intentos_compras"]["mensajeria"],
                    "visita_negocio" => $row["intentos_compras"]["visita_negocio"],
                ];

            } else {


                $response[$z] += [
                    "intentos" => 0,
                    "punto_encuentro" => 0,
                    "mensajeria" => 0,
                    "visita_negocio" => 0,
                ];

            }

            $z++;
        }
        return $response;
    }

    function dropdown_button($id_imagen, $principal = 0)
    {

        $text = menorque($principal, 1, "Definir como principal", "Imagen principal");
        $extra_principal = menorque($principal, 1, "", "blue_enid");


        $definir = d(
            icon('fa fa-star', "dropdown-item  " . $extra_principal) .
            $text,
            [
                "class" => "top_20 cursor_pointer imagen_principal",
                "id" => $id_imagen
            ]
        );


        $quitar =
            d(

                icon('fa fa-times', "dropdown-item ") . "Quitar"

                , ["class" => "top_20 cursor_pointer foto_producto", "id" => $id_imagen]);


        $x[] = d(icon("fa fa fa-pencil"), "dropdown-toggle ");
        $x[] = ul([$definir, $quitar], ["class" => "dropdown-menu ", "style" => "height:100px"]);
        $r[] = d(append($x), "dropdown ");
        return append($r);


    }

    /*function valida_tipo_promocion($param)
    {

    return mayorque(pr($param, "flag_servicio", 0), 0, "SERVICIO", "PRODUCTO");

    }
    */

    function nombre_ciclo_facturacion($ciclos, $id_ciclo)
    {

        return search_bi_array($ciclos, "id_ciclo_facturacion", $id_ciclo, "ciclo");

    }

    function create_colores_disponibles($text_colores)
    {

        $arr_colores = explode(",", $text_colores);
        $r = [];
        for ($a = 0; $a < count($arr_colores); $a++) {

            $codigo_color = $arr_colores[$a];
            $contenido = icon('fa fa-times elimina_color', ["id" => $codigo_color]) . " " . $codigo_color;
            $r[] = d($contenido, ["style" => "background:" . $codigo_color . ";color:white;padding:3px;"]);
        }
        return d(append($r), ["id" => 'contenedor_colores_disponibles']);
    }

    function valida_text_numero_articulos($num)
    {

        $text = d("Alerta", 'mjs_articulo_no_disponible') . "este artúculo no se encuentra disponible, agregar nuevo";
        if ($num > 0) {
            $s1 = $num . " Artículo disponible";
            $s2 = $num . " Artículos disponibles";
            $text = ($num > 1) ? $s1 : $s2;
        }
        return $text;
    }

    function evalua_utilidad_mas_envio($flag_envio_gratis, $costo_envio, $utilidad)
    {

        return ($flag_envio_gratis > 0) ? ($utilidad - $costo_envio) : $utilidad;

    }


    function select_producto_usado($valor_actual)
    {

        $usado = ["No", "Si"];
        $r[] = "<select class='form-control producto_nuevo'>";
        for ($z = 0; $z < count($usado); $z++) {

            $r[] = ($z == $valor_actual) ? "
    <option value='" . $z . "' selected>" . $usado[$z] . "</option>
    " : "
    <option value='" . $z . "'>" . $usado[$z] . "</option>
    ";

        }
        $r[] = "</select>";
        $response = append($r);
        return $response;
    }

    function get_producto_usado($tipo)
    {
        $usado = ["No", "Si"];
        return $usado[$tipo];
    }


    function create_table_servicios($servicios)
    {

        $list = [];
        $z = 1;
        $extra = "";
        foreach ($servicios as $row) {

            $r = [];
            $text_estatus = ($row["status"] == 0) ? "Inactivo" : "Activo";
            $r[] = td(icon('servicio fa fa-file-text-o', ["id" => $row["id_servicio"]]),
                'especificacion_servicio'
            );

            $r[] = td($row["nombre_servicio"], $extra);
            $r[] = td($text_estatus, 'text-center strong');
            $list[] = tr(append($r));
            $z++;
        }
        return $list;

    }

    function get_text_ciclo_facturacion($id_ciclo_facturacion)
    {

        $nuevo_text = "";
        switch ($id_ciclo_facturacion) {
            case '1':
                $nuevo_text = "365 Días";

                break;
            case '2':
                $nuevo_text = "30 Días";

                break;

            case '3':
                $nuevo_text = "7 Días";

                break;

            case '4':
                $nuevo_text = "15 Días";

                break;

            case '5':
                $nuevo_text = "Págo único";
                break;
            case '6':
                $nuevo_text = "365 Días";
                break;

            case '7':
                $nuevo_text = "365 Días";
                break;

            case '8':
                $nuevo_text = "365 Días";
                break;

            default:

                break;
        }
        return $nuevo_text;
    }

    function is_servicio($row)
    {

        $flag_precio_definido = 0;


        $extra = "";
        switch ($row["flag_servicio"]) {
            case 1:

                $extra = ($flag_precio_definido == 1) ? "" : "A convenir";

                break;
            case 0:

                $extra = ($row["flag_envio_gratis"] == 1) ? "Envios gratis a todo México" : "Envios a todo México";

                break;

            default:
                break;
        }

        return $extra;
    }

    function get_precio_producto($url_info_producto, $precio)
    {

        return d(d(a_enid($precio . 'MXN', $url_info_producto), "texto_precio"), 1);

    }

    function get_numero_colores($color, $es_servicio)
    {

        $response = "";
        if ($es_servicio != 1) {

            $num_colores = explode(",", $color);
            if (es_data($num_colores)) {

                $num_colores = count($num_colores);
                $response = ($num_colores > 1) ? $num_colores . " colores" : $num_colores . " color";
            }
        }
        return $response;
    }


    function get_en_existencia($existencia, $es_servicio, $in_session)
    {

        return ($es_servicio == 0) ? informacion_existencia_producto($existencia, $in_session) : "";

    }

    function informacion_existencia_producto($existencia, $in_session)
    {

        return ($in_session > 0 && $existencia > 0) ? span($existencia . " En existencia ") : span("INVENTARIO LIMITADO");

    }

    function muestra_vistas_servicio($in_session, $vistas)
    {

        return mayorque($in_session, 0, d(add_text($vistas, " personas alcanzadas")));

    }

    function val_btn_edit_servicio($in_session, $id_servicio, $id_usuario, $id_usuario_registro_servicio, $id_perfil)
    {

        $response = "";
        if ($in_session > 0 && $id_usuario == $id_usuario_registro_servicio || ($id_perfil > 0 && $id_perfil != 20)) {
            $response = icon("top_40  bottom_40 servicio fa fa-pencil", ["id" => $id_servicio]);
        }

        return $response;

    }

    function rango_entrega($id_perfil, $actual, $attributes = '', $titulo, $minimo = 1, $maximo = 10)
    {


        $response = "";

        if ($id_perfil == 3) {

            $att = add_attributes($attributes);

            $select[] = "<select " . $att . ">";

            for ($a = $minimo; $a < $maximo; $a++) {

                $select[] = ($a == $actual) ? "
<option value='" . $a . "' selected>" . $a . "</option>" : "
<option value='" . $a . "'>" . $a . "</option>";

            }

            $select[] = "</select>";
            $select[] = d(place("response_tiempo_entrega"), 12);
            $select = append($select);

            $response = btw(
                d(d(h($titulo, 5), 1), 1)
                ,
                d($select, 1)
                ,
                "top_30"

            );

        }

        return d($response, 12);

    }

    function get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping)
    {


        $response = "";
        if ($id_perfil == 3) {

            $icono = d(icon("fa fa fa-pencil"), ["class" => "text_link_dropshipping", "onclick" => "muestra_cambio_link_dropshipping('" . $id_servicio . "')"], 1);
            $titulo = d(h("LINK DROPSHIPPING", 5), 1);
            $titulo = btw($titulo, $icono, "display_flex_enid");


            $x[] = d(
                input(
                    [
                        "class" => "form-control ",
                        "name" => "link_dropshipping",
                        "required" => "true",
                        "placeholder" => "Link de compra",
                        "type" => "url",
                        "value" => $link_dropshipping

                    ]
                ),
                1
            );

            $x[] = input_hidden(["name" => "servicio", "value" => $id_servicio]);
            $x[] = d(btn("GUARDAR", ["class" => "top_30"]), 1);
            $x[] = d(place("response_link_dropshipping"), 1);


            if (strlen($link_dropshipping) > 10) {

                $r[] = a_enid("Link", [
                    "href" => $link_dropshipping,
                    "class" => "underline",
                    "target" => "_black"
                ]);
            }

            $r[] = d(append($x), "input_link_dropshipping");
            $select = append($r);
            $response = btw($titulo, $select, "top_30 ");

        }
        return $response;

    }

    function sumatoria_array($array, $key)
    {

        return array_sum(array_column($array, $key));
    }

    function agregar_imgs()
    {

        $r[] = d(
            d(

                a_enid(

                    icon('fa fa fa-times white')

                    ,

                    'btn_enid_blue cancelar_carga_imagen cancelar_img pull-right white bottom_30',

                    1
                ),
                4
                ,
                1
            ),
            1);

        $x[] = d(h("AGREGAR IMAGENES", 5), 4, 1);
        $x[] = d(place("place_img_producto"), 4, 1);
        $r[] = d(append($x), 1, 4);
        return d(append($r), "contenedor_agregar_imagenes");

    }

    function get_base_youtube($url)
    {

        $text = "";
        $f = 0;
        for ($a = strlen($url) - 1; $a > 1; $a--) {

            if ($url[$a] === "=" || $url[$a] === "/") {

                $f = $a;
                break;
            }
        }

        for ($b = ($f + 1); $b < strlen($url); $b++) {
            $text .= $url[$b];
        }

        return path_enid("youtube_embebed", $text, 0, 1);

    }

    function get_heading_servicio($tipo_promocion, $nuevo_nombre_servicio, $servicio)
    {

        $response = [];
        $ie_nombre = input(
            [

                "type" => "text",
                "name" => "q2",
                "class" => "nuevo_producto_nombre",
                "onkeyup" => "transforma_mayusculas(this)",
                "value" => pr($servicio, 'nombre_servicio'),
                "required" => true
            ],
            1
        );

        $h = append([icon('fa fa-pencil text_nombre_servicio'), $tipo_promocion, $nuevo_nombre_servicio]);
        $respons[] = h($h, 4);
        $respons[] = form_open("", ['class' => 'form_servicio_nombre_info input_nombre_servicio_facturacion ']);
        $respons[] = input_hidden(["name" => "q", "value" => "nombre_servicio"], 1);
        $respons[] = d($ie_nombre, 9);
        $respons[] = d(btn("GUARDAR", ["class" => "info_guardar_nombre_servicio"], 1), 3);
        $respons[] = form_close();
        return addNRow(append($response));

    }

    function form_youtube($valor_youtube)
    {

        $r = [];
        $i = input([
            "type" => "hidden",
            "name" => "q",
            "value" => "url_vide_youtube"
        ],
            1);


        $p = d("", "place_url_youtube", 1);
        array_push($r, form_open("", ["class" => "form_servicio_youtube input_url_youtube contenedor_info_youtube"]));
        array_push($r, input([
            "type" => "url",
            "name" => "q2",
            "class" => 'url_youtube',
            "value" => $valor_youtube,
            "required" => true
        ], 1));

        array_push($r, d($i . $p, 9));
        array_push($r, d(btn("GUARDAR", ["class" => "guardar_video_btn"], 1), 3));
        array_push($r, form_close());

        return append($r);

    }

    function form_descripcion($nueva_descripcion)
    {

        $r = [];
        array_push($r, form_open("", ["class" => "top_30 form_servicio_desc input_desc_servicio_facturacion"]));
        array_push($r, input([
                "type" => "hidden",
                "name" => "q",
                "value" => "descripcion"
            ], 1)
        );

        array_push($r, d("-" . $nueva_descripcion, ["id" => "summernote"], 1));
        array_push($r, d(btn("GUARDAR", ["class" => "btn_guardar_desc"], 1)));
        array_push($r, form_close());
        return append($r);
    }

    function form_rango_entrega($es_servicio, $id_perfil, $stock)
    {


        if ($es_servicio < 1 && $id_perfil == 3) {

            $r = [];
            array_push($r, form_open("", ["class" => "form_stock"]));
            array_push($r, rango_entrega(
                    $id_perfil,
                    $stock,
                    [
                        "name" => "stock",
                        "class" => "stock form-control"
                    ],
                    "ARTICULOS EN STOCK"
                    ,
                    0
                    ,
                    100
                )
            );

            array_push($r, form_close());
            return d(append($r), 6);
        }


    }

    function form_drop_shipping($id_perfil, $id_servicio, $link_dropshipping)
    {

        $r = [];
        array_push($r, form_open("", ["class" => "form_dropshipping text-right"]));
        array_push($r, get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping));
        array_push($r, form_close());
        return d(append($r), 12);

    }

    function compras_casa($es_servicio, $entregas_en_casa)
    {
        $titulo_ca = ($es_servicio == 1) ? "OFRECES SERVICIO EN TU NEGOCIO?" : "¿CLIENTES TAMBIÉN PUEDEN RECOGER SUS COMPRAS EN TU NEGOCIO?";
        $atencion = ($es_servicio == 1) ? "NO" : "NO, SOLO HAGO ENVÍOS";

        $confirmar = a_enid(
            "SI",
            [
                "id" => '1',
                "class" => 'button_enid_eleccion entregas_en_casa_si entregas_en_casa ' . val_class(1, $entregas_en_casa, "button_enid_eleccion_active")
            ]
        );


        $omitir = a_enid(
            $atencion,
            [
                "id" => '0',
                "class" => 'button_enid_eleccion entregas_en_casa_no entregas_en_casa ' . val_class(0, $entregas_en_casa, "button_enid_eleccion_active")
            ]
        );

        $r[] = d(h($titulo_ca, 5), 1);
        $r[] = btw($confirmar, $omitir, "top_30 ");
        return d(d(d(append($r), "top_50"), 1), 12);


    }

    function telefono_publico($has_phone, $telefono_visible, $activo_visita_telefono, $baja_visita_telefono, $es_servicio)
    {

        $ver_telefono = ($es_servicio == 1) ? "¿PERSONAS PUEDEN VER TU NÚMERO TELEFÓNICO PARA SOLICITARTE MÁS INFORMES?" : "¿PERSONAS PUEDEN SOLICITARTE MÁS INFORMES POR TELÉFONO?";
        $v = a_enid(
            "SI",
            [
                'id' => 1,
                'class' => 'button_enid_eleccion telefono_visible ' . $activo_visita_telefono
            ]

        );


        $nov = a_enid(
            "NO, OCULTAR MI TELÉFONO",
            [
                'id' => 0,
                'class' => 'button_enid_eleccion  no_tel telefono_visible ' . $baja_visita_telefono
            ]

        );

        $r[] = d(h($ver_telefono, 5), "top_50", 1);
        $r[] = btw($v, $nov, "top_40 ");
        $r[] = text_agregar_telefono($has_phone, $telefono_visible);
        return d(append($r), 12);


    }

    function conf_contra_entrega($es_servicio, $es_entrega, $id_servicio)
    {

        if ($es_servicio < 1) {

            $v = val_class($es_entrega, 1, "button_enid_eleccion_active");
            $v2 = val_class($es_entrega, 0, "button_enid_eleccion_active");
            $si =
                a_enid(
                    "SI",
                    [
                        'id' => 1,
                        'class' => 'button_enid_eleccion  ' . $v,
                        'onClick' => "contra_entrega(1, '{$id_servicio}')"
                    ]

                );

            $no = a_enid("NO, SOLO ENVÍOS A DOMICILIO POR PAQUETERÍA",
                [
                    'id' => 0,
                    'class' => 'button_enid_eleccion ' . $v2,
                    'onClick' => "contra_entrega(0, '{$id_servicio}')"
                ]
            );

            $r[] = h("¿VENDES ESTA ARTÍCULO CONTRA ENTREGA?", 5, "top_30");
            $r[] = btw($si, $no, "top_30");
            return d(d(d(append($r), "top_50"), 12), 6);

        }
    }


    function seccion_ventas_mayoreo($vm)
    {

        $m
            = a_enid("SI",
            [
                "id" => 1,
                "class" => 'button_enid_eleccion venta_mayoreo ' .
                    val_class(1, $vm, "button_enid_eleccion_active")
            ]
        );

        $mm = a_enid("NO",
            [
                "id" => '0',
                "class" =>
                    'button_enid_eleccion venta_mayoreo ' .
                    val_class(0, $vm, "button_enid_eleccion_active")
            ]
        );

        return btw($m, $mm, "ventas_mayoreo display_flex_enid top_30");

    }

    function form_tags($id_servicio, $keyword_usuario)
    {

        $r = [];

        $r[] = d(d(create_meta_tags($keyword_usuario, $id_servicio), "info_meta_tags", 1), "top_30 bottom_30");
        $r[] = form_open("", ["class" => "form_tag", "id" => "form_tag"]);
        $r[] = input([
            "type" => "hidden",
            "name" => "id_servicio",
            "class" => "id_servicio",
            "value" => $id_servicio
        ]);
        $in = btw(
            d(h("AGREGAR", 5), 2),
            d(input([
                "type" => "text",
                "name" => "metakeyword_usuario",
                "required" => true,
                "placeholder" => "Palabra como buscan tu producto",
                "class" => "metakeyword_usuario"
            ]), 10)
            ,
            "agregar_tags "
        );

        $r[] = $in;
        $r[] = form_close(place("contenedor_sugerencias_tags"));
        return append($r);


    }

    function form_costo_unidad($precio, $es_servicio, $costo_envio)
    {


        $text_precio_unidad = text_icon('fa fa-pencil', "PRECIO POR UNIDAD: $" . $precio . "MXN");

        $r = [];

        array_push($r, h("PRECIO POR UNIDAD", 5));
        array_push($r, a_enid(
                $text_precio_unidad,
                [
                    "class" => "a_precio_unidad text_costo informacion_precio_unidad"
                ]
                ,
                1)
        );
        array_push($r, form_open("", ["class" => "form_costo input_costo contenedor_costo top_30"]));

        $in = btw(
            input(
                [
                    "type" => "number",
                    "name" => "precio",
                    "step" => "any",
                    "class" => "form-control ",
                    "value" => $precio
                ]
            ),
            d("MXN", "mxn")
            ,
            "display_flex_enid"
        );

        array_push($r, $in);
        array_push($r, btn("GUARDAR", ["class" => "top_30"]));
        array_push($r, form_close(place("place_registro_costo")));


        $response[] = append($r);

        if ($es_servicio < 1) {

            $r = [];

            $r[] = h("COSTO DE ENVÍO",
                5,
                'costo_envio_text top_50'
                ,
                1
            );

            $r[] = d(
                text_icon('fa fa fa-pencil', $costo_envio["text_envio"]["ventas_configuracion"])

                ,
                "text_info_envio top_30"
                ,
                1
            );

            $r[] = d(
                $costo_envio["text_envio"]["cliente"]
                ,
                "text_info_envio text_info_envio_editable top_30"
            );

            $response[] = d(append($r), "contenedor_informacion_envio seccion_informacion_envio");

            $opt[] = array(
                "text" => "NO, QUE SE CARGUE AL CLIENTE",
                "v" => 0
            );
            $opt[] = array(
                "text" => "SI - YO PAGO EL ENVIO",
                "v" => 1
            );


            $r = [];
            $r[] = d(h("¿EL PRECIO INCLUYE ENVÍO?", 5, 1), "top_50");
            $r[] = btw(
                d(create_select($opt, "input_envio_incluido", "input_envio_incluido form-control top_30", "input_envio_incluido", "text", "v"), 9)
                ,
                d(btn('GUARDAR', ["class" => "btn_guardar_envio top_30 "]), 3)
                ,
                "row top_30"

            );

            $response[] = d(d(append($r), "input_envio config_precio_envio"));

        }
        $response = d(d(d(append($response), 12), "top_50"), 6);
        return $response;

    }

    function get_tabla_colores()
    {

        $colores_esp = ["Turquesa", "Emerland", "Peterriver", "Amatista", "Wetasphalt", "Mar verde", "Nefritis", "Belizehole", "Glicinas", "Medianoche azul", "Girasol", "Zanahoria", "Alizarina", "Nubes", "Hormigón", "Naranja", "Calabaza", "Granada", "Plata", "Amianto", "Blanco", "Blue", "Cafe", "Morado", "Morado 2", "Azul", "Azul", "Verde", "Verde", "Verde 2", "Amarillo", "Amarillo 2", "Amarillo 3", "Amarillo 4", "Amarillo 5 ", "Gris", "Gris 2", "Gris 3", "Gris 4", "Gris 5", "Gris 6"];
        $codigo_colores = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400",
            "#c0392b", "#bdc3c7", "#7f8c8d", "#fbfcfc", "#1b4f72", "#641e16", "#512e5f", "#4a235a", "#154360", "#1b4f72", " #0e6251", " #0b5345", " #186a3b", " #7d6608", " #7e5109", "#784212", "#6e2c00", "#626567", "#7b7d7d", "#626567", "#4d5656", " #424949", " #1b2631", "#17202a"];

        $response = [];
        for ($a = 0; $a < count($colores_esp); $a++) {

            $response[] = d("",
                ["class" => "colores", "style" => "background:{$codigo_colores[$a]}", "id" => $codigo_colores[$a]]);

        }
        return d(append($response), "colores_disponibles");

    }

    function get_view_sugerencias($servicios)
    {

        $r = [];
        $s = array_intersect_key($servicios, array_unique(array_column($servicios, 'id_servicio')));

        $imagenes = [];
        foreach ($s as $row) {


            $img = img([
                'src' => $row["url_img_servicio"],
                'alt' => $row["metakeyword"],
                "class" => "padding_5 top_10 hover_padding  "

            ]);

            $imagenes[] = d(a_enid($img, path_enid("producto", $row["id_servicio"])),
                "col-lg-3 producto_enid_img ");


        }

        $r[] = d(append($imagenes), "contenedor_sugeridos contenedor_sugeridos  row justify-content-center");
        return append($r);

    }
}