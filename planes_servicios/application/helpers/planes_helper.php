<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_ventas($data)
    {

        $id_perfil = $data["id_perfil"];
        $action = $data["action"];
        $top_servicios = $data["top_servicios"];
        $considera_segundo = $data["considera_segundo"];
        $id_usuario = $data['id_usuario'];
        $t[] = menu($id_perfil, $action, $id_usuario);
        $t[] = btw(
            _titulo("artículos más vistos de la semana")
            ,
            top_ventas($top_servicios)
            ,
            "contenedor_top " . ($action == 1) ? " d-none " : " "
        );

        $r[] = d($t, 'col-md-2 p-0');

        $z[] = tab_seccion(
            articulos_venta($data["list_orden"]),
            'tab_servicios',
            tab_activa(0, $action, $considera_segundo)
        );
        $z[] = tab_seccion(
            puntos_venta()
            ,
            'tab_puntos_venta',
            tab_activa(0, $action, $considera_segundo)
        );
        $z[] = tab_seccion(
            form_ventas($data["ciclo_facturacion"], $data["error_registro"]),
            'tab_form_servicio',
            tab_activa(1, $action),
            [
                'class' => 'mt-5 mt-md-0'
            ]
        );


        $r[] = tab_content($z, 10);
        $r[] = d(top_articulos($top_servicios), 2);
        $r[] = frm_hiddens($action, $data["extra_servicio"]);

        return append($r);
    }


    function form_ventas($ciclo_facturacion, $error_registro)
    {

        $r[] = form_open('',
            [
                'class' => "form_nombre_producto col-lg-6 col-lg-offset-3 p-0",
                "id" => 'form_nombre_producto'
            ]
        );

        $r[] = _titulo('¿Qué anunciamos?');
        $r[] = flex(
            a_enid('un producto',
                [
                    "class" => "tipo_promocion tipo_producto easy_select_enid button_enid_eleccion_active text-uppercase",
                    "id" => 0,
                ]
            )
            ,
            a_enid(
                "un servicio",
                [
                    "class" => "tipo_promocion tipo_servicio text-uppercase",
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

        $seccion_precio = input_frm('contenedor_precio mt-5 mt-md-5',
            'Precio MXN',
            [
                "id" => "costo",
                "class" => "costo precio border-top-0 border-right-0 border-left-0 border_bottom_big",
                "name" => "costo",
                "required" => true,
                "step" => "any",
                "type" => "float",
                "placehorder" => "880",
            ], _text_cantidad
        );

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
        $re[] = selector_categoria();
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

        $r[] = _titulo("configurar artículos");
        $r[] = d(get_format_busqueda($list_orden), "contenedor_busqueda_articulos");
        $r[] = place("place_servicios");
        return append($r);
    }

    function puntos_venta()
    {

        $r[] = _titulo("puntos de venta");
        $r[] = d(place("place_puntos_venta top_50"), 1);
        return append($r);

    }


    function get_format_busqueda($list_orden)
    {

        $r[] = input_frm(4, 'Filtrar',
            [
                "id" => "textinput",
                "name" => "textinput",
                "placeholder" => "Nombre del producto o servicio",
                "class" => "q_emp",
                "onkeyup" => "onkeyup_colfield_check(event);"
            ]
        );

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


    function top_articulos($top)
    {

        $response = "";
        $is_mobile = is_mobile();
        if (es_data($top) && $is_mobile > 0) {

            $r = [];
            foreach ($top as $row):

                $r[] = icon("fa fa-angle-right");
                $nombre_servicio = $row["nombre_servicio"];
                $articulo = (trim(strlen($nombre_servicio)) > 22) ? substr($nombre_servicio, 0, 22) . "..." : strlen($nombre_servicio);
                $r[] = $articulo;
                $r[] = d(
                    d($row["vistas"], "a_enid_black_sm_sm"),
                    [
                        "class" => "pull-right",
                        "title" => "Personas que han visualizado este  producto"
                    ]
                );


                $r[] = a_enid($r, path_enid("producto", $row['id_servicio']));

            endforeach;


            if (es_data($top)):
                $titulo = _titulo("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA");
                array_pop($r, $titulo);
            endif;

            $response = d($r, "card contenedor_articulos_mobil");

        }
        return $response;
    }


    function selector_categoria()
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


    function frm_hiddens($action, $extra_servicio)
    {

        $is_mobile = is_mobile();
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


    function menu($perfil, $action, $id_usuario)
    {

        $is_mobile = is_mobile();
        $punto_venta = tab(
            text_icon('fa fa-map', " puntos de entrega "),
            "#tab_puntos_venta",
            [
                'class' => "puntos_venta"
            ]
        );

        $venta = tab(
            text_icon("fa fa-shopping-cart", "configurar artículos"),
            "#tab_servicios",
            [
                'class' => "black btn_serv mt-3",
            ]
        );

        if (!$is_mobile) {

            $list[] = li(
                a_enid(
                    text_icon('fa fa-share', "publicar producto")
                    ,
                    [
                        "href" => path_enid('vender_nuevo'),
                        "class" => "agregar_servicio btn_agregar_servicios 
                        text-uppercase black mt-3"
                    ]
                ),
                _text(tab_activa('nuevo', $action), " ")
            );

            $list[] = li(
                $punto_venta,
                _text(tab_activa('puntos_venta', $action), " mt-3")
            );

            $list[] =
                li(
                    $venta,
                    [
                        "class" =>
                            _text(
                                'btn_servicios ',
                                tab_activa('lista', $action)
                            ),
                        "id" => 0,
                    ]
                );


            if ($perfil == 3) {

                $link_articulos_venta = tab(
                    text_icon("fa fa-globe", "articulos en venta"),
                    "#tab_servicios",
                    [
                        'class' => "black  btn_serv mt-3",
                        "id" => 1
                    ]

                );
                $list[] =
                    li(
                        $link_articulos_venta
                        ,
                        [
                            "class" => _text(
                                'btn_servicios ',
                                tab_activa('lista', $action)
                            ),
                            "id" => 1,

                        ]
                    );
            }
            $response = ul($list);
        } else {


            $link = tab("", "#tab_servicios",
                [

                    'class' => "black btn_serv"
                ]
            );

            $list[] = li(
                a_enid(
                    "",
                    [
                        "href" => path_enid('vender_nuevo'),
                        "class" => "agregar_servicio btn_agregar_servicios"
                    ]
                ),
                ["class" => tab_activa('nuevo', $action)]
            );
            $list[] = li(
                $link,
                _text(
                    " btn_servicios ",
                    tab_activa('lista', $action)
                )

            );


            $response = ul($list);

        }
        return $response;
    }

}
