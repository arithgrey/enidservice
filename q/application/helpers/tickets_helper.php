<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function solicitudes_saldo($data)
    {


        $solicitud_saldo = $data["solicitud_saldo"];
        $_response[] = d(h("ULTIMOS MOVIMIENTOS", 1, "titulo_enid"), "jumbotron");

        if (count($solicitud_saldo) > 0):

            $_response[] = d("SOLICITUDES DE SALDO A TUS AMIGOS", 'titulo_enid_sm_sm');

        endif;


        foreach ($solicitud_saldo as $row):

            $response[] = tr(td(d("Folio # " . $row["id_solicitud"], 'folio'),
                ["colspan" => "2"]));

            $y[] = td(
                d(
                    span("SOLICITUD DE SALDO A" . $row["email_solicitado"],
                        'monto_solicitado')
                    ,
                    "desc_solicitud"
                )
            );
            $y[] = td($row["monto_solicitado"] . "MXN", 'monto_solicitud_text');

            $response[] = tr(append($y));


            $r[] =
                td(
                    d(
                        span("SOLICITUD DE SALDO A" . $row["email_solicitado"],
                            'monto_solicitado')
                        ,
                        "desc_solicitud"
                    )
                );

            $r[] = td($row["monto_solicitado"] . "MXN", 'monto_solicitud_text');

            $response[] = tr(append($r));
            $re[] = tb(append($response));
            $_response[] = d(append($re), 'list-group-item-movimiento');


        endforeach;

        return append($_response);


    }


    function format_tablero($tickets)
    {

        $title_ab = text_icon('fa fa-angle-up up_ab', "[AB]");
        $ab[] = h(
            $title_ab,
            5,
            "text-uppercase "
        );

        $title_backlog = text_icon('fa fa-angle-up up_backlog', "Backlog");
        $title_backlog = h($title_backlog, 5, " text-uppercase ");
        $backlog[] = d($title_backlog);


        $pendiente = text_icon('fa fa-angle-up up_pendiente', "Pendiente");
        $pendiente = h($pendiente, 5, " text-uppercase ");
        $pendiente[] = d($pendiente);

        $haciendo = h(text_icon('fa fa-angle-up up_proceso', "Proceso"), 5, " text-uppercase ");
        $haciendo[] = d($haciendo);
        $hecho = h(text_icon('fa fa-angle-up up_hecho', "hecho"), 5, " text-uppercase ");
        $hecho[] = d($hecho);

        $revision = h(text_icon('fa fa-angle-up up_revision', "Revisión"), 5,
            " text-uppercase ");
        $revision[] = d($revision);

        foreach ($tickets as $row) {

            $id_ticket = $row["id_ticket"];
            $asunto = $row["asunto"];
            $efecto_monetario = $row["efecto_monetario"];
            $asunto = flex($asunto, crea_estrellas($efecto_monetario, 1), "flex-column");

            switch ($row["status"]) {


                case 7:

                    $ab[] = d(
                        d($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 
                            shadow ab_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket,

                        ]
                    );

                    break;


                case 5:

                    $backlog[] = d(
                        d($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow  backlog_target 
                            cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket,

                        ]
                    );

                    break;


                case 0:

                    $pendiente[] = d(
                        d($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket,
                        ]
                    );

                    break;

                case 1:

                    $haciendo[] = d(
                        d($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow 
                            proceso_target 
                            cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket,

                        ]
                    );

                    break;
                case 2:

                    $text = ajustar(
                        $asunto,
                        icon("fas fa-check-circle hecho",
                            [
                                "id" => $id_ticket
                            ]
                        )
                    );
                    $hecho[] = d(
                        d(
                            $text, 12
                        ),
                        [
                            "class" => "row ui-widget-content border draggable padding_10
                             shadow hecho_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket,

                        ]
                    );


                    break;

                case 6:

                    $revision[] = d(d($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow revision_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket,

                        ]);

                    break;


            }
        }

        $response[] = d(append($ab), [
            "class" => "col-lg-2 border pading_10 mh_700 droppable bloque_ab",
            "id" => 7,
        ]);
        $response[] = d(append($backlog), [
            "class" => "col-lg-2 border pading_10 mh_700 droppable bloque_backlog",
            "id" => 5,
        ]);
        $response[] = d(append($pendiente), [
            "class" => "col-lg-2 border pading_10 mh_700 droppable bloque_pendiente",
            "id" => 0,
        ]);
        $response[] = d(append($haciendo), [
            "class" => "col-lg-2 border pading_10 mh_700 droppable bloque_haciendo",
            "id" => 1,
        ]);
        $response[] = d(append($hecho), [
            "class" => "col-lg-2 border pading_10 mh_700 droppable bloque_hecho",
            "id" => 2,
        ]);
        $response[] = d(append($revision), [
            "class" => "col-lg-2 border pading_10 mh_700 droppable bloque_revision",
            "id" => 6,
        ]);

        return append($response);

    }

    function get_format_tickets($departamentos)
    {

        $r[] = d(d("ABRIR SOLICITUD", "titulo_enid"), 6, 1);
        $r[] = d(get_form_ticket($departamentos), 6, 1);
        $r[] = place("place_registro_ticket");

        return append($r);

    }

    function get_form_respuesta($tarea)
    {

        $r[] = form_open("", ["class" => "form_respuesta_ticket top_20"]);
        $r[] = h("COMENTARIO", 3);
        $r[] = textarea(
            [
                "class" => "form-control",
                "id" => "mensaje",
                "name" => "mensaje",
                "required" => "",
            ]);
        $r[] = hiddens(["name" => "tarea", "value" => $tarea]);
        $r[] = btn("Enviar");
        $r[] = form_close();

        return append($r);

    }

    function get_form_ticket($departamentos)
    {


        $r[] = form_open("", ["class" => 'form_ticket']);
        $r[] = hiddens(
            [
                "name" => "prioridad",
                "value" => "1",
            ]);
        $r[] = hiddens(
            [
                "name" => "mensaje",
                "id" => "mensaje",
                "class" => "mensaje",
            ]);
        $r[] = d("DEPARTAMENTO AL CUAL SOLICITAS", 1);
        $r[] = addNRow(
            create_select(
                $departamentos,
                "departamento",
                "form-control",
                "departamento",
                "nombre",
                "id_departamento"
            ));
        $r[] = n_row_12();
        $r[] = d("MODULO, ASUNTO, TÓPICO", "input-group-addon");
        $r[] = input(
            [
                "id" => "asunto",
                "name" => "asunto",
                "class" => "form-control",
                "placeholder" => "MODULO, ASUNTO, TÓPICO",
                "required" => "true",
                "type" => "text",
            ]);
        $r[] = end_row();
        $r[] = btn("ABRIR TICKET");
        $r[] = form_close();

        return append($r);


    }


    function form_cancelar_compra($recibo, $modalidad)
    {

        $x[] = h("¿REALMENTE DESEAS CANCELAR LA COMPRA?", 3);
        $x[] = d($recibo["resumen"]);
        $r[] = d(d(append($x), "padding_20"));
        $url = path_enid("area_cliente_compras", $recibo['id_recibo']);
        $r[] = btn("SEGUIR COMPRANDO",
            [

                "class" => "top_30",

            ],
            1,
            1, 0, $url);

        $r[] = btn("CANCELAR ÓRDEN DE COMPRA",
            [
                "class" => "cancelar_orden_compra top_20",
                "id" => $recibo['id_recibo'],
                "modalidad" => $modalidad,
            ],
            1,
            1);


        return d(append($r), 6, 1);
    }

    function valida_check_tarea($id_tarea, $valor_actualizar, $status)
    {

        $config = [
            "type" => 'checkbox',
            "class" => 'tarea ',
            "id" => $id_tarea,
            "value" => $valor_actualizar,
        ];


        if ($status > 0) {
            $config += ["checked" => 1];
        }


        return d(input($config, 0, 0), 1);

    }

    function valida_mostrar_tareas($data)
    {

        $r = [];
        if (es_data($data)) {

            $r[] = d("MOSTRAR SÓLO TAREAS PENDIENTES",
                'menu_tareas_pendientes a_enid_black cursor_pointer');
            $r[] = d("MOSTRAR TODAS LAS TAREAS",
                'mostrar_todas_las_tareas a_enid_black cursor_pointer');

        }

        return append($r);
    }

    function crea_tabla_resumen_ticket($data)
    {


        $info_ticket = $data['info_ticket'];
        $num_tareas = $data['info_num_tareas'];

        $response = [];
        if (es_data($num_tareas)) {

            $tareas = pr($num_tareas, "tareas");
            $pendientes = $tareas - pr($num_tareas, "pendientes");

            $r = [];

            foreach ($info_ticket as $row) {

                $id_ticket = $row["id_ticket"];
                $resumen = $pendientes . " / " . $tareas;
                $asunto = $row["asunto"];
                $efecto_monetario = $row["efecto_monetario"];
                $nota_monetaria = $row["nota_monetaria"];
                $efectivo_resultante = $row["efectivo_resultante"];
                $clientes_ab = $row["clientes_ab"];

                $cerrar =
                    btn(
                        "CERRAR",
                        [
                            "onClick" => "cerrar_ticket({$id_ticket})",
                            "class" => "col-lg-3",
                        ],
                        0, 1, 0, 1
                    );

                $icon = ($pendientes != $tareas) ? "fa fa-check-circle text-secondary " : "fa fa-check-circle text-dark";


                $x[] = d(

                    btw(
                        h(add_text("#", $id_ticket, 1), 2),
                        $cerrar,
                        "d-flex align-items-center justify-content-between"
                    )
                );


                $calendario[] = form_open("", ["class" => 'frm_agendar_google']);
                $calendario[] = d(h(add_text(text_icon($icon, $resumen), "TAREAS"), 5));
                $calendario[] = hiddens([
                    "class" => "descripcion_google",
                    "value" => $asunto,
                ]);
                $agendar = ajustar(input_hour_date(), btn("Agendar"), 4);
                $calendario[] = d("AGENDAR", "cursor_pointer  underline agendar_google");
                $calendario[] = ajustar($agendar, "", 8, "hidden seccion_agendar");
                $calendario[] = form_close();


                $x[] = append($calendario);
                //$x[] = d(h(add_text("DEPARTAMENTO", strtoupper($row["nombre_departamento"])), 6));
                $x[] = d(add_text(icon("fa fa-pencil asunto", ["id" => $id_ticket]),
                    $asunto), "top_30 border padding_10 bottom_30 s_desc_asunto");


                $x[] = d(
                    ajustar(
                        d("TAREA: "),
                        input([
                                "class" => "input_asunto",
                                "value" => $asunto,
                            ]
                        )
                    ), "col-lg-6 display_none i_desc_asunto");


                $x[] = crea_estrellas($efecto_monetario);

                $menus_monetarios = [
                    d("Nota monetaria",
                        "strong menu_nota_monetaria underline cursor_pointer"),
                    d("Efectivo resultante ",
                        "strong menu_efectivo_resultante underline cursor_pointer ml-5"),
                    d("Clientes resultantes",
                        "strong menu_clientes_ab_testing underline cursor_pointer ml-5"),
                ];

                $x[] = flex($menus_monetarios);
                $x[] = d($nota_monetaria, "nota_monetaria");
                $x[] = frm_efectivo_resultante($id_ticket, $efectivo_resultante);
                $x[] = frm_clientes_ab_testing($id_ticket, $clientes_ab);
                $x[] = form_open("",
                    ["class" => "frm_nota_monetaria nota_monetaria_area d-none mb-5"]);
                $x[] =
                    hrz(
                        textarea(
                            [
                                "name" => "nota_monetaria",
                                "value" => $nota_monetaria,
                            ],
                            0,
                            $nota_monetaria
                        ),
                        btn("AGREGAR")
                        ,
                        9
                        ,
                        "strong  underline cursor_pointer mt-5 mb-5 row"

                    );
                $x[] = form_close();
                $x[] = d(icon("fas fa-2x fa-plus-circle blue_enid"),
                    "boton_agregar_tarea padding_1  cursor_pointer text-right");
                $r[] = d(append($x), "shadow padding_20");

            }

            $response[] = append($r);
            $response[] = valida_mostrar_tareas($num_tareas);

        }

        return append($response);

    }

    function frm_efectivo_resultante($id_ticket, $efectivo_resultante)
    {

        $r[] = form_open("",
            ["class" => "frm_efectivo_resultante mt-5 mb-5 col-md-5 d-none"]);

        $r[] = flex(
            input_frm(0, "MXN",
                [
                    "type" => "number",
                    "step" => "any",
                    "id" => "efectivo_resultante",
                    "class" => "input_efectivo_resultante",
                    "name" => "efectivo_resultante",
                    "placeholder" => "1000",
                    "min" => 0,
                    "maxlength" => 6,
                    "value" => $efectivo_resultante,

                ]
            ),
            btn("GUARDAR", [], 0),
            "d-flex justify-content-between", "row mr-auto", "row"
        );

        $r[] = hiddens(["name" => "id_ticket", "value" => $id_ticket]);
        $r[] = form_close();
        $text_efectivo = flex("EFECTIVO RESULTANTE ",
            formated_link(money($efectivo_resultante)), 'align-items-end',
            '', 'ml-3');
        $response[] = contaiter(d($text_efectivo, "col-lg-12 strong m-0 p-0"),
            "mt-5 resumen_efectivo_resultante");
        $response[] = contaiter(append($r), "mb-5");

        return append($response);

    }


    function frm_clientes_ab_testing($id_ticket, $clientes_ab)
    {

        $r[] = form_open("",
            ["class" => "frm_clientes_ab_testing mt-5 mb-4 col-md-5 d-none"]);

        $r[] = flex(
            input_frm(0, "NÚMERO DE CLIENTES",
                [
                    "type" => "number",
                    "step" => "any",
                    "id" => "clientes_ab",
                    "class" => "input_clientes_ab",
                    "name" => "clientes_ab",
                    "placeholder" => "10",
                    "min" => 0,
                    "maxlength" => 6,
                    "value" => $clientes_ab,

                ]
            ),
            btn("GUARDAR", [], 0),
            "d-flex justify-content-between", "row mr-auto", "row"
        );

        $r[] = hiddens(["name" => "id_ticket", "value" => $id_ticket]);
        $r[] = form_close();
        $text = flex("CLIENTES AB TESTING RESULTANTES ", formated_link($clientes_ab),
            'align-items-end',
            'mr-3'
        );
        $response[] = contaiter(d($text, "col-lg-12 strong m-0 p-0"),
            "mt-5 resumen_clientes_ab");
        $response[] = contaiter(append($r), "mb-5");

        return append($response);

    }

    function form_tarea()
    {

        $x[] = h("TAREA", 4);
        $x[] = form_open("", ["class" => 'form_agregar_tarea']);
        $x[] = d("-", ["id" => "summernote", "class" => "summernote"], 1);
        $x[] = hiddens(["class" => 'tarea_pendiente', "name" => 'tarea']);
        $x[] = btn("Solicitar", [], 1);
        $x[] = form_close();

        return d(append($x), "seccion_nueva_tarea top_20");

    }

    function format_listado_tareas($data)
    {

        $tareas = $data['info_tareas'];
        $r = [];
        foreach ($tareas as $row) {

            $id_tarea = $row["id_tarea"];
            $status = $row["status"];
            $estado_tarea = "";


            if ($status == 0) {

                $valor_actualizar = 1;

            } else {

                $valor_actualizar = 0;
                $estado_tarea = "tarea_pendiente";

            }

            $input = valida_check_tarea($id_tarea, $valor_actualizar, $status);
            $descripcion = ($status > 0) ? del($row["descripcion"],
                "descripcion_tarea  cursor_pointer") : $row["descripcion"];


            $menu = [];
            $menu[] = icon(" fa-ellipsis-h ml-3 ", ["data-toggle" => "dropdown"]);
            $menu[] = d(
                append(
                    [

                        d(
                            text_icon("fas fa-minus cursor_pointer",
                                "Quitar"),
                            [
                                "class" => "top_5  cursor_pointer",
                                "onClick" => "elimina_tarea({$id_tarea})",
                            ]
                        ),

                    ]
                ),
                "dropdown-menu  padding_20"
            );

            $bloque_descripcion = append(
                [
                    d(
                        $descripcion,
                        [
                            "class" => "contenedor_descripcion cursor_pointer text_tarea_" . $id_tarea,
                            "onClick" => "edita_descripcion_tarea({$id_tarea})",
                        ]
                    ),
                    d(
                        input(
                            [
                                "name" => "descripcion",
                                "value" => $row["descripcion"],
                                "type" => "text",
                                "class" => "itarea_" . $id_tarea,
                            ]
                        )
                        ,
                        [
                            "class" => "input_descripcion",
                            "id" => "tarea_" . $id_tarea,
                        ]

                    ),
                ]
            );


            $descripcion = btw(
                d($bloque_descripcion)
                ,
                d(append($menu), "btn-group")
                ,
                " d-flex align-items-center justify-content-between  "
            );


            $text = btw(

                $input
                ,
                $descripcion
                ,
                "d-flex align-items-center justify-content-between "

            );


            $r[] = d($text, $estado_tarea . ' top_30   ');


        }

        $x[] = h(text_icon("fa fa-check-square", "Checklist"), 5, "strong underline");
        $x[] = d(append($r), 1);

        return d(append($x), "top_40 padding_20 contenedor_tareas bottom_50");


    }

    function format_tareas($data)
    {

        $r[] = crea_tabla_resumen_ticket($data);
        $r[] = form_tarea();
        $r[] = format_listado_tareas($data);

        return append($r);

    }

}