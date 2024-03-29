<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function tiempos()
    {
        $tiempos[] = [
            'tiempo' => 5,
            'tiempo_estimado' => '5 minutos'
        ];
        $tiempos[] = [
            'tiempo' => 10,
            'tiempo_estimado' => '10 minutos'
        ];
        $tiempos[] = [
            'tiempo' => 15,
            'tiempo_estimado' => '15 minutos'
        ];
        $tiempos[] = [
            'tiempo' => 30,
            'tiempo_estimado' => '30 minutos'
        ];
        $tiempos[] = [
            'tiempo' => 45,
            'tiempo_estimado' => '45 minutos'
        ];
        $tiempos[] = [
            'tiempo' => 60,
            'tiempo_estimado' => '1 hora'
        ];
        $tiempos[] = [
            'tiempo' => 120,
            'tiempo_estimado' => '2 horas'
        ];
        $tiempos[] = [
            'tiempo' => 240,
            'tiempo_estimado' => '4 horas'
        ];
        $tiempos[] = [
            'tiempo' => 880,
            'tiempo_estimado' => '8 horas'
        ];
        return $tiempos;
    }

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

    function titulo_tablero($class_backlog, $titulo)
    {

        return h(
            text_icon(_text('fa fa-angle-up font-weight-bold ', $class_backlog), $titulo),
            5,
            " text-uppercase font-weight-bold "
        );

    }

    function widget_content($asunto, $id_ticket, $target)
    {
        return
            d(
                $asunto,
                [
                    "class" =>
                        _text(
                            "row ui-widget-content border draggable padding_10 shadow  cursor_pointer ver_detalle_ticket ",
                            $target),
                    "id" => $id_ticket,

                ]
            );
    }

    function format_tablero($tickets, $comparativa)
    {

        $ab[] = titulo_tablero('up_ab', "[AB]");
        $backlog[] = titulo_tablero('up_backlog', "Backlog");
        $pendiente[] = titulo_tablero('up_pendiente', "Pendiente");
        $haciendo[] = titulo_tablero('up_proceso', "Proceso");
        $hecho[] = titulo_tablero('up_hecho', "hecho");
        $revision[] = titulo_tablero('up_revision', "Revisión");

        foreach ($tickets as $row) {

            $id_ticket = $row["id_ticket"];
            $tiempo_estimado = $row['tiempo_estimado'];

            $tiempo = search_bi_array(tiempos(), 'tiempo', $tiempo_estimado, 'tiempo_estimado', 0);
            $base_tiempo = ($tiempo != 0) ? _text_('[', $tiempo, ']') : '';
            $asunto = p(_text_($base_tiempo, $row["asunto"]), 'text-uppercase asunto_tarea');
            $efecto_monetario = $row["efecto_monetario"];
            $asunto = flex($asunto, crea_estrellas($efecto_monetario, 1), 'flex-column justify-content-between contenedor_tarea');

            switch ($row["status"]) {

                case 7:

                    $ab[] = widget_content($asunto, $id_ticket, 'ab_target');

                    break;

                case 5:

                    $backlog[] = widget_content($asunto, $id_ticket, 'backlog_target');

                    break;


                case 0:

                    $pendiente[] = widget_content($asunto, $id_ticket, 'blue_target');

                    break;

                case 1:

                    $haciendo[] = widget_content($asunto, $id_ticket, 'proceso_target');

                    break;
                case 2:

                    $text = flex(
                        $asunto,
                        icon("fas fa-check-circle hecho",
                            [
                                "id" => $id_ticket
                            ]
                        ),
                        'justify-content-between'
                    );

                    $hecho[] = widget_content($text, $id_ticket, 'hecho_target');

                    break;

                case 6:

                    $revision[] = widget_content($asunto, $id_ticket, 'revision_target');

                    break;
            }
        }

        $base = 'col border mh_700 droppable';
        $response[] = d($ab,
            [
                "class" => _text($base, " bloque_ab"),
                "id" => 7,
            ]
        );
        $response[] = d($backlog,
            [
                "class" => _text($base, " bloque_backlog"),
                "id" => 5,
            ]
        );
        $response[] = d($pendiente,
            [
                "class" => _text($base, " bloque_pendiente"),
                "id" => 0,
            ]
        );
        $response[] = d($haciendo,
            [
                "class" => _text($base, " bloque_haciendo"),
                "id" => 1,
            ]
        );
        $response[] = d(

            $hecho,
            [
                "class" => _text($base, " bloque_hecho"),
                "id" => 2,
            ]
        );
        $response[] = d($revision, [
                "class" => _text($base, " bloque_revision"),
                "id" => 6,
            ]
        );


        $contenido[] = contaiter(seccion_comparativa($comparativa), 'mt-5 mb-5');
        $link_liberacion = format_link(
            "Liberar tareas realizadas",
            [
                "class" => "liberar col-sm-3"
            ]
        );
        $contenido[] = contaiter($link_liberacion, 'mt-5 mb-5');
        $contenido[] = contaiter($response);
        return append($contenido);

    }

    function seccion_comparativa($comparativa)
    {
        $seccion_comparativa = [];

        $format = 'col-sm-4 border text-center border-secondary';

        foreach ($comparativa as $row) {

            $totales = [
                flex(_titulo('Logros de mes', 4), $row['mensual'], 'flex-column'),
                flex(_titulo('Logros de la semana pasada', 4), $row['semana_anterior'], 'flex-column'),
                flex(_titulo('Logros de esta semana', 4), $row['semanal'], 'flex-column'),

            ];


            $seccion_comparativa[] = d_c($totales, $format);
        }
        return $seccion_comparativa;

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

    function frm_ticket($departamentos)
    {


        $r[] = form_open("", ["class" => 'form_ticket']);
        $r[] = hiddens(
            [
                "name" => "prioridad",
                "value" => "1",
            ]
        );
        $r[] = hiddens(
            [
                "name" => "mensaje",
                "id" => "mensaje",
                "class" => "mensaje",
            ]
        );

        $r[] = create_select(
            $departamentos,
            "departamento",
            "form-control d-none",
            "departamento",
            "nombre",
            "id_departamento"
        );


        $solicitud = input_frm('', 'Solicitud',
            [
                "id" => "asunto",
                "name" => "asunto",
                "required" => true,
                "type" => "text",
                "placeholder" => 'Ej. realizar compra'
            ]
        );

        $registro = btn("Solicitar", ['class' => _mbt5_md]);

        $r[] = d(_titulo('¿cual es la tarea?', 0, 'mb-5'));

        $label_tiempo = _titulo('¿tiempo estimado que se invertirá en realizar esta tarea?', 3);
        $tiempo_estimado_select = create_select(tiempos(), 'tiempo_estimado',
            'form-control',
            'tiempo_estimado', 'tiempo_estimado', 'tiempo');


        $tiempos[] = dd($label_tiempo, $tiempo_estimado_select);
        $tiempos[] = d(btn('Registrar'), 'mt-3 registro_tiempo_tarea');

        $r[] = flex_md($solicitud, $registro, _between, _8p, _4p);

        $r[] = form_close();

        $reponse[] = d($r, 'col-lg-8 col-lg-offset-2 mb-5 p-0');
        $reponse[] = gb_modal(append($tiempos), 'modal_tiempo_tarea');
        return append($reponse);


    }


    function form_cancelar_compra($id_orden_compra, $recibo, $modalidad)
    {
        $r = [];
        foreach ($recibo as $row){

            $x[] = _titulo("¿REALMENTE DESEAS CANCELAR LA COMPRA?");
            $x[] = d($row["resumen"], 'mt-5 mb-5');
            $r[] = d($x);
            $url = path_enid("area_cliente_compras", $id_orden_compra);
            $r[] = btn("SEGUIR COMPRANDO",
                [

                    "class" => "top_30",

                ],
                1,
                1, 0, $url);

            $r[] = btn("CANCELAR ÓRDEN DE COMPRA",
                [
                    "class" => "cancelar_orden_compra top_20",
                    "id" => $id_orden_compra,
                    "modalidad" => $modalidad,
                ],
                1,
                1);

        }


        return d($r, _6auto);
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
                $tiempo_estimado = $row['tiempo_estimado'];

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


                $calendario[] = form_tiempo_estimado($tiempo_estimado, $id_ticket);
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

    function form_tiempo_estimado($tiempo_estimado, $id_ticket)
    {
        $select = tiempos();
        $form[] = form_open("", [
            "class" => "form_tiempo_estimado d-flex align-items-center w-100",
        ]);
        $form[] = _titulo('tiempo estimado', 4);
        $ext = is_mobile() ? '' : 'w-25';


        $clase_icon = _text_(_editar_icon, 'editar_tiempo_estimado');

        $base_tiempo = d('TIEMPO AÚN SIN SER DEFINIDO', 'ml-5');
        if ($tiempo_estimado < 1) {

            $form[] = d(text_icon($clase_icon, $base_tiempo), 'ml-5 sin_tiempo');

        } else {


            $tiempo_text = d(search_bi_array($select, 'tiempo', intval($tiempo_estimado), 'tiempo_estimado', $base_tiempo), 'ml-5');

            $form[] = d(text_icon($clase_icon, $tiempo_text), 'ml-5');
        }

        $form[] = create_select_selected($select, 'tiempo',
            'tiempo_estimado', $tiempo_estimado,
            'tiempo_estimado',
            _text_('tiempo_estimado form-control d-none ml-5', $ext));
        $form[] = hiddens(['name' => 'id_ticket', 'value' => $id_ticket]);
        $form[] = form_close();
        return append($form);
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

    function filtra_tarea($param)
    {

        $id_usuario = $param['id_usuario'];
        $base = " t.status != 4 AND id_usuario = $id_usuario ";
        $busqueda = $param['keyword'];
        $keyword = _text_('AND t.asunto LIKE ', '"%', $busqueda, '%"');
        $filtro = str_len($busqueda, 0) ? _text_($base, $keyword) : $base;
        return $filtro;

    }

}