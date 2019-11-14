<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_ventas($data)
    {

        $id_perfil = $data["id_perfil"];
        $is_mobile = $data["is_mobile"];
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
        $r[] = d(append($t), 2);

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
            valida_active_tab(1, $action)
        );

        $r[] = tab_content($z, 10);
        $r[] = d(top_articulos($top_servicios, $is_mobile), 2);
        $r[] = get_formar_hiddens($is_mobile, $action, $data["extra_servicio"]);

        return append($r);
    }


    function form_ventas($ciclo_facturacion, $error_registro, $is_mobile)
    {

        $r[] = h("DA A CONOCER TU PRODUCTO Ó SERVICIO", 3, 1);
        $r[] = form_open('', ['class' => "form_nombre_producto ", "id" => 'form_nombre_producto']);
        $link_producto = a_enid('UN PRODUCTO',
            [
                "class" => "tipo_promocion tipo_producto easy_select_enid mr-1",
                "id" => "0",
                "style" => "color: blue;"
            ]
        );
        $link_servicio = a_enid(
            "UN SERVICIO",
            [
                "class" => "tipo_promocion tipo_servicio",
                "id" => "1"
            ]
        );
        $selector_producto_servicio = flex(

            $link_producto,
            $link_servicio

        );


        $r[] = dd(
            _titulo("¿QUÉ DESEAS ANUNCIAR?"),
            $selector_producto_servicio,
            3
        );


        $r[] = form_input(
            'col-lg-3  ',
            'ARTÍCULO',
            [
                "id" => "nombre_producto",
                "name" => "nombre",
                "class" => "input  nuevo_producto_nombre ",
                "type" => "text",
                "onkeyup" => "transforma_mayusculas(this)",
                "required" => true
            ]

        );

        $contenedor_ciclo_facturacion = _text(
            _titulo("CICLO DE FACTURACIÓN")
            ,
            create_select(
                $ciclo_facturacion,
                "ciclo",
                "form-control ciclo_facturacion ci_facturacion",
                "ciclo",
                "ciclo",
                "id_ciclo_facturacion"
            )
        );

        $r[] = d(
            $contenedor_ciclo_facturacion
            ,
            [
                "class" => "col-lg-3 contenedor_ciclo_facturacion",
                "style" => "display: none;"
            ]
        );


        $r[] = form_input(
            "col-lg-3 contenedor_precio"
        );

        $r[] = d(
            append([

                h(
                    text_icon('fa fa-money', " PRECIO"),
                    4,
                    [

                    ],
                    1
                )
                ,

                input(
                    [
                        "id" => "costo",
                        "class" => "form-control input-sm costo precio top_10",
                        "name" => "costo",
                        "required" => true,
                        "step" => "any",
                        "type" => "number"
                    ], 1
                )
                ,
                d($error_registro, "extra_precio", 1)

            ])
            ,
            "col-lg-3 contenedor_precio  top_30"
        );


        $r[] = d(btn("SIGUIENTE", ["class" => "btn_siguiente_registrar_servicio "]),
            [
                "class" => ' col-lg-3 siguiente_btn top_50'
            ]);
        $r[] = form_close();
        $re[] = d(append($r), "contenedor_agregar_servicio_form top_30");
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


        $r[] = h("TUS ARTÍCULOS EN VENTA", 3);
        $r[] = d(get_format_busqueda($list_orden), "contenedor_busqueda_articulos row top_50");
        $r[] = d(place("place_servicios top_50"), 1);
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

        $r[] = d("BUSCAR ENTRE TUS ARTÍCULOS", "col-lg-4 align-self-center");
        $r[] = d(list_orden($list_orden), 4);
        $r[] = d(
            input([
                    "id" => "textinput",
                    "name" => "textinput",
                    "placeholder" => "Nombre de tu producto o servicio",
                    "class" => "form-control input-sm q_emp",
                    "onkeyup" => "onkeyup_colfield_check(event);"
                ]
            ),
            4);
        return d(append($r), ["class" => "--"]);

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

        $r = [];
        if ($is_mobile > 0) {


            $r[] = h('SELECIONA LAS CATEGORÍAS', 3);
            $r[] = hr();
            $r[] = places(0);


        } else {


            $r[] = h("GRUPO AL CUAL PERTENECE TU PRODUCTO", 3);
            $r[] = a_enid(
                "CANCELAR",
                [
                    "class" => "cancelar_registro white",

                ],
                1);
            $r[] = hr();
            $r[] = places();

        }

        return d(append($r), "contenedor_categorias_servicios");

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


    function places($class = 1)
    {

        $response = "";
        if ($class > 0) {

            $text = append(
                [
                    d(place("primer_nivel_seccion"), ["class" => "info_categoria"]),
                    d(place("segundo_nivel_seccion"), ["class" => "info_categoria"]),
                    d(place("tercer_nivel_seccion"), ["class" => "info_categoria"]),
                    d(place("cuarto_nivel_seccion"), ["class" => "info_categoria"]),
                    d(place("quinto_nivel_seccion"), ["class" => "info_categoria"]),
                    d(place("sexto_nivel_seccion"), ["class" => "info_categoria"])
                ]

            );

            $response = addNRow($text);


        } else {

            $response = ul([
                place("primer_nivel_seccion"),
                place("segundo_nivel_seccion"),
                place("tercer_nivel_seccion"),
                place("cuarto_nivel_seccion"),
                place("quinto_nivel_seccion"),
                place("sexto_nivel_seccion")

            ]);
        }
        return $response;

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
        $response = "";
        $link_punto_venta = tab(
            text_icon('fa fa-map', " PUNTOS DE VENTA "),
            "#tab_puntos_venta",
            [
                'class' => "black puntos_venta"
            ]
        );

        $link_venta = tab(
            text_icon("fa fa-shopping-cart", " TUS ARTÍCULOS EN VENTA"),
            "#tab_servicios",
            [
                'class' => "black  btn_serv",
            ]
        );
        if ($is_mobile == 0) {
            $list = [

                li(
                    a_enid(
                        text_icon('fa fa-cart-plus', " VENDER PRODUCTOS ")
                        ,
                        [
                            "href" => path_enid('vender_nuevo'),
                            "class" => "agregar_servicio btn_agregar_servicios"
                        ]
                    ),
                    valida_active_tab('nuevo', $action) . "  "
                ),
                li(
                    $link_punto_venta, valida_active_tab('puntos_venta', $action) . "  "
                ),

                li(
                    $link_venta,
                    [
                        "class" => ' li_menu_servicio btn_servicios ' . valida_active_tab('lista', $action),
                        "id" => 0,
                    ]
                )
            ];


            if ($perfil != 20 && $perfil > 0) {

                $link_articulos_venta = tab(
                    text_icon("fa fa-globe", " ARTÍCULOS EN VENTA"),
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
                            "class" => ' li_menu_servicio btn_servicios ' . valida_active_tab('lista', $action),
                            "id" => 1,

                        ]
                    );
            }
            $response = ul($list, ["class" => "nav tabs contenedor_menu_enid_service_lateral"]);
        } else {


            $link = tab("", "#tab_servicios",
                [

                    'class' => "black  btn_serv"
                ]
            );
            $list = [
                li(
                    a_enid(
                        "",
                        [
                            "href" => "../planes_servicios/?action=nuevo",
                            "class" => "agregar_servicio btn_agregar_servicios"
                        ]
                    ),
                    ["class" => valida_active_tab('nuevo', $action)]
                ),

                li(
                    $link,
                    "li_menu li_menu_servicio btn_servicios " . valida_active_tab('lista', $action)

                )

            ];

            $response = ul($list, "nav tabs contenedor_menu_enid_service_lateral");

        }
        return $response;
    }


}
