<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('render_ticket_empresa')) {
        function render_ticket_empresa($data)
        {

            $departamentos = $data["departamentos"];
            $num_departamento = $data["num_departamento"];
            $id_usuario = $data["id_usuario"];
            $activa = $data["activa"];
            $ticket = $data["ticket"];

            $r[] = input_hidden(["type" => 'hidden', "class" => 'id_usuario', "value" => $id_usuario]);
            $z[] = form_ticket_dep($departamentos, $num_departamento);
            $z[] = div(div(place('place_proyectos'), "top_50"), 1);
            $z[] = div(place('place_tickets'), 1);
            $r[] = div(append($z), ["class" => "tab-pane " . valida_seccion_activa(1, $activa), "id" => 'tab_abrir_ticket']);
            $r[] = div(
                div(
                    place("place_form_tickets"), 1)
                ,
                [
                    "class" => "tab-pane " . valida_seccion_activa(3, $activa),
                    "id" => "tab_nuevo_ticket"
                ]
            );

            $response[] = div(ul(get_menu($activa), "nav tabs"), 2);
            $response[] = div(div(append($r), "tab-content"), 10);
            $response[] = input_hidden([
                "class" => "ticket",
                "value" => $ticket,
            ]);

            return append($response, "contenedor_principal_enid_service");


        }
    }
    if (!function_exists('form_ticket_dep')) {
        function form_ticket_dep($departamentos, $num_departamento)
        {


            $r[] = div(text_icon("fa fa-search", "Ticket"), 4);
            $r[] = btw(
                div(
                    input(
                        [
                            "name" => "q",
                            "class" => "input-sm q",
                            "type" => "text"
                        ]
                    ),
                    4
                ),
                div(
                    append(
                        [
                            create_select(
                                $departamentos,
                                "depto",
                                "form-control input-sm depto",
                                "depto",
                                "nombre",
                                "id_departamento"
                            )
                            ,
                            input_hidden(
                                [
                                    "name" => "departamento",
                                    "value" => $num_departamento,
                                    "id" => 'num_departamento',
                                    "class" => 'num_departamento'
                                ]
                            )

                        ]
                    ),
                    4
                )
                ,
                "formulario_busqueda_tickets"
            );

            return append($r);

        }
    }
    if (!function_exists('get_format_charts')) {
        function get_format_charts()
        {

            $x[] = div(form_busqueda_desarrollo_solicitudes(), ["class" => "tab-pane fade", "id" => "tab_3_comparativa"]);
            $r[] = div(append($x), "tab-content");
            return append($r);


        }

    }
    if (!function_exists('get_form_busqueda_desarrollo_solicitudes')) {
        function form_busqueda_desarrollo_solicitudes()
        {

            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo_solicitudes']);
            $r[] = get_format_fecha_busqueda();
            $r[] = form_close(place("place_metricas_servicio"));
            return append($r);

        }
    }
    if (!function_exists('get_form_busqueda_desarrollo')) {
        function get_form_busqueda_desarrollo()
        {

            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo']);
            $r[] = get_format_fecha_busqueda();
            $r[] = form_close(place("place_metricas_desarrollo"));
            return append($r);

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

