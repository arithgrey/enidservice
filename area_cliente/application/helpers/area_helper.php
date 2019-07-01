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

            $r[] = div(place("place_servicios_contratados"), ["class" => "tab-pane " . valida_active_tab('compras', $action), "id" => 'tab_mis_pagos']);
            $r[] = div(place("place_ventas_usuario"), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_mis_ventas']);
            $r[] = div(get_format_valoraciones($valoraciones, $id_usuario, $alcance), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_valoraciones']);
            $r[] = div(place("place_pagar_ahora"), ["class" => "tab-pane", "id" => "tab_pagos"]);
            $r[] = div(place("place_resumen_servicio"), ["class" => "tab-pane", "id" => "tab_renovar_servicio"]);
            $r[] = get_hiddens_tickects($action, $ticket);
            $r[] = div("",
                [
                    "class" => "resumen_pagos_pendientes",
                    "href" => "#tab_renovar_servicio",
                    "data-toggle" => "tab"
                ]);

            $response[] = div(get_menu($action), 2);
            $response[] = div(div(append($r), "tab-content"), 10);
            return div(append($response), "contenedor_principal_enid");


            /*
            <div class="contenedor_principal_enid">
    <?= div(get_menu($action), 2) ?>
    <?php

    $r[] = div(place("place_servicios_contratados"), ["class" => "tab-pane " . valida_active_tab('compras', $action), "id" => 'tab_mis_pagos']);
    $r[] = div(place("place_ventas_usuario"), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_mis_ventas']);
    $r[] = div(get_format_valoraciones($valoraciones, $id_usuario, $alcance), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_valoraciones']);
    $r[] = div(place("place_pagar_ahora"), ["class" => "tab-pane", "id" => "tab_pagos"]);
    $r[] = div(place("place_resumen_servicio"), ["class" => "tab-pane", "id" => "tab_renovar_servicio"]);

    ?>
    <?= div(div(append($r), "tab-content"), 10) ?>
</div>
<?= get_hiddens_tickects($action, $ticket) ?>
<?= div("",
    [
        "class" => "resumen_pagos_pendientes",
        "href" => "#tab_renovar_servicio",
        "data-toggle" => "tab"
    ]) ?>
            */


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

            $r[] = heading_enid("BUZÓN", 3);
            $r[] = div(append(

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


            $x[] = heading_enid("MIS VALORACIONES Y RESEÑAS RECIBIDAS", 3);
            $x[] = div($valoraciones, "top_30");
            $x[] = div(
                anchor_enid(
                    "VER COMENTARIOS",
                    [
                        "href" => path_enid("recomendacion", $id_usuario),
                        "class" => "a_enid_blue  top_30"
                    ]
                ),
                "text-center top_20"
            );

            $x[] = div($alcance, " text-center top_30");

            $response = div(div(append($x), 6, 1), "text-center");
            return $response;

        }
    }
    function crea_alcance($alcance)
    {

        $response = "";
        if (is_array($alcance) && count($alcance) > 0) {
            $maximo = $alcance[0]["maximo"];
            $minimo = $alcance[0]["minimo"];
            $promedio = $alcance[0]["promedio"];

            $r[] = heading_enid("ALCANCE DE TUS PRODUCTOS", 3);
            $r[] = "<table>";
            $r[] = "<tr>";
            $r[] = get_td($maximo, ["class" => 'num_alcance', "id" => $maximo]);
            $r[] = get_td($promedio, ["class" => 'num_alcance']);
            $r[] = get_td($minimo, ["class" => 'num_alcance', "id" => $maximo]);
            $r[] = "</tr>";

            $r[] = "<tr>";
            $r[] = get_td("Tope", ["class" => 'num_alcance']);
            $r[] = get_td("Promedio", ["class" => 'num_alcance']);
            $r[] = get_td("Mínimo", ["class" => 'num_alcance']);
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
        $a_tab_pagos = anchor_enid("",
            [
                "href" => "#tab_pagos",
                "data-toggle" => "tab",
                "class" => 'black strong tab_pagos',
                "id" => 'btn_pagos'
            ]);

        $a_vendedor = anchor_enid(div(
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


        $a_mis_compras = anchor_enid(text_icon('fa fa-credit-card-alt', " COMPRAS"),
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

        $a_mis_valoraciones = anchor_enid(
            text_icon("fa fa-star", " VALORACIONES"),
            [
                "id" => "mis_valoraciones",
                "href" => "#tab_valoraciones",
                "data-toggle" => "tab"
            ]);

        $a_lista_deseo = anchor_enid(icon("fa fa-gift") . "LISTA DE DESEOS",
            [
                "href" => path_enid("lista_deseos")
            ]
        );


        $list = [
            $a_vendedor,
            $a_mis_ventas,
            $place_ventas,
            $a_mis_compras,
            $notificacion,
            $a_mis_valoraciones,
            $a_lista_deseo,
            li($a_tab_pagos, ["class" => 'li_menu', "style" => "display: none;"]),

        ];
        return ul($list, ["class" => "shadow border padding_10 d-flex flex-column justify-content-between", "style" => "min-height: 220px;"]);
    }

}