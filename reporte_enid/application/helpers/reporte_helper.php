<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function render_reporte($data)
    {

        $response[] = tab_seccion(place("place_reporte"), 'reporte');
        $response[] = format_indicadores();
        $response[] = format_tipo_entrega();
        $response[] = format_actividad();
        $response[] = format_productos_solicitados();
        $response[] = format_accesos();
        $response[] = format_arquetipos($data);
        $response[] = format_comisionistas($data);
        $response[] = format_entregas();
        $response[] = format_tipificaciones();
        $response[] = format_motivos_cancelaciones();
        $response[] = format_evaluaciones();
        $response[] = format_top_ventas();
        $response[] = format_sin_ventas();


        $response[] = format_categorias($data);
        $res[] = d(menu(), "col-lg-2 p-0 contenedor_menu");
        $res[] = tab_content($response, 10);

        return d(append($res), "container-fluid");

    }

    function format_categorias(array $data)
    {
        $r[] = h("CATEGORÍAS DESTACADAS", 3, "mb-5 h3 text-uppercase strong text-center");
        $r[] = crea_repo_categorias_destacadas(
            sub_categorias_destacadas($data["categorias_destacadas"]));

        return d(append($r),
            [
                "class" => "tab-pane",
                "id" => "tab_productos_publicos",
            ]
        );


    }

    function format_productos_solicitados()
    {
        $form = base_busqueda_form('PRODUCTOS MÁS BUSCADOS POR CLIENTES',
            'form_busqueda_productos_solicitados', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_busqueda_productos",
            ]
        );


    }
    function format_accesos()
    {
        $form = base_busqueda_form('ACCESOS POR PÁGINA',
            'form_busqueda_accesos_pagina', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_accesos_pagina",
            ]
        );


    }

    function format_arquetipos($data)
    {
        $form = busqueda_arquetipo($data['tipo_tag_arquetipo'], 'HISTORIAS DE USUARIO (ARQUETIPOS)',
            'form_arquetipos', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_arquetipos",
            ]
        );
    }

    function format_comisionistas($data)
    {
        $form = base_busqueda_form('VENTAS POR COMISIONISTAS',
            'form_ventas_comisionistas', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_comisionistas",
            ]
        );

    }

    function format_entregas()
    {
        $form = base_busqueda_form('REPARTIDORES ENTREGAS',
            'form_entregas', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_entregas",
            ]
        );

    }


    function format_tipificaciones()
    {
        $form = base_busqueda_form('TIPIFICACIONES',
            'form_tipificaciones', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_tipificaciones",
            ]
        );


    }


    function format_evaluaciones()
    {

        $hoy = date_format(horario_enid(), 'Y-m-d');
        $ayer = add_date(date("Y-m-d"), -30);
        $form = base_busqueda_form('Evaluaciones',
            'form_evaluaciones', 'place_keywords', $ayer, $hoy);

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_evaluaciones",
            ]
        );
    }



    function format_sin_ventas()
    {

        $hoy = date_format(horario_enid(), 'Y-m-d');
        $ayer = add_date(date("Y-m-d"), -30);

        $form = base_busqueda_form('Articulos sin venta (requieren atención)',
            'form_sin_ventas', 'place_keywords', $ayer, $hoy );

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_sin_ventas",
            ]
        );
    }


    function format_top_ventas()
    {

        $hoy = date_format(horario_enid(), 'Y-m-d');
        $ayer = add_date(date("Y-m-d"), -30);

        $form = base_busqueda_form('Top artículos vendidos',
            'form_top_ventas', 'place_keywords', $ayer, $hoy);

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_top_ventas",
            ]
        );
    }

    function format_motivos_cancelaciones()
    {

        $form = base_busqueda_form('MOTIVOS CANCELACIONES',
            'form_motivos_cancelaciones', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_motivos_cancelaciones",
            ]
        );
    }

    function format_actividad()
    {

        $form = base_busqueda_form('USUARIOS',
            'f_actividad_productos_usuarios', 'repo_usabilidad');

        return d($form, [
                "class" => "tab-pane",
                "id" => 'tab_usuarios',
            ]
        );


    }

    function format_tipo_entrega()
    {

        $form = base_busqueda_form('TIPOS DE ENTREGAS', 'form_tipos_entregas',
            'place_tipos_entregas');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => 'tab_tipos_entregas',
            ]
        );

    }

    function format_indicadores()
    {
        $form = base_busqueda_form(
            "indicadores", 'form_busqueda_global_enid', "place_usabilidad");

        return d($form,
            [
                "class" => "tab-pane active",
                "id" => 'tab_default_1',
            ]
        );

    }

    function base_busqueda_form($titulo_seccion, $clase_form, $place, $fecha_inicio = 0, $fecha_termino = 0)
    {

        $r[] = h($titulo_seccion, 3, "mb-5 h3 text-uppercase strong");
        $r[] = form_open("", ["class" => $clase_form]);
        $r[] = frm_fecha_busqueda($fecha_inicio, $fecha_termino);
        $r[] = form_close();
        $r[] = place(_text_($place, "mt-5"));

        return append($r);
    }

    function busqueda_arquetipo($tipo_tag_arquetipo, $titulo_seccion, $clase_form, $place)
    {


        $r[] = h($titulo_seccion, 3, "mb-5 h3 text-uppercase strong");
        $r[] = form_open("", ["class" => $clase_form]);
        $tipos = create_select(
            $tipo_tag_arquetipo, 'tipo_tag_arquetipo', 'tipo_tag_arquetipo',
            'tipo_tag_arquetipo', 'tipo', 'id_tipo_tag_arquetipo');
        $fechas = frm_fecha_busqueda();
        $r[] = flex_md($tipos, $fechas, _between, 4, 8);
        $r[] = form_close();
        $r[] = place(_text_($place, " mt-5"));

        return append($r);
    }


    function crea_repo_categorias_destacadas($param)
    {

        $r = [];
        foreach ($param as $row) {

            $total = p($row["total"], 'h4 strong');
            $href = path_enid("search", "/?q=&q2=" . $row["primer_nivel"]);
            $clasificacion = a_enid($row["nombre_clasificacion"],
                [
                    "href" => $href,
                    "class" => "black strong",
                ]
            );
            $r[] = d(flex($total, $clasificacion,
                'mt-2 justify-content-between align-items-center'), 4, 1);

        }

        return append($r);
    }


    function menu()
    {
        $link_accesos_pagina = tab(
            text_icon("fa-check-circle", "Accesos por página"),
            '#tab_accesos_pagina',
            [
                "class" => "btn_acceso_paginas"
            ]
        );

        $link_indicadores = tab(
            text_icon('fa fa-globe', "indicadores"),
            '#tab_default_1',
            [
                "class" => 'text-uppercase text-uppercase btn_menu_tab cotizaciones black'
            ]
        );

        $link_productos_solicitados = tab(
            text_icon("fa fa-shopping-cart", "productos solicitados"),
            '#tab_busqueda_productos'
        );


        $link_tipos_entregas = tab(

            text_icon("fa fa-fighter-jet", "tipos entregas"),
            "#tab_tipos_entregas"

        );

        $link_usuarios = tab(
            text_icon("fa fa-user", "usuarios"),
            "#tab_usuarios",
            [
                "class" => "text-uppercase black btn_repo_afiliacion text-uppercase",
            ]
        );

        $link_ventas_categorias = tab(
            text_icon("fa-check-circle", "ventas por categorías"),
            "#tab_productos_publicos"
        );

        $link_motivos_cancelaciones = tab(
            text_icon("fa-check-circle", "motivos - cancelaciones"),
            "#tab_motivos_cancelaciones"
        );

        $link_evaluaciones = tab(
            text_icon("fa-check-circle", "Evaluaciones"),
            "#tab_evaluaciones"
        );

        $link_top_ventas = tab(
            text_icon("fa-check-circle", "Top artículos vendidos"),
            "#tab_top_ventas"
        );
        $text = text_icon("fa-check-circle", "Top comisionistas");
        $text_entrega = text_icon("fa-check-circle", "Top reparto");

        $link_sin_ventas = tab(
            text_icon("fa-check-circle", "artículos sin ventas"),
            "#tab_sin_ventas"
        );

        $link_vendedores = a_enid(
            $text,
            [
                "href" => path_enid("top_competencia"),
                "class" => 'text-uppercase black'
            ]
        );

        $link_reparto = a_enid(
            $text_entrega,
            [
                "href" => path_enid("top_competencia_entrega"),
                "class" => 'text-uppercase black'
            ]
        );


        $list = [
            tab(
                text_icon(_mas_opciones_icon, "Comisiones"),
                '#tab_comisionistas'
            ),
            tab(
                text_icon(_entregas_icon, "Repartidores"),
                '#tab_entregas'
            )
            ,
            tab(
                text_icon(_historia_icon, "Arquetipos"),
                '#tab_arquetipos'
            )
            ,
            a_enid(text_icon(_money_icon, "pedidos"),
                [
                    "id" => "btn_servicios",
                    "href" => path_enid("pedidos"),
                    "class" => "text-uppercase black   dispositivos",
                ]
            )

            ,
            a_enid(text_icon("fa-shopping-bag", "compras"),
                [
                    "id" => "btn_servicios",
                    "href" => path_enid("compras"),
                    "class" => "text-uppercase black dispositivos",
                ]
            )
            ,
            $link_indicadores
            ,
            a_enid(text_icon('fa fa-clock-o', "tiempo de venta"),
                [
                    "href" => path_enid("tiempo_venta"),
                    "class" => 'text-uppercase black',
                ]
            )
            ,

            $link_productos_solicitados
            ,
            $link_tipos_entregas
            ,
            $link_usuarios
            ,
            $link_ventas_categorias
            ,
            $link_motivos_cancelaciones
            ,
            $link_evaluaciones
            ,
            $link_top_ventas
            ,
            $link_sin_ventas
            ,
            $link_vendedores
            ,
            $link_reparto
            ,
            $link_accesos_pagina

        ];

        return append($list);
    }
}
