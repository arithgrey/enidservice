<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render_user($data)
    {
        $action = $data["action"];

        $r[] = hiddens_tickects($action, $data["ticket"]);
        $r[] = tab_seccion(
            d('',
                "place_servicios_contratados col-md-10 col-md-offset-1 p-0"
            ),
            "tab_mis_pagos",
            active_tab('compras', $action)
        );

        $r[] = tab_seccion(
            d('', "place_ventas_usuario col-md-10 col-md-offset-1"),
            'tab_mis_ventas',
            active_tab('ventas', $action)
        );

        $r[] = tab_seccion(
            place("place_pagar_ahora"),
            'tab_pagos'
        );
        $r[] = tab_seccion(
            d('',
                "place_resumen_servicio d-sm-flex  align-items-center mt-5 col-lg-8 col-lg-offset-2 mt-md-0 p-0"
            ),
            'tab_renovar_servicio'
        );

        $r[] = tab("", "#tab_renovar_servicio",
            [
                "class" => "resumen_pagos_pendientes",
            ]
        );


        $response[] = paseo();
        $response[] = d(tab_content($r), 'co-sm-12 col-md-12 col-lg-10');
        $response[] = menu($action);

        return append($response);

    }

    function paseo()
    {

        $r[] = _titulo('UPS! aún no tenemos pedidos ...');
        $r[] = format_link('Explorémos un poco!', ['href' => path_enid('search_q3')]);
        return d(d($r), 'mt-5 mb-5 d-none visita_tienda');
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
                    "class" => "a_enid_blue top_30 text-center"
                ]
            );

            $x[] = d($alcance, " text-center top_30");
            $r[] = d(d($x, 6, 1), "text-center");
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


        $link_ventas = tab(
            text_icon('fa fa-shopping-bag', "VENTAS"),
            "#tab_mis_ventas",
            [
                "class" => 'btn_mis_ventas',
                "id" => "mis_ventas",
            ]

        );


        $link_compras = tab(
            text_icon('fa fa-credit-card-alt', " COMPRAS"),
            "#tab_mis_pagos",
            [
                "class" => 'btn_cobranza mis_compras'
            ]

        );



        $list = [
            $link_compras,
            $link_ventas,
        ];

        return d(
            $list,
                 "col-sm-12 col-md-2 d-flex flex-column menu_area_cliente p-md-0 mt-5"
        );

    }
}
