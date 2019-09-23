<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('render_ticket_empresa')) {
        function render_ticket_empresa($data)
        {

            $activa = $data["activa"];
            $r[] = hiddens(["type" => 'hidden', "class" => 'id_usuario', "value" => $data["id_usuario"]]);
            $z[] = form_ticket_dep($data["departamentos"], $data["num_departamento"]);
            $z[] = d(d(place('place_proyectos'), "top_50"), 1);
            $z[] = d(place('place_tickets'), 1);
            $r[] = d(append($z), ["class" => "tab-pane " . valida_seccion_activa(1, $activa), "id" => 'tab_abrir_ticket']);
            $r[] = d(
                d(
                    place("place_form_tickets"), 1)
                ,
                [
                    "class" => "tab-pane " . valida_seccion_activa(3, $activa),
                    "id" => "tab_nuevo_ticket"
                ]
            );


            $response[] = hrz(
                ul(get_menu($activa), "nav tabs"),
                d(append($r), "tab-content"),
                2
            );

            $response[] = hiddens([
                "class" => "ticket",
                "value" => $data["ticket"],
            ]);

            return append($response, "contenedor_principal_enid_service");


        }
    }
    if (!function_exists('form_ticket_dep')) {
        function form_ticket_dep($departamentos, $total)
        {


            $r[] = flex(

                input_frm("", "Busqueda",
                    [
                        "name" => "q",
                        "class" => "q",
                        "type" => "text",
                        "id" => "q_busqueda"
                    ]
                )


                ,

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
                        hiddens(
                            [
                                "name" => "departamento",
                                "value" => $total,
                                "id" => 'num_departamento',
                                "class" => 'num_departamento'
                            ]
                        )

                    ]
                )

                ,
                "formulario_busqueda_tickets align-items-center justify-content-between"
            );

            return d(d(append($r), "col-lg-6 col-lg-offset-3 "), 13);

        }
    }

    if (!function_exists('frm_busqueda_desarrollo')) {
        function form_busqueda_desarrollo_solicitudes()
        {

            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo_solicitudes']);
            $r[] = frm_fecha_busqueda();
            $r[] = form_close(place("place_metricas_servicio"));
            return append($r);

        }
    }
    if (!function_exists('get_form_busqueda_desarrollo')) {
        function get_form_busqueda_desarrollo()
        {

            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo']);
            $r[] = frm_fecha_busqueda();
            $r[] = form_close(place("place_metricas_desarrollo"));
            return append($r);

        }
    }
    if (!function_exists('get_menu')) {
        function get_menu($activa)
        {


            $list = [
                li(
                    a_enid("ABRIR TICKET",
                        [
                            "href" => "#tab_nuevo_ticket",
                            "data-toggle" => "tab",
                            "class" => "a_enid_blue abrir_ticket"
                        ]),
                    'black  ' . valida_seccion_activa(3, $activa)

                ),


                li(
                    a_enid(
                        text_icon('fa fa-check-circle', "PENDIENTES")
                        ,
                        [
                            "href" => "#tab_abrir_ticket"
                            , "data-toggle" => "tab"
                            , "id" => 'base_tab_clientes'
                            , "class" => 'black strong base_tab_clientes top_30'
                        ]) . place('place_tareas_pendientes'),


                    [
                        "class" => 'black  ' . valida_seccion_activa(1, $activa)

                    ]
                )


            ];

            return ul($list);
        }
    }
    /*
    if (!function_exists('get_menu_metricas')) {

        function get_menu_metricas()
        {

            $list = [
                li(
                    a_enid("Atención al cliente",
                        [
                            "href" => "#tab_1_actividad",
                            "data-toggle" => "tab"
                        ]),
                    "active"
                ),
                li(
                    a_enid("Comparativa",
                        [
                            "href" => "#tab_2_comparativa",
                            "data-toggle" => "tab"
                        ]), "comparativa"
                ),
                li(
                    a_enid("Calidad y servicio",
                        [
                            "href" => "#tab_3_comparativa",
                            "data-toggle" => "tab"
                        ]), "calidad_servicio"
                )
            ];

            return ul($list, "nav nav-tabs");

        }
    }
    */
}

