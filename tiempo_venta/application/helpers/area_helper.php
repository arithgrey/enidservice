<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_tv')) {

        function render_tv($data)
        {


            $r[] = form_open("", ["class" => "form_tiempo_entrega", "id" => "form_tiempo_entrega"]);
            $r[] = d(

                d(input(

                    [
                        "name" => "q",
                        "placeholder" => "id, nombre",
                        "class" => "top_30 col-lg-12"
                    ]
                ), 12)

                ,
                4
            );

            $r[] = d(frm_fecha_busqueda(), 8);
            $r[] = form_close();
            $form = d(append($r), 1);

            $z[] = br(3);
            $z[] = d(
                btw(
                    d(h("ARTÍCULO", 3, "col-lg-12"), 1)
                    ,
                    $form
                    ,
                    8, 1

                )
                ,
                13
            );
            $z[] = d(place("place_tiempo_entrega"), 8, 1);

            return append($z);

        }
    }
    if (!function_exists('get_hiddens_tickects')) {

        function get_hiddens_tickects($action, $ticket)
        {
            return append(
                [
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
    }
    if (!function_exists('get_format_valoraciones')) {
        function get_format_valoraciones($valoraciones, $id_usuario, $alcance)
        {


            $x[] = h("MIS VALORACIONES Y RESEÑAS RECIBIDAS", 3);
            $x[] = $valoraciones;
            $url = path_enid("recomendacion", $id_usuario);
            $x[] = d(
                a_enid("VER COMENTARIOS",
                    [
                        "href" => $url,
                        "class" => "a_enid_blue "
                    ]
                ),
                "text-center top_20"
            );

            $x[] = d($alcance, " text-center ");
            $r[] = d(append($x), 3);
            $r[] = d(place("place_ventas_usuario"), 9);
            return d(append($r), "text-center");

        }
    }
    function crea_alcance($alcance)
    {

        $response = "";
        if (es_data($alcance)) {

            $alcance = $alcance[0];
            $maximo = $alcance["maximo"];

            $r[] = h("ALCANCE DE TUS PRODUCTOS", 3);
            $r[] = "<table>";
            $r[] = "<tr>";
            $r[] = td($maximo, ["class" => 'num_alcance', "id" => $maximo]);
            $r[] = td($alcance["promedio"], ["class" => 'num_alcance']);
            $r[] = td($alcance["minimo"], ["class" => 'num_alcance', "id" => $maximo]);
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

        return (strlen($estatus) > 0) ?
            (($nombre_seccion == $estatus) ? " active " : "") :
            (($nombre_seccion == "compras") ? " active " : "");

    }

    function get_menu($action)
    {

        $list = [
            li(a_enid(d("VENDER"),
                    [
                        "href" => path_enid("vender", "/?action=nuevo"),
                        "class" => 'black strong tab_pagos',

                    ])
                , "li_menu menu_vender " . valida_active_tab('ventas', $action)),
            li(a_enid(text_icon('fa fa-shopping-bag', "TUS VENTAS"),
                [
                    "id" => "mis_ventas",
                    "href" => "#tab_mis_ventas",
                    "data-toggle" => "tab",
                    "class" => 'black strong btn_mis_ventas'
                ]), 'li_menu'),
            li(place("place_num_pagos_notificados"), 'li_menu'),
            li(a_enid(text_icon('fa fa-credit-card-alt', "TUS COMPRAS" . place("place_num_pagos_por_realizar")),
                [
                    "id" => "mis_compras",
                    "href" => "#tab_mis_pagos",
                    "data-toggle" => "tab",
                    "class" => 'black strong btn_cobranza mis_compras'
                ]), 'li_menu ' . valida_active_tab('compras', $action)),
            li(a_enid(
                text_icon("fa fa-gift", "LISTA DE DESEOS"),
                [
                    "href" => path_enid("lista_deseos"),
                    "class" => 'black strong'
                ]), 'li_menu'),
            li(a_enid("",
                [
                    "href" => "#tab_pagos",
                    "data-toggle" => "tab",
                    "class" => 'black strong tab_pagos',
                    "id" => 'btn_pagos'
                ]), ["class" => 'li_menu', "style" => "display: none;"]),

        ];
        return ul($list, "nav tabs shadow border padding_10");
    }

}