<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('get_format_charts')) {
        function get_format_charts()
        {

            //$r[] = heading_enid("Indicadores", 3);
            //$r[] = get_menu_metricas();
            //$x[] = div(get_form_busqueda_desarrollo(), ["class" => "tab-pane fade in active", "id" => "tab_1_actividad"]);
            //$x[] = div(place("place_metricas_comparativa"), ["class" => "tab-pane fade", "id" => "tab_2_comparativa"]);
            $x[] = div(form_busqueda_desarrollo_solicitudes(), ["class" => "tab-pane fade", "id" => "tab_3_comparativa"]);
            $r[] = div(append_data($x), "tab-content");
            return append_data($r);


        }

    }
    if (!function_exists('get_form_busqueda_desarrollo_solicitudes')) {
        function form_busqueda_desarrollo_solicitudes()
        {

            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo_solicitudes']);
            $r[] = get_format_fecha_busqueda();
            $r[] = form_close(place("place_metricas_servicio"));
            return append_data($r);

        }
    }
    if (!function_exists('get_form_busqueda_desarrollo')) {
        function get_form_busqueda_desarrollo()
        {

            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo']);
            $r[] = get_format_fecha_busqueda();
            $r[] = form_close(place("place_metricas_desarrollo"));
            return append_data($r);

        }
    }
    if (!function_exists('get_menu')) {
        function get_menu($activa)
        {


            $list = [
                li(
                    anchor_enid("ABRIR TICKET",
                        [
                            "href" => "#tab_nuevo_ticket",
                            "data-toggle" => "tab",
                            "class" => "a_enid_blue abrir_ticket"
                        ]),
                    'black  ' . valida_seccion_activa(3, $activa)

                ),



                li(
                    anchor_enid(
                        text_icon('fa fa-check-circle', "PENDIENTES")
                        ,
                        [
                            "href" => "#tab_abrir_ticket"
                            , "data-toggle" => "tab"
                            , "id" => 'base_tab_clientes'
                            , "class" => 'black strong base_tab_clientes top_30'
                        ]) . place('place_tareas_pendientes'),


                    [
                        "class" => 'black  ' . valida_seccion_activa(1, $activa),
                        "style" => 'background:white;'
                    ]
                )


            ];

            return ul($list);
        }
    }
    if (!function_exists('get_menu_metricas')) {

        function get_menu_metricas()
        {

            $list = [
                li(
                    anchor_enid("Atención al cliente",
                        [
                            "href" => "#tab_1_actividad",
                            "data-toggle" => "tab"
                        ]),
                    "active"
                ),
                li(
                    anchor_enid("Comparativa",
                        [
                            "href" => "#tab_2_comparativa",
                            "data-toggle" => "tab"
                        ]), "comparativa"
                ),
                li(
                    anchor_enid("Calidad y servicio",
                        [
                            "href" => "#tab_3_comparativa",
                            "data-toggle" => "tab"
                        ]), "calidad_servicio"
                )
            ];

            return ul($list, "nav nav-tabs");

        }
    }
}

