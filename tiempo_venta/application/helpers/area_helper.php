<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_tv')) {

        function render_tv($data)
        {


            $r[] = form_open("", ["class" => "form_tiempo_entrega", "id" => "form_tiempo_entrega"]);
            $r[] = div(

                div(input(

                    [
                        "name" => "q",
                        "placeholder" => "id, nombre",
                        "class" => "top_30 col-lg-12"
                    ]
                ), 12)

                ,
                4
            );

            $r[] = div(get_format_fecha_busqueda(), 8);
            $r[] = form_close();
            $form = div(append($r), 1);

            $z[] = br(3);
            $z[] = div(
                btw(
                    div(heading_enid("ARTÍCULO", 3, "col-lg-12"), 1)
                    ,
                    $form
                    ,
                    8, 1

                )
                ,
                13
            );
            $z[] = div(place("place_tiempo_entrega"), 8, 1);

            return append($z);

        }
    }
    if (!function_exists('get_hiddens_tickects')) {

        function get_hiddens_tickects($action, $ticket)
        {
            return append(
                [
                    input_hidden(["class" => "action", "value" => $action]),
                    input_hidden(["class" => "ticket", "value" => $ticket])
                ]
            );
        }
    }
    if (!function_exists('get_format_buzon')) {

        function get_format_buzon()
        {

            $r[] = heading_enid("BUZÓN", 3);
            $r[] = div(append(

                anchor_enid("HECHAS" .
                    span("",  'notificacion_preguntas_sin_leer_cliente'),
                    [
                        "class" => "a_enid_black preguntas btn_preguntas_compras",
                        "id" => '0'
                    ]
                )
                ,

                anchor_enid(
                    "RECIBIDAS" .
                    span("", 'notificacion_preguntas_sin_leer_ventas' )
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
            $x[] = $valoraciones;
            $url = path_enid("recomendacion", $id_usuario);
            $x[] = div(
                anchor_enid("VER COMENTARIOS",
                    [
                        "href" => $url,
                        "class" => "a_enid_blue "
                    ]
                ),
                "text-center top_20"
            );
            $x[] = div($alcance, " text-center ");

            $r[] = div(append($x), 3);
            $r[] = div(place("place_ventas_usuario"), 9);
            return div(append($r), "text-center");

        }
    }
    function crea_alcance($alcance)
    {

        $response = "";
        if (es_data($alcance)) {

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

        return (strlen($estatus) > 0) ? (($nombre_seccion == $estatus) ? " active " : "") : (($nombre_seccion == "compras") ? " active " : "");

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

        $a_vendedor = anchor_enid(div("VENDER"),
            [
                "href" => path_enid("vender", "/?action=nuevo"),
                "class" => 'black strong tab_pagos',

            ]);


        $a_mis_ventas = anchor_enid(text_icon('fa fa-shopping-bag', "TUS VENTAS"),
            [
                "id" => "mis_ventas",
                "href" => "#tab_mis_ventas",
                "data-toggle" => "tab",
                "class" => 'black strong btn_mis_ventas'
            ]);
        $place_ventas = place("place_num_pagos_notificados");


        $icon = icon('fa fa-credit-card-alt');
        $place = place("place_num_pagos_por_realizar");
        $a_mis_compras = anchor_enid($icon . "TUS COMPRAS" . $place,
            [
                "id" => "mis_compras",
                "href" => "#tab_mis_pagos",
                "data-toggle" => "tab",
                "class" => 'black strong btn_cobranza mis_compras'
            ]);

        $a_lista_deseo = anchor_enid(
            text_icon("fa fa-gift", "LISTA DE DESEOS"),
            [
                "href" => path_enid("lista_deseos"),
                "class" => 'black strong'
            ]);


        $list = [
            li($a_vendedor, "li_menu menu_vender " . valida_active_tab('ventas', $action)),
            li($a_mis_ventas, 'li_menu'),
            li($place_ventas, 'li_menu'),
            li($a_mis_compras, 'li_menu ' . valida_active_tab('compras', $action)),
            li($a_lista_deseo, 'li_menu'),
            li($a_tab_pagos, ["class" => 'li_menu', "style" => "display: none;"]),

        ];
        return ul($list, "nav tabs shadow border padding_10");
    }

}