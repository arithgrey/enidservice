<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $r[] = form_open("",
            [
                "class" => "form_tiempo_entrega",
                "id" => "form_tiempo_entrega"
            ]
        );

        $busqueda = input_frm('', 'Artículo',
            [
                "name" => "q",
                "placeholder" => "id, nombre",
                "class" => "input_busqueda",
                "id" => "input_busqueda"
            ]
        );

        $fechas = frm_fecha_busqueda();
        $r[] = flex($busqueda, $fechas, _between_end, 'p-md-0 col-sm-4 mt-5', 8, 'd-md-flex');
        $r[] = form_close();

        $form = append($r);

        $response[] = d(_titulo("tiempo de venta por artículo"), _mbt5);
        $response[] = $form;
        $response[] = d(place("place_tiempo_entrega"),12);

        return d($response,8,1);

    }


    function crea_alcance($alcance)
    {

        $response = "";
        if (es_data($alcance)) {

            $alcance = $alcance[0];
            $maximo = $alcance["maximo"];
            $z[] = td($maximo, ["class" => 'num_alcance', "id" => $maximo]);
            $z[] = td($alcance["promedio"], ["class" => 'num_alcance']);
            $z[] = td($alcance["minimo"], ["class" => 'num_alcance', "id" => $maximo]);
            $r[] = tr(append($z));

            $x[] = td("Tope", ["class" => 'num_alcance']);
            $x[] = td("Promedio", ["class" => 'num_alcance']);
            $x[] = td("Mínimo", ["class" => 'num_alcance']);
            $r[] = tr(append($x));

            $response = add_text(_titulo("ALCANCE DE TUS PRODUCTOS"), tb($r));
        }
        return $response;

    }

    function valida_active_tab($nombre_seccion, $estatus)
    {

        return (strlen($estatus) > 0) ?
            (($nombre_seccion == $estatus) ? " active " : "") :
            (($nombre_seccion == "compras") ? " active " : "");

    }

    function get_menu($action)
    {

        $link_def = tab("", "#tab_pagos",
            [
                "class" => 'black strong tab_pagos'
            ]
        );

        $link_ventas = tab(
            text_icon('fa fa-shopping-bag', "TUS VENTAS"),
            "#tab_mis_ventas",
            [
                "id" => "mis_ventas",
                "class" => 'btn_mis_ventas'
            ]
        );

        $link_compras = tab(
            text_icon('fa fa-credit-card-alt', "TUS COMPRAS"),
            "#tab_mis_pagos",
            [
                "id" => "mis_compras",
                "class" => 'btn_cobranza mis_compras'
            ]
        );

        $list = [
            li(a_enid(d("VENDER"),
                    [
                        "href" => path_enid("vender", "/?action=nuevo"),
                        "class" => 'black strong tab_pagos',

                    ])
                , "li_menu menu_vender " . valida_active_tab('ventas', $action)),
            li($link_ventas, 'li_menu'),
            li(place("place_num_pagos_notificados"), 'li_menu'),

            li(
                $link_compras
                , 'li_menu ' . valida_active_tab('compras', $action)
            ),
            li(a_enid(
                text_icon("fa fa-gift", "LISTA DE DESEOS"),
                [
                    "href" => path_enid("lista_deseos"),
                    "class" => 'black strong'
                ]), 'li_menu'),
            li(
                $link_def
                , ["class" => 'li_menu', "style" => "display: none;"]),

        ];
        return ul($list, "nav tabs shadow border padding_10");
    }

//
//    function get_hiddens_tickects($action, $ticket)
//    {
//        return append(
//            [
//                hiddens(["class" => "action", "value" => $action]),
//                hiddens(["class" => "ticket", "value" => $ticket])
//            ]
//        );
//    }

    /*
    function get_format_buzon()
    {

        $r[] = h("BUZÓN", 3);
        $r[] = d(append(

            a_enid("HECHAS" .
                span("", 'notificacion_preguntas_sin_leer_cliente'),
                [
                    "class" => "a_enid_black preguntas btn_preguntas_compras",
                    "id" => '0'
                ]
            )
            ,

            a_enid(
                add_text("RECIBIDAS", span("", 'notificacion_preguntas_sin_leer_ventas'))
                ,
                [
                    "class" => "a_enid_blue preguntas ",
                    "id" => "1"
                ])

        ));

        $r[] = place("place_buzon");

        return append($r);

    }
     *
     */
//
//    function get_format_valoraciones($valoraciones, $id_usuario, $alcance)
//    {
//
//        $x[] = h("MIS VALORACIONES Y RESEÑAS RECIBIDAS", 3);
//        $x[] = $valoraciones;
//        $url = path_enid("recomendacion", $id_usuario);
//        $x[] = d(
//            a_enid("VER COMENTARIOS",
//                [
//                    "href" => $url,
//                    "class" => "a_enid_blue "
//                ]
//            ),
//            "text-center top_20"
//        );
//
//        $x[] = d($alcance, " text-center ");
//        $r[] = d(append($x), 3);
//        $r[] = d(place("place_ventas_usuario"), 9);
//        return d(append($r), "text-center");
//
//    }
}
