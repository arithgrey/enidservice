<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
    function get_format_colores($es_servicio ,$info_colores)
    {

        $r[] = div("+ AGREGAR COLORES",  "underline text_agregar_color top_30 bottom_30 strong", 1);
        $r[] = div($info_colores, 1);
        $r[] = get_btw(

            div("", ["id" => "seccion_colores_info"], 1)
            ,
            div("", ["class" => "place_colores_disponibles"], 1)
            ,
            "input_servicio_color"
        );

        return  append_data($r);
    }

    function get_format_enlace_venta_extra($flag_servicio, $url_ml)
    {

        if ($flag_servicio < 1) {

            $r[] = div(heading_enid("¿CUENTAS CON ALGÚN ENLACE DE PAGO EN MERCADO LIBRE?", 5), 1);
            $r[] = div(
                input([
                    "type" => "url",
                    "name" => "url_mercado_libre",
                    "class" => "form-control url_mercado_libre",
                    "value" => $url_ml
                ])
                , 1
            );

            $r[] = guardar("GUARDAR", ["class" => "btn_url_ml top_50"], 1);

            return div(div(append_data($r, "contenedor_pago_ml top_50"), " col-lg-12 top_50 "), 6);

        }


    }

    function get_format_venta_mayoreo($es_servicio, $text_envios_mayoreo, $venta_mayoreo)
    {


        if ($es_servicio < 1) {

            $r[] = get_btw(
                heading_enid($text_envios_mayoreo, 5)
                ,
                get_seccion_ventas_mayoreo($venta_mayoreo)
                ,
                "contenedor_inf_servicios seccion_ventas_mayoreo top_50"
            );

            return div(div(div(append_data($r), "top_50"), 12), 6);

        }

    }

    function get_format_utilidad($flag_servicio, $text_comision_venta, $utilidad)
    {

        $r[] = get_btw(
            heading_enid($text_comision_venta, 4)
            ,
            heading_enid("GANANCIA FINAL " . $utilidad . "MXN", 2)
            ,
            12
        );

        return div(div(div(append_data($r), "top_50 bottom_80"), "col-lg-12 shadow border top_30 bottom_80 padding_10 "), 12);
    }

    function get_seccion_ciclos_facturacion($ciclos, $id_ciclo_facturacion, $flag_servicio)
    {

        $x = [];
        if ($flag_servicio > 0) {


            $r[] = get_btw(
                heading_enid('CICLO DE FACTURACIÓN', 5)
                ,
                icon('fa fa-pencil text_ciclo_facturacion')
                ,
                "display_flex_enid"
                ,
                12


            );
            $r[] = div(get_nombre_ciclo_facturacion($ciclos, $id_ciclo_facturacion), "top_30");
            $r[] = get_btw(
                create_select_selected($ciclos,
                    "id_ciclo_facturacion",
                    "ciclo",
                    $id_ciclo_facturacion,
                    "ciclo_facturacion",
                    "ciclo_facturacion form-control"
                )
                ,
                guardar("GUARDAR", ['class' => 'btn_guardar_ciclo_facturacion']),
                "input_ciclo_facturacion display_none top_30"
            );


            $x[] = div(append_data($r), "contenedor_inf_servicios contenedor_inf_servicios_ciclo_facturacion top_30");
        }
        if (count($x) > 0) {
            return div(div(div(append_data($x), 12), "top_50"), 6);
        }


    }

    function get_seccion_uso_disponibilidad($existencia, $flag_nuevo, $flag_servicio)
    {


        $r[] = "";
        if ($flag_servicio < 1) {

            $r[] = div(get_seccion_articulos_disponibles($existencia), 6);
            $r[] = div(get_seccion_uso_producto($flag_nuevo), 6);


        }
        return append_data($r);

    }

    function get_seccion_articulos_disponibles($existencia)
    {

        $num = valida_text_numero_articulos($existencia);


        $r[] = get_btw(
            heading_enid('¿ARTÍCULOS DISPONIBLES?', 5, 1)
            ,
            div(icon('fa fa-pencil text_cantidad') . $num, "text_numero_existencia", 1)
            ,
            ""

        );


        $x[] = div(

            input([
                "type" => "number",
                "name" => "existencia",
                "class" => "existencia top_30",
                "required" => "",
                "value" => $existencia,
            ]),
            9

        );

        $x[] = div(guardar("GUARDAR", ["class" => "es_disponible btn_guardar_cantidad_productos top_30 "]), 3);


        $r[] = div(div(append_data($x), 13), "input_cantidad seccion_cantidad");

        return div(div(append_data($r), "top_50"), 12);
    }

    function get_seccion_uso_producto($flag_nuevo)
    {

        $usado = ["No", "Si"];


        $r[] = heading_enid("¿ES NUEVO?", 5, 1);
        $r[] = div(icon('fa fa-pencil text_nuevo') . $usado[$flag_nuevo], 1);

        $r[] = get_btw(

            div(select_producto_usado($flag_nuevo), "col-lg-9 top_30")
            ,
            div(guardar("GUARDAR", ["class" => "btn_guardar_producto_nuevo es_nuevo top_30 "], 0), 3)
            ,
            "input_nuevo seccion_es_nuevo  row"

        );
        return div(div(append_data($r), "top_50"), 12);

    }

    function create_vista($servicio)
    {


        $id_servicio = $servicio["id_servicio"];
        $metakeyword = $servicio["metakeyword"];
        $url_img_servicio = $servicio["url_img_servicio"];
        $in_session  =  $servicio["in_session"];
        $id_usuario = $servicio["id_usuario"];




            $p[] =
                div(
                    img([
                        'src' => $url_img_servicio,
                        'alt' => $metakeyword,
                        'style' => "max-height: 270px !important",
                        'class' => "padding_5 top_10 hover_padding"
                    ])
                );



        if ($in_session > 0) {




            $response[] = div(anchor_enid(
                append_data($p),
                [
                    "href" => get_url_servicio($id_servicio),

                ]
            ));
            $response[] = div(valida_botton_editar_servicio($in_session, $id_servicio, $id_usuario, $servicio["id_usuario_actual"]));

            $response =  div(append_data($response), "producto_enid d-flex flex-column justify-content-center col-lg-3  top_50 px-3 ");


        }else{
            $response = anchor_enid(
                append_data($p),
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



        $paginacion = addNRow(div($paginacion, 1));
        $r = [];
        foreach ($productos as $row) {
            $r[] = div($row);
        }
        $t[] = addNRow(icon("fa fa-search") . "Tu búsqueda de" . $busqueda . "(" . $num_servicios . "Productos)");
        $t[] = addNRow($paginacion);
        $t[] = append_data($r);

        $bloque[] = addNRow(div(append_data($t) , 1));
        $bloque[] = addNRow($paginacion);
        return append_data($bloque);

    }

    function get_text_costo_envio($es_servicio, $costo_envio)
    {

        $text = ($es_servicio == 0) ? div($costo_envio, ["class" => 'informacion_costo_envio'], 1) : "";
        return $text;

    }

    function get_session_color($color, $flag_servicio, $url_info_producto, $extra_color, $existencia, $in_session)
    {

        $response = get_btw(
            get_numero_colores($color, $flag_servicio, $url_info_producto, $extra_color)
            ,
            get_en_existencia($existencia, $flag_servicio, $in_session)
            ,
            ""
        );
        return $response;


    }

    function get_menu_config($num, $num_imagenes, $url_productos_publico)
    {

        $foto_config = ['href' => "#tab_imagenes", 'data-toggle' => "tab"];
        $precios_config = ['href' => "#tab_info_precios", 'data-toggle' => "tab"];

        $precios_inf = ['href' => "#tab_info_producto",
            'data-toggle' => "tab",
            'id' => 'tab_info_producto_seccion',
            'class' => 'detalle'
        ];

        $meta_inf = ['href' => "#tab_terminos_de_busqueda", 'data-toggle' => "tab"];

        $list = [
            li(anchor_enid(icon('fa fa-picture-o'), $foto_config), ["class" => valida_active($num, 1)]),
            li(anchor_enid(icon('fa fa-credit-card'), $precios_config), ["class" => valida_active($num, 4), "style" => valida_existencia_imagenes($num_imagenes)]),
            li(anchor_enid(icon('fa fa-info detalle'), $precios_inf), ["style" => valida_existencia_imagenes($num_imagenes)]),
            li(anchor_enid(icon('fa fa-fighter-jet menu_meta_key_words'), $meta_inf),
                ["class" => valida_active($num, 3), "style" => valida_existencia_imagenes($num_imagenes)]
            ),
            li(anchor_enid(icon("fa fa-shopping-bag") . "VER PUBLICACIÓN",
                [
                    "href" => $url_productos_publico,
                    "target" => "_blank",
                    "style" => 'background: #002565;color: white!important;'
                ]), ["style" => valida_existencia_imagenes($num_imagenes)]
            )
        ];

        return ul($list, ["class" => "nav nav-tabs"]);

    }

    function get_config_categorias($data, $param)
    {

        $nivel = "nivel_" . $data["nivel"];
        $config = [
            'class' => 'num_clasificacion ' . $nivel . ' selector_categoria ',
            'size' => '20'
        ];

        if ($param["is_mobile"] == 1) {

            $config = array(
                'class' => 'num_clasificacion ' . $nivel . ' 
                          num_clasificacion_phone selector_categoria '
            );
        }

        $info = $data["info_categorias"];
        $select = select_enid($info,
            "nombre_clasificacion",
            "id_clasificacion",
            $config);
        return $select;

    }

    function get_add_categorias($data, $param)
    {

        $data["padre"] = $param["padre"];
        $select = div(
            "AGREGAR NUEVO" . icon('fa fa-angle-double-right'),
            [
                "class" => "a_enid_black nueva_categoria_producto top_20",
                "id" => $data["padre"]
            ],
            1);
        return $select;
    }

    function get_estado_publicacion($status, $id_servicio)
    {

        $text = ($status == 1) ? "PAUSAR PUBLICACIÓN" : "ACTIVAR PUBLICACIÓN";

        return anchor_enid(
            $text,
            [
                "id" => $id_servicio,
                "status" => $status,
                "class" => 'button_enid_eleccion activar_publicacion'
            ]);


    }

    function get_url_venta($extra)
    {
        return "http://enidservice.com/inicio/producto/?producto=" . $extra;
    }

    function une_data($data_servicios, $data_intentos_entregas)
    {

        $new_data = [];
        $response = [];
        $a = 0;
        foreach ($data_servicios as $row) {

            $new_data[$a] = $row;
            $id_servicio = $row["id_servicio"];
            $b = 0;
            foreach ($data_intentos_entregas as $row2) {
                if ($row2["id_servicio"] == $id_servicio) {
                    $new_data[$a]["intentos_compras"] = $row2;
                    unset($data_intentos_entregas[$b]);
                    break;
                }
                $b++;
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

                $response[$z]["intentos"] = $row["intentos_compras"]["intentos"];
                $response[$z]["punto_encuentro"] = $row["intentos_compras"]["punto_encuentro"];
                $response[$z]["mensajeria"] = $row["intentos_compras"]["mensajeria"];
                $response[$z]["visita_negocio"] = $row["intentos_compras"]["visita_negocio"];

            } else {

                $response[$z]["intentos"] = 0;
                $response[$z]["punto_encuentro"] = 0;
                $response[$z]["mensajeria"] = 0;
                $response[$z]["visita_negocio"] = 0;
            }

            $z++;
        }
        return $response;
    }

    function create_dropdown_button($id_imagen, $principal = 0)
    {

        $text = ($principal == 0) ? "Definir como principal" : "Imagen principal";
        $extra_principal = ($principal == 0) ? "" : "blue_enid";

        $definir = div(
            icon('fa fa-star',
                [

                    "class" => "dropdown-item  " . $extra_principal
                ]
            ) . $text, ["class" => "top_20 cursor_pointer imagen_principal", "id" => $id_imagen]);


        $quitar =
            div(
                icon('fa fa-times',
                    [
                        "class" => "dropdown-item "
                    ]
                ) . "Quitar"
                , ["class" => "top_20 cursor_pointer foto_producto", "id" => $id_imagen]);


        $x[] = div(icon("fa fa fa-pencil"), ["class" => "dropdown-toggle "]);
        $x[] = ul([$definir, $quitar], ["class" => "dropdown-menu ", "style" => "height:100px"]);
        $r[] = div(append_data($x), ["class" => "dropdown "]);
        return append_data($r);


    }

    function valida_tipo_promocion($param)
    {
        $tipo = ($param[0]["flag_servicio"] == 1) ? "SERVICIO" : "PRODUCTO";
        return $tipo;
    }

    function get_nombre_ciclo_facturacion($ciclos, $id_ciclo)
    {
        $response = "";
        foreach ($ciclos as $row) {
            $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
            if ($id_ciclo_facturacion == $id_ciclo) {
                $response = $row["ciclo"];
            }
        }
        return $response;
    }

    function create_colores_disponibles($text_colores)
    {

        $arreglo_colores = explode(",", $text_colores);
        $r = [];
        for ($a = 0; $a < count($arreglo_colores); $a++) {

            $codigo_color = $arreglo_colores[$a];
            $contenido = icon('fa fa-times elimina_color', ["id" => $codigo_color]) . " " . $codigo_color;
            $r[] = div($contenido, ["style" => "background:" . $codigo_color . ";color:white;padding:3px;"]);
        }
        return div(append_data($r), ["id" => 'contenedor_colores_disponibles']);
    }

    function valida_text_numero_articulos($num)
    {

        $text = div("Alerta", ["class" => 'mjs_articulo_no_disponible']) . "este artúculo no se encuentra disponible, agregar nuevo";
        if ($num > 0) {
            $s1 = $num . " Artículo disponible";
            $s2 = $num . " Artículos disponibles";
            $text = ($num > 1) ? $s1 : $s2;
        }
        return $text;
    }

    function agrega_data_servicio($data, $key, $valor)
    {

        $data[$key] = $valor;
        return $data;
    }

    function evalua_utilidad_mas_envio($flag_envio_gratis, $costo_envio, $utilidad)
    {

        if ($flag_envio_gratis == 1) {
            return $utilidad - $costo_envio;
        } else {
            return $utilidad;
        }
    }

    function get_valor_envio($costo_envio, $flag_envio_gratis)
    {
        $costo = ($flag_envio_gratis == 1) ? -100 : 100;
        return $costo;
    }

    function select_producto_usado($valor_actual)
    {

        $usado = ["No", "Si"];
        $r[] = "<select class='form-control producto_nuevo'>";
        for ($z = 0; $z < count($usado); $z++) {
            if ($z == $valor_actual) {
                $r[] = "<option value='" . $z . "' selected>" . $usado[$z] . "</option>";
            } else {
                $r[] = "<option value='" . $z . "'>" . $usado[$z] . "</option>";
            }
        }
        $r[] = "</select>";
        $response = append_data($r);
        return $response;
    }

    function get_producto_usado($tipo)
    {
        $usado = ["No", "Si"];
        return $usado[$tipo];
    }

    function create_url_procesar_compra($producto_text,
                                        $id_servicio,
                                        $total,
                                        $ciclo_facturacion,
                                        $num_ciclos,
                                        $dominio = "",
                                        $extension_dominio = "")
    {


        $url_procesar_compra =
            "../procesar/?producto=" . $producto_text . "&plan=" . $id_servicio . "&ciclo_facturacion=" .
            $ciclo_facturacion . "&num_ciclos=" . $num_ciclos . "&total=" . $total . "&dominio=" . $dominio . "&extension_dominio=" . $extension_dominio;
        return $url_procesar_compra;

    }

    function create_table_servicios($servicios)
    {

        $list = "";
        $z = 1;
        $extra = "";
        foreach ($servicios as $row) {

            $id_servicio = $row["id_servicio"];
            $nombre_servicio = $row["nombre_servicio"];
            $status = $row["status"];
            $especificacion = icon('servicio fa fa-file-text-o', ["id" => $id_servicio]);
            $text_estatus = ($status == 0) ? "Inactivo" : "Activo";


            $list .= "<tr>";
            $list .= get_td($especificacion, ["class" => 'especificacion_servicio']);
            $list .= get_td($nombre_servicio, $extra);
            $list .= get_td($text_estatus, ["class" => 'text-center strong']);
            $list .= "</tr>";
            $z++;
        }
        return $list;

    }

    function scroll_terminos($num_terminos)
    {

        $extra = ($num_terminos > 3) ? "scroll_terms" : "";
        return $extra;
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
                # code...
                break;
        }
        return $nuevo_text;
    }

    function is_servicio($row)
    {

        $flag_precio_definido = 0;
        $flag_envio_gratis = $row["flag_envio_gratis"];
        $flag_servicio = $row["flag_servicio"];
        $extra = "";

        switch ($flag_servicio) {
            case 1:

                if ($flag_precio_definido == 1) {

                    $extra = "";
                } else {
                    $extra = "A convenir";
                }
                break;
            case 0:

                $extra = ($flag_envio_gratis == 1) ? "Envios gratis a todo México" : "Envios a todo México";

                break;
            default:
                break;
        }
        return $extra;
    }

    function get_precio_producto($url_info_producto, $precio)
    {

        $precio = div(div(anchor_enid($precio . 'MXN', ["href" => $url_info_producto]), ["class" => "texto_precio"]), 1);
        return $precio;

    }

    function get_numero_colores($color, $flag_servicio)
    {

        $response = "";
        if ($flag_servicio != 1) {
            $arreglo_colores = explode(",", $color);
            $num_colores = count($arreglo_colores);
            if ($num_colores > 0) {
                $response = ($num_colores > 1) ? $num_colores . " colores" : $num_colores . " color";
            }
        }
        return $response;
    }


    function get_en_existencia($existencia, $flag_servicio, $in_session)
    {

        $response = "";
        if ($flag_servicio == 0) {
            $response = informacion_existencia_producto($existencia, $in_session);
        }
        return $response;
    }

    function informacion_existencia_producto($existencia, $in_session)
    {

        $response = "";
        if ($in_session > 0) {
            $response = ($existencia > 0) ? span($existencia . " En existencia ") : span("INVENTARIO LIMITADO");

        }
        return $response;
    }

    function muestra_vistas_servicio($in_session, $vistas)
    {

        $response = ($in_session == 1) ? div($vistas . " personas alcanzadas") : "";
        return $response;
    }

    function valida_botton_editar_servicio($in_session, $id_servicio, $id_usuario, $id_usuario_registro_servicio)
    {

        $response = "";
        if ($in_session > 0) {
            if ($id_usuario == $id_usuario_registro_servicio) {
                $response = icon("top_40  bottom_40 servicio fa fa-pencil", ["id" => $id_servicio]);
            }
        }
        return $response;

    }

    function get_rango_entrega($id_perfil, $actual, $attributes = '', $titulo, $minimo = 1, $maximo = 10)
    {


        $response = "";

        if ($id_perfil == 3) {

            $att = add_attributes($attributes);
            $titulo = div(heading_enid($titulo, 5), 1);
            $select[] = "<select " . $att . ">";

            for ($a = $minimo; $a < $maximo; $a++) {
                if ($a == $actual) {
                    $select[] = "<option value='" . $a . "' selected>" . $a . "</option>";
                } else {
                    $select[] = "<option value='" . $a . "'>" . $a . "</option>";
                }

            }

            $select[] = "</select>";
            $select[] = div(place("response_tiempo_entrega"), 12);
            $select = append_data($select);

            $response = get_btw(
                div($titulo, 1)
                ,
                div($select, 1)
                ,
                "top_30"

            );

        }

        return div($response, 12);

    }

    function get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping)
    {


        $response = "";
        if ($id_perfil == 3) {


            $icono = div(icon("fa fa fa-pencil"), ["class" => "text_link_dropshipping", "onclick" => "muestra_cambio_link_dropshipping('" . $id_servicio . "')"], 1);
            $titulo = div(heading_enid("LINK DROPSHIPPING", 5), 1);
            $titulo = get_btw($titulo, $icono, "display_flex_enid");


            $x[] = div(
                input([
                    "class" => "form-control ",
                    "name" => "link_dropshipping",
                    "required" => "true",
                    "placeholder" => "Link de compra",
                    "type" => "url",
                    "value" => $link_dropshipping
                ]),
                1
            );

            $x[] = input_hidden(["name" => "servicio", "value" => $id_servicio]);
            $x[] = div(guardar("GUARDAR", ["class" => "top_30"]), 1);
            $x[] = div(place("response_link_dropshipping"), 1);


            if (strlen($link_dropshipping) >  10){

                $r[] = anchor_enid("Link" , ["href"=> $link_dropshipping , "class"=> "underline" , "target" => "_black"]);
            }

            $r[] = div(append_data($x), "input_link_dropshipping");


            $select = append_data($r);
            $response = get_btw($titulo, $select, "top_30 ");

        }
        return $response;

    }

    function sumatoria_array($array, $key)
    {

        return array_sum(array_column($array, $key));
    }

    function agregar_imgs()
    {

        $r[] = div(div(
            anchor_enid(
            icon('fa fa fa-times white'),
            [
                'class' => 'btn_enid_blue cancelar_carga_imagen cancelar_img pull-right white bottom_30',
            ]
            , 1
        ),
            4
            ,
            1
        ),1);

        $x[] = div(heading_enid("AGREGAR IMAGENES", 5) , 4,1);
        $x[] = div(place("place_img_producto"),4,1);
        $r[] = div(append_data($x), 1, 4);
        return div(append_data($r), "contenedor_agregar_imagenes");

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
        $url = "https://www.youtube.com/embed/" . $text;
        return $url;

    }

    function get_heading_servicio($tipo_promocion, $nuevo_nombre_servicio, $servicio)
    {

        $response = [];

        $ie_nombre = input([
            "type" => "text",
            "name" => "q2",
            "class" => "nuevo_producto_nombre",
            "onkeyup" => "transforma_mayusculas(this)",
            "value" => get_campo($servicio, 'nombre_servicio'),
            "required" => true],
            1);

        $h = append_data([icon('fa fa-pencil text_nombre_servicio'), $tipo_promocion, $nuevo_nombre_servicio]);

        $respons[] = heading_enid($h, 4);
        $respons[] = form_open("", ['class' => 'form_servicio_nombre_info input_nombre_servicio_facturacion ']);
        $respons[] = input_hidden(["name" => "q", "value" => "nombre_servicio"], 1);
        $respons[] = div($ie_nombre, ['class' => 'col-lg-9']);
        $respons[] = div(guardar("GUARDAR", ["class" => "info_guardar_nombre_servicio"], 1), ['class' => 'col-lg-3']);
        $respons[] = form_close();
        $response = addNRow(append_data($response));
        return $response;

    }

    function get_form_youtube($valor_youtube)
    {

        $r = [];
        $i = input([
            "type" => "hidden",
            "name" => "q",
            "value" => "url_vide_youtube"
        ],
            1);


        $p = div("", ["class" => "place_url_youtube"], 1);

        array_push($r, form_open("", ["class" => "form_servicio_youtube input_url_youtube contenedor_info_youtube"]));

        array_push($r, input([
            "type" => "url",
            "name" => "q2",
            "class" => 'url_youtube',
            "value" => $valor_youtube,
            "required" => true
        ], 1));

        array_push($r, div($i . $p, ['class' => 'col-lg-9']));
        array_push($r, div(guardar("GUARDAR", ["class" => "guardar_video_btn"], 1), ['class' => 'col-lg-3']));
        array_push($r, form_close());

        return append_data($r);

    }

    function get_form_descripcion($nueva_descripcion)
    {

        $r = [];
        array_push($r, form_open("", ["class" => "top_30 form_servicio_desc input_desc_servicio_facturacion"]));
        array_push($r, input([
                "type" => "hidden",
                "name" => "q",
                "value" => "descripcion"
            ], 1)
        );

        array_push($r, div("-" . $nueva_descripcion, ["id" => "summernote"], 1));
        array_push($r, div(guardar("GUARDAR", ["class" => "btn_guardar_desc"], 1)));
        array_push($r, form_close());
        return append_data($r);
    }

    function get_form_rango_entrega($es_servicio, $id_perfil, $stock)
    {


        if ($es_servicio < 1 && $id_perfil == 3) {

            $r = [];
            array_push($r, form_open("", ["class" => "form_stock"]));
            array_push($r, get_rango_entrega(
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
            return div(append_data($r), 6);
        }


    }

    function get_form_link_drop_shipping($id_perfil, $id_servicio, $link_dropshipping)
    {

        $r = [];
        array_push($r, form_open("", ["class" => "form_dropshipping text-right"]));
        array_push($r, get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping));
        array_push($r, form_close());
        return div(append_data($r), 12);

    }

    function get_seccion_compras_casa($flag_servicio, $entregas_en_casa)
    {
        $titulo_compra_en_casa = ($flag_servicio == 1) ? "OFRECES SERVICIO EN TU NEGOCIO?" : "¿CLIENTES TAMBIÉN PUEDEN RECOGER SUS COMPRAS EN TU NEGOCIO?";
        $atencion_en_casa = ($flag_servicio == 1) ? "NO" : "NO, SOLO HAGO ENVÍOS";
        $extra_extrega_casa_si = valida_activo_entregas_en_casa(1, $entregas_en_casa);
        $extra_extrega_casa_no = valida_activo_entregas_en_casa(0, $entregas_en_casa);

        $confirmar = anchor_enid(
            "SI",
            [
                "id" => '1',
                "class" => 'button_enid_eleccion entregas_en_casa_si entregas_en_casa ' . $extra_extrega_casa_si
            ]
        );


        $omitir = anchor_enid(
            $atencion_en_casa,
            [
                "id" => '0',
                "class" => 'button_enid_eleccion entregas_en_casa_no entregas_en_casa ' . $extra_extrega_casa_no
            ]


        );

        $r[] = div(heading_enid($titulo_compra_en_casa, 5), 1);
        $r[] = get_btw($confirmar, $omitir, "top_30 ");
        return div(div(div(append_data($r), "top_50"), 1), 12);


    }

    function get_seccion_telefono_publico($has_phone, $telefono_visible, $activo_visita_telefono, $baja_visita_telefono, $flag_servicio)
    {
        $ver_telefono = ($flag_servicio == 1) ? "¿PERSONAS PUEDEN VER TU NÚMERO TELEFÓNICO PARA SOLICITARTE MÁS INFORMES?" : "¿PERSONAS PUEDEN SOLICITARTE MÁS INFORMES POR TELÉFONO?";


        $visible = anchor_enid(
            "SI",
            [
                'id' => 1,
                'class' => 'button_enid_eleccion telefono_visible ' . $activo_visita_telefono
            ]

        );


        $no_visible = anchor_enid(
            "NO, OCULTAR MI TELÉFONO",
            [
                'id' => 0,
                'class' => 'button_enid_eleccion  no_tel telefono_visible ' . $baja_visita_telefono
            ]

        );

        $r[] = div(heading_enid($ver_telefono, 5), "top_50", 1);

        $r[] = get_btw(
            $visible
            ,
            $no_visible
            ,
            "top_40 "
        );
        $r[] = text_agregar_telefono($has_phone, $telefono_visible);
        return div(append_data($r), 12);


    }

    function get_configuracion_contra_entrega($es_servicio, $contra_entrega, $id_servicio)
    {

        if ($es_servicio < 1) {

            $v = valida_activo_vista_telefono($contra_entrega, 1);
            $v2 = valida_activo_vista_telefono($contra_entrega, 0);
            $si =
                anchor_enid(
                    "SI",
                    [
                        'id' => 1,
                        'class' => 'button_enid_eleccion  ' . $v,
                        'onClick' => "contra_entrega(1, '{$id_servicio}')"
                    ]

                );

            $no = anchor_enid("NO, SOLO ENVÍOS A DOMICILIO POR PAQUETERÍA",
                [
                    'id' => 0,
                    'class' => 'button_enid_eleccion ' . $v2,
                    'onClick' => "contra_entrega(0, '{$id_servicio}')"
                ]
            );

            $r[] = heading_enid("¿VENDES ESTA ARTÍCULO CONTRA ENTREGA?", 5, "top_30");
            $r[] = get_btw($si, $no, "top_30");
            return div(div(div(append_data($r), "top_50"), 12), 6);


        }

    }


    function get_seccion_ventas_mayoreo($venta_mayoreo)
    {

        $activo = valida_activo_ventas_mayoreo(1, $venta_mayoreo);
        $baja = valida_activo_ventas_mayoreo(0, $venta_mayoreo);

        $mayoreo
            = anchor_enid("SI",
            [
                "id" => '1',
                "class" => 'button_enid_eleccion venta_mayoreo ' . $activo
            ]);


        $menudeo = anchor_enid("NO",
            [
                "id" => '0',
                "class" =>
                    'button_enid_eleccion venta_mayoreo ' . $baja
            ]
        );

        return get_btw($mayoreo, $menudeo, "ventas_mayoreo display_flex_enid top_30");

    }

    function get_form_tags($id_servicio, $metakeyword_usuario)
    {

        $r = [];

        $meta_format = create_meta_tags($metakeyword_usuario, $id_servicio);
        $r[] = div(div($meta_format,  "info_meta_tags", 1),"top_30 bottom_30");
        $r[] = form_open("", ["class" => "form_tag", "id" => "form_tag"]);
        $r[] = input([
            "type" => "hidden",
            "name" => "id_servicio",
            "class" => "id_servicio",
            "value" => $id_servicio
        ]);
        $in = get_btw(
            div(heading_enid("AGREGAR" , 5),2),
            div(input([
            "type" => "text",
            "name" => "metakeyword_usuario",
            "required" => true,
            "placeholder" => "Palabra como buscan tu producto",
            "class" => "metakeyword_usuario"
            ]),10)
            ,
            "agregar_tags "
        );
        $r[] = $in;
        $r[] = form_close(place("contenedor_sugerencias_tags"));
        return append_data($r);


    }

    function get_form_costo_unidad($precio, $flag_servicio, $costo_envio)
    {


        $text_precio_unidad = icon('fa fa-pencil') . "PRECIO POR UNIDAD: $" . $precio . "MXN";
        $r = [];

        array_push($r, heading_enid("PRECIO POR UNIDAD", 5));

        array_push($r, anchor_enid(
                $text_precio_unidad,
                ["class" => "a_precio_unidad text_costo informacion_precio_unidad"],
                1)
        );

        array_push($r, form_open("", ["class" => "form_costo input_costo contenedor_costo top_30"]));

        $in = get_btw(input([
            "type" => "number",
            "name" => "precio",
            "step" => "any",
            "class" => "form-control ",
            "value" => $precio
        ]), div("MXN", ["class" => "mxn"]), "display_flex_enid");

        array_push($r, $in);


        array_push($r, guardar("GUARDAR", ["class" => "top_30"]));
        array_push($r, form_close(place("place_registro_costo")));


        $response[] = append_data($r);

        if ($flag_servicio < 1) {

            $r = [];

            $r[] = heading_enid("COSTO DE ENVÍO",
                5,
                [
                    'class' => 'costo_envio_text top_50'
                ],
                1
            );


            $r[] = div(
                icon('fa fa fa-pencil') . $costo_envio["text_envio"]["ventas_configuracion"]
                ,
                "text_info_envio top_30"
                ,
                1
            );


            $r[] = div(
                $costo_envio["text_envio"]["cliente"]
                ,
                "text_info_envio text_info_envio_editable top_30"
            );


            $response[] = div(append_data($r), "contenedor_informacion_envio seccion_informacion_envio");

            $opt[] = array(
                "text" => "NO, QUE SE CARGUE AL CLIENTE",
                "v" => 0
            );
            $opt[] = array(
                "text" => "SI - YO PAGO EL ENVIO",
                "v" => 1
            );


            $r = [];
            $r[] = div(heading_enid("¿EL PRECIO INCLUYE ENVÍO?", 5, 1), "top_50");

            $r[] = get_btw(
                div(create_select($opt, "input_envio_incluido", "input_envio_incluido form-control top_30", "input_envio_incluido", "text", "v"), 9)
                ,
                div(guardar('GUARDAR', ["class" => "btn_guardar_envio top_30 "]), 3)
                ,
                "row top_30"

            );

            $response[] = div(div(append_data($r), "input_envio config_precio_envio"));

        }
        $response = div(div(div(append_data($response), 12), "top_50"), 6);
        return $response;

    }

    function get_tabla_colores()
    {

        $colores_esp = ["Turquesa", "Emerland", "Peterriver", "Amatista", "Wetasphalt", "Mar verde", "Nefritis", "Belizehole", "Glicinas", "Medianoche azul", "Girasol", "Zanahoria", "Alizarina", "Nubes", "Hormigón", "Naranja", "Calabaza", "Granada", "Plata", "Amianto", "Blanco", "Blue", "Cafe", "Morado", "Morado 2", "Azul", "Azul", "Verde", "Verde", "Verde 2", "Amarillo", "Amarillo 2", "Amarillo 3", "Amarillo 4", "Amarillo 5 ", "Gris", "Gris 2", "Gris 3", "Gris 4", "Gris 5", "Gris 6"];
        $codigo_colores = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400",
            "#c0392b", "#bdc3c7", "#7f8c8d", "#fbfcfc", "#1b4f72", "#641e16", "#512e5f", "#4a235a", "#154360", "#1b4f72", " #0e6251", " #0b5345", " #186a3b", " #7d6608", " #7e5109", "#784212", "#6e2c00", "#626567", "#7b7d7d", "#626567", "#4d5656", " #424949", " #1b2631", "#17202a"];

        $response = [];
        for ($a = 0; $a < count($colores_esp); $a++) {

            $response[] = div("",
                ["class" => "colores", "style" => "background:{$codigo_colores[$a]}", "id" => $codigo_colores[$a]]);

        }
        return div(append_data($response), ["class" => "colores_disponibles"]);

    }

    function get_view_sugerencias($servicios, $is_mobile)
    {


        $r = [];
        $imagenes = [];
        foreach ($servicios as $row) {


            $id_servicio = $row["id_servicio"];
            $url_img = $row["url_img_servicio"];
            $metakeyword = $row["metakeyword"];
            $url_info_producto = "../producto/?producto=" . $id_servicio;


            $img = img([
                'src' => $url_img,
                'alt' => $metakeyword,
                "class" => "padding_5 top_10 hover_padding  "

            ]);
            $imagenes[] = div(anchor_enid($img, ["href" => $url_info_producto]), ["class" => "col-lg-3 producto_enid_img   "]);

        }
        $r[] = div(append_data($imagenes),
            [
                "class" => "contenedor_sugeridos contenedor_sugeridos "
            ]);
        return append_data($r);

    }

}