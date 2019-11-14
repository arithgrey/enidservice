<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function render_reporte($data)
    {

        $response[] = tab_seccion(place("place_reporte"), 'reporte');
        $response[] = format_indicadores();
        $response[] = format_dispositivos();
        $response[] = format_visitas();
        $response[] = format_tipo_entrega();
        $response[] = format_actividad();
        $response[] = format_productos_solicitados();
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

        return tab_seccion($r, "tab_productos_publicos");
    }

    /**
     * @param array $b
     * @param array $response
     * @return array
     */
    function format_productos_solicitados()
    {
        $form = base_busqueda_form('PRODUCTOS MÁS BUSCADOS POR CLIENTES',
            'form_busqueda_productos_solicitados', 'place_keywords');

        return tab_seccion($form, "tab_busqueda_productos");

    }


    function format_actividad()
    {

        $form = base_busqueda_form('ACTIVIDAD',
            'f_actividad_productos_usuarios', 'repo_usabilidad');

        return tab_seccion($form, 'tab_usuarios');

    }

    function format_tipo_entrega()
    {

        $form = base_busqueda_form('TIPOS DE ENTREGAS', 'form_tipos_entregas',
            'place_tipos_entregas');

        return tab_seccion($form, 'tab_tipos_entregas');
    }

    function format_visitas()
    {

        $form = base_busqueda_form('visitas web', 'f_usabilidad',
            'place_usabilidad_general');

        return tab_seccion($form, 'tab_default_2');

    }

    function format_dispositivos()
    {

        $form = base_busqueda_form(
            'dispositivos',
            'f_dipositivos',
            'repo_dispositivos'
        );
        return tab_seccion($form, 'tab_dispositivos');

    }

    function format_indicadores()
    {
        $form = base_busqueda_form(
            "indicadores", 'form_busqueda_global_enid', "place_usabilidad");

        return tab_seccion($form, 'tab_default_1', 1);


    }

    function base_busqueda_form($titulo_seccion, $clase_form, $place)
    {

        $r[] = h($titulo_seccion, 3, "mb-5 h3 text-uppercase strong");
        $r[] = form_open("", ["class" => $clase_form]);
        $r[] = frm_fecha_busqueda();
        $r[] = form_close();
        $r[] = place($place . " mt-5");

        return append($r);
    }

//
//    function frm_busqueda_desarrollo()
//    {
//
//        $f[] = form_open("", ["class" => 'form_busqueda_desarrollo_solicitudes']);
//        $f[] = frm_fecha_busqueda();
//        $f[] = form_close();
//        $r[] = addNRow(append($f));
//        $r[] = addNRow(place("place_metricas_servicio"));
//
//        return append($r);
//
//    }

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
                "class" => "text-uppercase black   btn_repo_afiliacion text-uppercase",
            ]
        );

        $link_ventas_categorias = tab(
            text_icon("fa-check-circle", "ventas por categorias"),
            "#tab_productos_publicos"
        );


        $link_actividad = tab(
            text_icon("fa fa-flag", "actividad"),
            "#tab_default_2",
            [
                "id" => "btn_servicios",
                "class" => "text-uppercase black   usabilidad_btn",
            ]
        );

        $link_dispositivos = tab(
            text_icon("fa fa-mobile", "dispositivos"),
            "#tab_dispositivos",
            [
                "id" => "btn_servicios",
                "class" => "text-uppercase black dispositivos",
            ]
        );
        $list = [
            a_enid(text_icon("fa fa-money", "pedidos"),
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
                    "class" => "text-uppercase black   dispositivos",
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

            a_enid(text_icon('fa fa-exchange', "puntos de encuentro"),
                [
                    "href" => path_enid("ventas_encuentro"),
                    "class" => 'text-uppercase black  active',
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
            $link_actividad
            ,
            $link_dispositivos
        ];

        return append($list);
    }
}
