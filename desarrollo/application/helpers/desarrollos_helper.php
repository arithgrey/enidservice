<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_ticket_empresa($data)
    {

        $activa = $data["activa"];
        $z[] = form_ticket_dep(
            $data["departamentos"],
            $data["num_departamento"]
        );
        $z[] = place('place_proyectos');
        $z[] = place('place_tickets');
        $abrir_ticket = append($z);

        $r[] = tab_seccion(
            $abrir_ticket,
            'tab_abrir_ticket',
            valida_seccion_activa(1, $activa)
        );

        $r[] = tab_seccion(
            place("place_form_tickets"),
            'tab_nuevo_ticket',
            valida_seccion_activa(3, $activa)
        );

        $tab_content = tab_content($r);

        $response[] = hrz(
            menu($activa),
            $tab_content,
            2
        );

        $response[] = hiddens(
            [
                "class" => "ticket",
                "value" => $data["ticket"],
            ]
        );
        $response[] = hiddens(
            [
                "class" => 'id_usuario',
                "value" => $data["id_usuario"]
            ]
        );

        return append($response, "contenedor_principal_enid_service");


    }

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
            create_select(
                $departamentos,
                "depto",
                "form-control input-sm depto",
                "depto",
                "nombre",
                "id_departamento"
            )
            ,
            "formulario_busqueda_tickets align-items-center justify-content-between"
        );

        $r[] = hiddens(
            [
                "name" => "departamento",
                "value" => $total,
                "id" => 'num_departamento',
                "class" => 'num_departamento'
            ]
        );
        return d(d(append($r), "col-lg-6 col-lg-offset-3 "), 13);

    }


    function menu($activa)
    {


        $list = [

            tab(
                "ABRIR TICKET",
                '#tab_nuevo_ticket'
                ,
                [
                    'id' => 'abrir_ticket',
                    'class' => 'black a_enid_blue abrir_ticket ' . valida_seccion_activa(3, $activa)

                ]
            )

            ,

            tab(

                text_icon('fa fa-check-circle', "PENDIENTES"),
                '#tab_abrir_ticket',
                [
                    "id" => 'base_tab_clientes',
                    'class' => 'black strong base_tab_clientes top_30' . valida_seccion_activa(1, $activa)
                ]
            )
        ];

        return append($list);
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

//        function form_busqueda_desarrollo_solicitudes()
//        {
//
//            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo_solicitudes']);
//            $r[] = frm_fecha_busqueda();
//            $r[] = form_close(place("place_metricas_servicio"));
//            return append($r);
//
//        }
//
//        function get_form_busqueda_desarrollo()
//        {
//
//            $r[] = form_open("", ["class" => 'form_busqueda_desarrollo']);
//            $r[] = frm_fecha_busqueda();
//            $r[] = form_close(place("place_metricas_desarrollo"));
//            return append($r);
//
//        }
}

