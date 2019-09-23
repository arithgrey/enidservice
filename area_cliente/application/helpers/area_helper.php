<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_user')) {


        function render_user($data)
        {


            $action = $data["action"];
            $r[] = d(place("place_servicios_contratados"), ["class" => "tab-pane " . valida_active_tab('compras', $action), "id" => 'tab_mis_pagos']);
            $r[] = d(place("place_ventas_usuario"), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_mis_ventas']);

            $r[] = d(get_format_valoraciones($data["valoraciones"], $data["id_usuario"], $data["alcance"]), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_valoraciones']);
            $r[] = d(place("place_pagar_ahora"), ["class" => "tab-pane", "id" => "tab_pagos"]);
            $r[] = d(place("place_resumen_servicio"), ["class" => "tab-pane", "id" => "tab_renovar_servicio"]);
            $r[] = get_hiddens_tickects($action, $data["ticket"]);
            $r[] = d("",
                [
                    "class" => "resumen_pagos_pendientes",
                    "href" => "#tab_renovar_servicio",
                    "data-toggle" => "tab"
                ]
            );

            $response[] = d(get_menu($action), 2);
            $response[] = d(d(append($r), "tab-content"), 10);
            return d(append($response), "contenedor_principal_enid");

        }

    }
    if (!function_exists('get_hiddens_tickects')) {

        function get_hiddens_tickects($action, $ticket)
        {
            return append([
                hiddens(["class" => "action", "value" => $action]),
                hiddens(["class" => "ticket", "value" => $ticket])
            ]
            );
        }
    }
    if (!function_exists('get_format_buzon')) {

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
                    "RECIBIDAS" .
                    span("", 'notificacion_preguntas_sin_leer_ventas')
                    ,
                    [
                        "class" => "a_enid_blue preguntas ",
                        "id" => "1"
                    ])

            ));

            $r[] = place("place_buzon");

            return append($r);

        }
    }
    if (!function_exists('get_format_valoraciones')) {
        function get_format_valoraciones($valoraciones, $id_usuario, $alcance)
        {

            $r =  [];
            if (es_data($valoraciones)){

                $x[] = h("MIS VALORACIONES Y RESEÑAS RECIBIDAS", 3);
                $x[] = d($valoraciones, "top_30");
                $x[] = d(
                    a_enid(
                        "VER COMENTARIOS",
                        [
                            "href" => path_enid("recomendacion", $id_usuario),
                            "class" => "a_enid_blue  top_30"
                        ]
                    ),
                    "text-center top_20"
                );

                $x[] = d($alcance, " text-center top_30");


                $r[] =   d(d(append($x), 6, 1), "text-center");
            }
            return append($r);

        }
    }
    function crea_alcance($alcance)
    {

        $response = [];
        if (es_data($alcance)) {

            $alcance = $alcance[0];
            $maximo = $alcance["maximo"];
            $minimo = $alcance["minimo"];
            $promedio = $alcance["promedio"];

            $a   =  [];
            $a[] = td($maximo, ["class" => 'num_alcance', "id" => $maximo]);
            $a[] = td($promedio, ["class" => 'num_alcance']);
            $a[] = td($minimo, ["class" => 'num_alcance', "id" => $maximo]);

            $r[] = tr(append($a));


            $b   =  [];
            $b[] = td("Tope", ["class" => 'num_alcance']);
            $b[] = td("Promedio", ["class" => 'num_alcance']);
            $b[] = td("Mínimo", ["class" => 'num_alcance']);

            $r[] = tr( append($b) );

            $response[] = h("ALCANCE DE TUS PRODUCTOS", 3 ,[] );
            $response[] = tb(append($r));
        }
        return append($response);

    }

    function valida_active_tab($nombre_seccion, $estatus)
    {

        $a = ($nombre_seccion == $estatus) ? " active " : "";
        $b = ($nombre_seccion == "compras") ? " active " : "";
        return (strlen($estatus) > 0) ? $a : $b;

    }

    function get_menu($action)
    {
        $_pagos =
            a_enid("",
                [
                    "href" => "#tab_pagos",
                    "data-toggle" => "tab",
                    "class" => 'black strong tab_pagos',
                    "id" => 'btn_pagos'
                ]);

        $_vendedor =
            a_enid(
                d(
                    text_icon("fa fa-flag", " VENDER"),
                     path_enid("vender_nuevo")
                )
            );


        $a_mis_ventas = a_enid(

            text_icon('fa fa-shopping-bag', "VENTAS")
            ,
            [
                "id" => "mis_ventas",
                "href" => "#tab_mis_ventas",
                "data-toggle" => "tab",
                "class" => 'btn_mis_ventas'
            ]);

        $place_ventas = place("place_num_pagos_notificados");


        $_compras = a_enid(text_icon('fa fa-credit-card-alt', " COMPRAS"),
            [
                "id" => "mis_compras",
                "href" => "#tab_mis_pagos",
                "data-toggle" => "tab",
                "class" => 'btn_cobranza mis_compras'
            ]);

        $notificacion = a_enid(place("place_num_pagos_por_realizar"), [
                "id" => "mis_compras",
                "href" => "#tab_mis_pagos",
                "data-toggle" => "tab",
                "class" => 'btn_cobranza mis_compras'
            ]
        );

        $_valoraciones = a_enid(
            text_icon("fa fa-star", " VALORACIONES"),
            [
                "id" => "mis_valoraciones",
                "href" => "#tab_valoraciones",
                "data-toggle" => "tab"
            ]);

        $_lista_deseo = a_enid(text_icon("fa fa-gift", "LISTA DE DESEOS"), path_enid("lista_deseos"));


        $list = [
            $_vendedor,
            $a_mis_ventas,
            $place_ventas,
            $_compras,
            $notificacion,
            $_valoraciones,
            $_lista_deseo,
            li($_pagos, ["class" => 'li_menu', "style" => "display: none;"]),

        ];
        return ul($list, ["class" => "shadow border padding_10 d-flex flex-column justify-content-between", "style" => "min-height: 220px;"]);
    }

}