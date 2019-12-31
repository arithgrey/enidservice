<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_ventas($data)
    {

        $id_perfil = $data["id_perfil"];
        $is_mobile = is_mobile();
        $action = $data["action"];
        $top_servicios = $data["top_servicios"];
        $considera_segundo = $data["considera_segundo"];

        $t[] = menu($id_perfil, $is_mobile, $action);
        $t[] = btw(
            _titulo("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA")
            ,
            top_ventas($top_servicios)
            ,
            "contenedor_top " . ($action == 1) ? " display_none " : " "
        );

        $r[] = d($t, 'col-md-2 menu');

        $z[] = tab_seccion(
            articulos_venta($data["list_orden"]),
            'tab_servicios',
            valida_active_tab(0, $action, $considera_segundo)
        );
        $z[] = tab_seccion(

            puntos_venta()
            ,
            'tab_puntos_venta',
            valida_active_tab(0, $action, $considera_segundo)
        );
        $z[] = tab_seccion(
            form_ventas($data["ciclo_facturacion"], $data["error_registro"], $is_mobile),
            'tab_form_servicio',
            valida_active_tab(1, $action),
            [
                'class' => 'mt-5 mt-md-0'
            ]
        );


        $r[] = tab_content($z, 10);
        $r[] = d(top_articulos($top_servicios, $is_mobile), 2);
        $r[] = get_formar_hiddens($is_mobile, $action, $data["extra_servicio"]);

        return append($r);
    }


    function form_ventas($ciclo_facturacion, $error_registro, $is_mobile)
    {


        $r[] = form_open('',
            [
                'class' => "form_nombre_producto col-lg-6 col-lg-offset-3 p-0",
                "id" => 'form_nombre_producto'
            ]
        );

        $r[] = _titulo('¿Qué anunciamos?');
        $r[] = flex(

            a_enid('UN PRODUCTO',
                [
                    "class" => "tipo_promocion tipo_producto easy_select_enid button_enid_eleccion_active",
                    "id" => 0,
                ]
            )
            ,
            a_enid(
                "UN SERVICIO",
                [
                    "class" => "tipo_promocion tipo_servicio",
                    "id" => 1
                ]
            )
            ,
            'mt-5 mt-md-4 mb-5 top_tipo_publicacion'
        );


        $nombre = input_frm('mt-5',
            span("Nombre del artículo", 'text-uppercase'),
            [
                "id" => "nombre_producto",
                "name" => "nombre",
                "class" => "nuevo_producto_nombre",
                "type" => "text",
                "onkeyup" => "transforma_mayusculas(this)",
                "required" => true,
                "placeholder" => "Nombre de tu artículo o servicio",
                "no_validar" => 1
            ]
        );


        $seccion_precio = d(_d(

            label(
                'Precio MXN',

                'text-uppercase h5 black strong'

            ),

            input(
                [
                    "id" => "costo",
                    "class" => "costo precio border-top-0 border-right-0 border-left-0 border_bottom_big",
                    "name" => "costo",
                    "required" => true,
                    "step" => "any",
                    "type" => "number",
                    "placehorder" => "880",
                ], 0, 0
            )

        ), 'contenedor_precio mt-5 mt-md-3');


        $seccion_ciclo_facturacion = d(
            [
                h(
                    "CICLO DE FACTURACIÓN",
                    5, 'h5 strong'
                )
                ,
                create_select(
                    $ciclo_facturacion,
                    "ciclo",
                    "form-control ciclo_facturacion ci_facturacion top_10",
                    "ciclo",
                    "ciclo",
                    "id_ciclo_facturacion",
                    1
                )

            ]
            ,
            "contenedor_ciclo_facturacion d-none"
        );
        $r[] = _d(
            $nombre,
            $seccion_precio,
            $seccion_ciclo_facturacion
        );


        $r[] = d($error_registro, "extra_precio mt-3");
        $r[] = btn("Continuar", ['class' => 'siguiente_btn mt-5']);
        $r[] = form_close();
        $re[] = d($r, "contenedor_agregar_servicio_form ");
        $re[] = get_selector_categoria($is_mobile);
        return append($re);


    }


    function top_ventas($top)
    {

        $response = [];
        if (es_data($top)) {

            foreach ($top as $row) {

                $nombre = $row["nombre_servicio"];
                $articulo = (strlen($nombre) > 18) ? substr($nombre, 0, 18) . "..." : $nombre;

                $link =
                    a_enid($articulo,
                        [
                            'href' => path_enid("producto", $row['id_servicio']),
                            'class' => 'black'
                        ], 1
                    );


                $response[] = ajustar($link, $row["vistas"]);

            }
        }
        return append($response);


    }


    function articulos_venta($list_orden)
    {


        $r[] = d(_titulo("lo que vendes"),'titulo_seccion');
        $r[] = d(get_format_busqueda($list_orden), "contenedor_busqueda_articulos");
        $r[] = place("place_servicios");
        return append($r);

    }


    function puntos_venta()
    {

        $r[] = h("PUNTOS DE VENTA", 3);
        $r[] = d(place("place_puntos_venta top_50"), 1);
        return append($r);

    }


    function get_format_busqueda($list_orden)
    {


        $r[] = input_frm(4, 'Nombre del producto o servicio', [
            "id" => "textinput",
            "name" => "textinput",
            "placeholder" => "Nombre del producto o servicio",
            "class" => "form-control input-sm q_emp",
            "onkeyup" => "onkeyup_colfield_check(event);"
        ]);

        $r[] = d(list_orden($list_orden), 4);

        return d($r, 'd-md-flex row mt-5 mb-5');

    }


    function list_orden($list_orden)
    {

        $r[] = '<select class="form-control" name="orden" id="orden">';
        $a = 1;
        foreach ($list_orden as $row) {
            $r[] = '<option value="' . $a . '">';
            $r[] = $row;
            $r[] = '</option>';
            $a++;
        }
        $r[] = '</select>';
        return append($r);

    }


    function top_articulos($top, $is_mobile)
    {

        $response = "";
        if (es_data($top) && $is_mobile > 0) {

            $r = [];
            foreach ($top as $row):

                $r[] = icon("fa fa-angle-right");
                $articulo = (trim(strlen($row["nombre_servicio"])) > 22) ? substr($row["nombre_servicio"], 0, 22) . "..." : strlen($row["nombre_servicio"]);
                $r[] = $articulo;
                $r[] = d(span($row["vistas"], "a_enid_black_sm_sm"),
                    [
                        "class" => "pull-right",
                        "title" => "Personas que han visualizado este  producto"
                    ]);


                $r[] = a_enid(append($r), path_enid("producto", $row['id_servicio']));

            endforeach;


            if (es_data($top)):
                array_pop($r, h("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA", 2));
            endif;

            $response = d(append($r), "card contenedor_articulos_mobil");

        }
        return $response;
    }


    function get_selector_categoria($is_mobile)
    {


        $r[] = _titulo('¿en qué categoría se encuentra tu artículo?');
        $r[] = hr();


        $cerrar = d(
            format_link("",
                [
                    'class' => "fa fa-times cancelar_registro fa-2x"
                ]
            ), 'col-xs-2 col-sm-1 ml-auto');
        $r[] = d($cerrar, 13);


        $r[] = places();
        return d($r, "contenedor_categorias_servicios d-none");

    }


    function get_formar_hiddens($is_mobile, $action, $extra_servicio)
    {


        $r[] = hiddens(
            [

                "name" => "version_movil",
                "value" => $is_mobile,
                "class" => 'is_mobile'
            ]
        );
        $r[] = hiddens(
            [

                "value" => $action,
                "class" => "q_action"
            ]
        );
        $r[] = hiddens(
            [

                "value" => $extra_servicio,
                "class" => "extra_servicio"
            ]
        );


        return append($r);

    }


    function places()
    {

        $class = 'col-md-3 col-sm-12';
        return d(
            [
                d(place("primer_nivel_seccion"), $class),
                d(place("segundo_nivel_seccion"), $class),
                d(place("tercer_nivel_seccion"), $class),
                d(place("cuarto_nivel_seccion"), $class),
                d(place("quinto_nivel_seccion"), $class),
                d(place(_text("sexto_nivel_seccion ", $class)))
            ], 'd-md-flex align-items-center '
        );
    }


    function valida_action($param, $key)
    {

        $action = 0;
        if (prm_def($param, $key) !== 0) {
            $action = $param[$key];
            switch ($action) {
                case 'nuevo':
                    $action = 1;
                    break;

                case 'lista':
                    $action = 0;
                    break;
                case 'editar':
                    $action = 2;
                    break;
                default:
                    break;
            }
        }
        return $action;
    }


    function valida_active_tab($seccion, $valor_actual, $considera_segundo = 0)
    {

        return ($considera_segundo == 0) ? (($seccion == $valor_actual) ? 1 : 0) : 1;

    }


    function menu($perfil, $is_mobile, $action)
    {

        $punto_venta = tab(
            text_icon('fa fa-map', " puntos de entrega "),
            "#tab_puntos_venta",
            [
                'class' => "puntos_venta"
            ]
        );

        $venta = tab(
            text_icon("fa fa-shopping-cart", "en venta"),
            "#tab_servicios",
            [
                'class' => "black  btn_serv",
            ]
        );
        if (!$is_mobile) {

            $list[] = li(
                a_enid(
                    "vender"
                    ,
                    [
                        "href" => path_enid('vender_nuevo'),
                        "class" => "agregar_servicio btn_agregar_servicios 
                        text-uppercase black"
                    ]
                ),
                _text(valida_active_tab('nuevo', $action), " ")
            );

            $list[] = li(
                $punto_venta,
                _text(valida_active_tab('puntos_venta', $action), " ")
            );

            $list[] =
                li(
                    $venta,
                    [
                        "class" =>
                            _text(
                                'li_menu_servicio btn_servicios ',
                                valida_active_tab('lista', $action)
                            ),
                        "id" => 0,
                    ]
                );


            if ($perfil != 20 && $perfil > 0) {

                $link_articulos_venta = tab(
                    text_icon("fa fa-globe", " articulos en venta"),
                    "#tab_servicios",
                    [
                        'class' => "black  btn_serv",
                        "id" => 1
                    ]

                );
                $list[] =
                    li(
                        $link_articulos_venta
                        ,
                        [
                            "class" => _text(
                                'li_menu_servicio btn_servicios ',
                                valida_active_tab('lista', $action)
                            ),
                            "id" => 1,

                        ]
                    );
            }
            $response = ul(append($list), ["class" => "nav tabs "]);
        } else {


            $link = tab("", "#tab_servicios",
                [

                    'class' => "black  btn_serv"
                ]
            );

            $list[] = li(
                a_enid(
                    "",
                    [
                        "href" => "../planes_servicios/?action=nuevo",
                        "class" => "agregar_servicio btn_agregar_servicios"
                    ]
                ),
                ["class" => valida_active_tab('nuevo', $action)]
            );
            $list[] = li(
                $link,
                _text(
                    "li_menu li_menu_servicio btn_servicios ",
                    valida_active_tab('lista', $action)
                )

            );

            $response = ul($list, "nav tabs");

        }
        return $response;
    }


}
