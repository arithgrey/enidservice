<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render_user($data)
    {

        $action = $data["action"];

        $r[] = hiddens_tickects($action, $data["ticket"]);
        $r[] = tab_seccion(
            place("place_servicios_contratados"),
            "tab_mis_pagos",
            active_tab('compras', $action)
        );

        $r[] = tab_seccion(
            place("place_ventas_usuario"),
            'tab_mis_ventas',
            active_tab('ventas', $action)
        );

        $r[] = tab_seccion(
            valoraciones($data["valoraciones"], $data["id_usuario"], $data["alcance"]),
            'tab_valoraciones',
            active_tab('ventas', $action)
        );

        $r[] = tab_seccion(
            place("place_pagar_ahora"),
            'tab_pagos'
        );
        $r[] = tab_seccion(
            place("place_resumen_servicio"),
            'tab_renovar_servicio'
        );

        $r[] = tab("", "#tab_renovar_servicio",
            [
                "class" => "resumen_pagos_pendientes",
            ]
        );

        //$response[] = d(menu($action), 2);
        $response[] = tab_content($r, 10);
        return append($response);

    }


    function hiddens_tickects($action, $ticket)
    {
        return append(
            [
                hiddens(["class" => "action", "value" => $action]),
                hiddens(["class" => "ticket", "value" => $ticket])
            ]
        );
    }

    function valoraciones($valoraciones, $id_usuario, $alcance)
    {

        $r = [];
        if (es_data($valoraciones)) {

            $x[] = h("MIS VALORACIONES Y RESEÑAS RECIBIDAS", 3);
            $x[] = d($valoraciones, "top_30");
            $x[] = a_enid(
                "VER COMENTARIOS",
                [
                    "href" => path_enid("recomendacion", $id_usuario),
                    "class" => "a_enid_blue  top_30 text-center"
                ]
            );

            $x[] = d($alcance, " text-center top_30");
            $r[] = d(d(append($x), 6, 1), "text-center");
        }
        return append($r);

    }

    function crea_alcance($alcance)
    {

        $response = [];
        if (es_data($alcance)) {

            $alcance = $alcance[0];
            $maximo = $alcance["maximo"];
            $minimo = $alcance["minimo"];
            $promedio = $alcance["promedio"];

            $a = [];
            $a[] = td($maximo, ["class" => 'num_alcance', "id" => $maximo]);
            $a[] = td($promedio, 'num_alcance');
            $a[] = td($minimo, ["class" => 'num_alcance', "id" => $maximo]);

            $r[] = tr(append($a));

            $b = [];
            $b[] = td("Tope", 'num_alcance');
            $b[] = td("Promedio", 'num_alcance');
            $b[] = td("Mínimo", 'num_alcance');

            $r[] = tr(append($b));

            $response[] = h("ALCANCE DE TUS PRODUCTOS", 3, []);
            $response[] = tb(append($r));
        }
        return append($response);

    }

    function active_tab($nombre_seccion, $estatus)
    {

        $a = igual($nombre_seccion, $estatus, 1, 0);
        $b = igual($nombre_seccion, "compras", 1, 0);
        return (strlen($estatus) > 0) ? $a : $b;

    }

    function menu()
    {
        $link_pagos = tab(
            "",
            "#tab_pagos",
            [
                'class' => 'tab_pagos',
                'id' => 'btn_pagos'
            ]
        );

        $link_vendedor =
            a_enid(
                text_icon("fa fa-flag", " VENDER"),
                path_enid("vender_nuevo")

            );

        $link_ventas = tab(
            text_icon('fa fa-shopping-bag', "VENTAS"),
            "#tab_mis_ventas",
            [
                "class" => 'btn_mis_ventas',
                "id" => "mis_ventas",
            ]

        );

        $place_ventas = place("place_num_pagos_notificados");

        $link_compras = tab(

            text_icon('fa fa-credit-card-alt', " COMPRAS"),
            "#tab_mis_pagos",
            [
                "class" => 'btn_cobranza mis_compras'
            ]

        );

        $link_notificaciones = tab(
            place("place_num_pagos_por_realizar"),
            "#tab_mis_pagos",
            [
                "id" => "mis_compras",
                "class" => 'btn_cobranza mis_compras'
            ]
        );

        $link_valoraciones = tab(

            text_icon("fa fa-star", " VALORACIONES")
            ,
            "#tab_valoraciones",
            [
                "id" => "mis_valoraciones"
            ]
        );

        $link_lista_deseo = a_enid(
            text_icon("fa fa-gift", "LISTA DE DESEOS"),
            path_enid("lista_deseos")
        );

        $list = [
            $link_vendedor,
            $link_ventas,
            $place_ventas,
            $link_compras,
            $link_notificaciones,
            $link_valoraciones,
            $link_lista_deseo,
            li($link_pagos,
                [
                    "class" => 'li_menu',
                ]
            ),

        ];
        return ul($list,
            [
                "class" => "shadow border padding_10 d-flex flex-column justify-content-between"
            ]
        );


    }

//    function get_format_buzon()
//    {
//
//        $r[] = h("BUZÓN", 3);
//        $r[] = d(append(
//
//            a_enid("HECHAS" .
//                span("", 'notificacion_preguntas_sin_leer_cliente'),
//                [
//                    "class" => "a_enid_black preguntas btn_preguntas_compras",
//                    "id" => '0'
//                ]
//            )
//            ,
//
//            a_enid(
//                "RECIBIDAS" .
//                span("", 'notificacion_preguntas_sin_leer_ventas')
//                ,
//                [
//                    "class" => "a_enid_blue preguntas ",
//                    "id" => "1"
//                ])
//
//        ));
//
//        $r[] = place("place_buzon");
//
//        return append($r);
//
//
//    }
}
