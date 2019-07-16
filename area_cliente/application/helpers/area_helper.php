<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_user')) {


        function render_user($data)
        {

            $valoraciones = $data["valoraciones"];
            $id_usuario = $data["id_usuario"];
            $alcance = $data["alcance"];
            $ticket = $data["ticket"];
            $action = $data["action"];

            $r[] = d(place("place_servicios_contratados"), ["class" => "tab-pane " . valida_active_tab('compras', $action), "id" => 'tab_mis_pagos']);
            $r[] = d(place("place_ventas_usuario"), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_mis_ventas']);
            $r[] = d(get_format_valoraciones($valoraciones, $id_usuario, $alcance), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_valoraciones']);
            $r[] = d(place("place_pagar_ahora"), ["class" => "tab-pane", "id" => "tab_pagos"]);
            $r[] = d(place("place_resumen_servicio"), ["class" => "tab-pane", "id" => "tab_renovar_servicio"]);
            $r[] = get_hiddens_tickects($action, $ticket);
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
                input_hidden(["class" => "action", "value" => $action]),
                input_hidden(["class" => "ticket", "value" => $ticket])
            ]);
        }
    }
    if (!function_exists('get_format_buzon')) {

        function get_format_buzon()
        {

            $r[] = h("BUZÓN", 3);
            $r[] = d(append(

                anchor_enid("HECHAS" .
                    span("", 'notificacion_preguntas_sin_leer_cliente'),
                    [
                        "class" => "a_enid_black preguntas btn_preguntas_compras",
                        "id" => '0'
                    ]
                )
                ,

                anchor_enid(
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

            $x[] = h("MIS VALORACIONES Y RESEÑAS RECIBIDAS", 3);
            $x[] = d($valoraciones, "top_30");
            $x[] = d(
                anchor_enid(
                    "VER COMENTARIOS",
                    [
                        "href" => path_enid("recomendacion", $id_usuario),
                        "class" => "a_enid_blue  top_30"
                    ]
                ),
                "text-center top_20"
            );

            $x[] = d($alcance, " text-center top_30");

            $response = d(d(append($x), 6, 1), "text-center");
            return $response;

        }
    }
    function crea_alcance($alcance)
    {

        $response = "";
        if (es_data($alcance)) {

            $alcance = $alcance[0];
            $maximo = $alcance["maximo"];
            $minimo = $alcance["minimo"];
            $promedio = $alcance["promedio"];

            $r[] = h("ALCANCE DE TUS PRODUCTOS", 3);
            $r[] = "<table>";
            $r[] = "<tr>";
            $r[] = td($maximo, ["class" => 'num_alcance', "id" => $maximo]);
            $r[] = td($promedio, ["class" => 'num_alcance']);
            $r[] = td($minimo, ["class" => 'num_alcance', "id" => $maximo]);
            $r[] = "</tr>";
            $r[] = "<tr>";
            $r[] = td("Tope", ["class" => 'num_alcance']);
            $r[] = td("Promedio", ["class" => 'num_alcance']);
            $r[] = td("Mínimo", ["class" => 'num_alcance']);
            $r[] = "</tr>";
            $r[] = "</table>";
            $response = append($r);
        }
        return $response;

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
            anchor_enid("",
                [
                    "href" => "#tab_pagos",
                    "data-toggle" => "tab",
                    "class" => 'black strong tab_pagos',
                    "id" => 'btn_pagos'
                ]);

        $_vendedor =
            anchor_enid(
                d(
                    text_icon("fa fa-flag", " VENDER"),
                    [
                        "href" => path_enid("vender_nuevo")

                    ]
                )
            );


        $a_mis_ventas = anchor_enid(

            text_icon('fa fa-shopping-bag', "VENTAS")
            ,
            [
                "id" => "mis_ventas",
                "href" => "#tab_mis_ventas",
                "data-toggle" => "tab",
                "class" => 'btn_mis_ventas'
            ]);

        $place_ventas = place("place_num_pagos_notificados");


        $_compras = anchor_enid(text_icon('fa fa-credit-card-alt', " COMPRAS"),
            [
                "id" => "mis_compras",
                "href" => "#tab_mis_pagos",
                "data-toggle" => "tab",
                "class" => 'btn_cobranza mis_compras'
            ]);

        $notificacion = anchor_enid(place("place_num_pagos_por_realizar"), [
                "id" => "mis_compras",
                "href" => "#tab_mis_pagos",
                "data-toggle" => "tab",
                "class" => 'btn_cobranza mis_compras'
            ]
        );

        $_valoraciones = anchor_enid(
            text_icon("fa fa-star", " VALORACIONES"),
            [
                "id" => "mis_valoraciones",
                "href" => "#tab_valoraciones",
                "data-toggle" => "tab"
            ]);

        $_lista_deseo = anchor_enid(text_icon("fa fa-gift" ,  "LISTA DE DESEOS")  , path_enid("lista_deseos"));


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