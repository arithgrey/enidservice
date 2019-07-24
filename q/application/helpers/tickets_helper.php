<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function solicitudes_saldo($data)
    {


        $solicitud_saldo = $data["solicitud_saldo"];

        $_response[] = d(h("ULTIMOS MOVIMIENTOS", 1, ["class" => "titulo_enid"]), ["class" => "jumbotron"]);
        if (count($solicitud_saldo) > 0):
            $_response[] = d("SOLICITUDES DE SALDO A TUS AMIGOS", 'titulo_enid_sm_sm');
        endif;


        foreach ($solicitud_saldo as $row):

            $response[] = tr(td(d("Folio # " . $row["id_solicitud"], ["class" => 'folio']), ["colspan" => "2"]));

            $y[] = td(
                d(
                    span("SOLICITUD DE SALDO A" . $row["email_solicitado"], 'monto_solicitado')
                    ,
                    "desc_solicitud"
                )
            );
            $y[] = td($row["monto_solicitado"] . "MXN", ["class" => 'monto_solicitud_text']);

            $response[] = tr(append($y));


            $r[] =
                td(
                    d(
                        span("SOLICITUD DE SALDO A" . $row["email_solicitado"], 'monto_solicitado')
                        ,
                        "desc_solicitud"
                    )
                );

            $r[] = td($row["monto_solicitado"] . "MXN", ["class" => 'monto_solicitud_text']);


            $response[] = tr(append($r));
            $re[] = "<table>";
            $re[] = append($response);
            $re[] = "</table>";
            $_response[] = d(append($re), 'list-group-item-movimiento');


        endforeach;
        return append($_response);


    }

    function format_ticket_desarrollo($data)
    {

        $info_tickets = $data["info_tickets"];
        $r[] = h("# Resultados " . count($info_tickets), 3);
        $response = [];
        foreach ($info_tickets as $row) {

            $id_ticket = $row["id_ticket"];
            $asunto = $row["asunto"];

            $num_tareas_pendientes = $row["num_tareas_pendientes"];
            $tareas_pendientes = [
                "class" => 'strong white ver_detalle_ticket a_enid_black_sm',
                "id" => $id_ticket
            ];

            $id_usuario = $row["id_usuario"];

            $t[] = get_img_usuario($id_usuario);
            $t[] = d($asunto);
            $t[] = d("#Tareas pendientes:" . $num_tareas_pendientes,
                $tareas_pendientes,
                ["class" => "cursor_pointer"]
            );

            $r[] = d(append($t), "popup-head-left pull-left");;

            $z[] = btn(icon("fa fa-plus"), ["class" => "btn btn-secondary dropdown-toggle", "data-toggle" => "dropdown"]);
            $z[] = d(
                a_enid("CERRAR TICKET",
                    [
                        "class" => "cerrar_ticket",
                        "onClick" => "cerrar_ticket({$id_ticket})"
                    ]
                ), "dropdown-menu acciones_ticket");;

            $r[] = d(append($z), "dropdown pull-right");

            $response[] = d(d(append($r), "popup-head"), ["class" => "popup-box chat-popup", "id" => "qnimate"]);


        }
        return append($response);


    }

    function format_tablero($tickets)
    {

        $pendiente[] = d(h("Por hacer", 3, "underline"), 1);
        $haciendo[] = d(h("En proceso", 3), 1, "underline");
        $hecho[] = d(h("hecho", 3), 1, "underline");

        foreach ($tickets as $row) {

            $id_ticket = $row["id_ticket"];
            $asunto = $row["asunto"];

            switch ($row["status"]) {
                case 0:

                    $pendiente[] = d(d($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ]);

                    break;

                case 1:

                    $haciendo[] = d(d($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ]);

                    break;
                case 2:

                    $text = ajustar($asunto, icon("fas fa-check-circle hecho", ["id" => $id_ticket]));
                    $hecho[] = d(
                        d(
                            $text, 12
                        ),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ]);


                    break;

            }
        }
        $response[] = d(append($pendiente), ["class" => "col-lg-3 border pading_10 mh_700 droppable", "id" => 0]);
        $response[] = d("", "col-lg-1");
        $response[] = d(append($haciendo), ["class" => "col-lg-3 border pading_10 mh_700 droppable", "id" => 1]);
        $response[] = d("", "col-lg-1");
        $response[] = d(append($hecho), ["class" => "col-lg-3 border pading_10 mh_700 droppable", "id" => 2]);

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
                "required" => ""
            ]);
        $r[] = input_hidden(["name" => "tarea", "value" => $tarea]);
        $r[] = btn("Enviar");
        $r[] = form_close();
        return append($r);

    }

    function get_form_ticket($departamentos)
    {


        $r[] = form_open("", ["class" => 'form_ticket']);
        $r[] = input_hidden(
            [
                "name" => "prioridad",
                "value" => "1"
            ]);
        $r[] = input_hidden(
            [
                "name" => "mensaje",
                "id" => "mensaje",
                "class" => "mensaje"
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
                "type" => "text"
            ]);
        $r[] = end_row();
        $r[] = btn("ABRIR TICKET");
        $r[] = form_close();
        return append($r);


    }

    function valida_tipo_usuario_tarea($id_perfil)
    {

        return val_class($id_perfil, 20, "Cliente", "Equipo Enid Service");

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
                "modalidad" => $modalidad
            ],
            1,
            1);


        return d(append($r), 6, 1);
    }

    function valida_check_tarea($id_tarea, $valor_actualizar, $status)
    {

        $config = [
            "type" => 'checkbox',
            "class" => 'tarea form-check-input input ',
            "id" => $id_tarea,
            "value" => $valor_actualizar,
        ];


        if ($status > 0) {
            $config += ["checked" => 1];
        }


        return d(check($config), 1);

    }

    function valida_mostrar_tareas($data)
    {

        $r = [];
        if (es_data($data)) {

            $r[] = d("MOSTRAR SÓLO TAREAS PENDIENTES", 'mostrar_tareas_pendientes a_enid_black cursor_pointer');
            $r[] = d("MOSTRAR TODAS LAS TAREAS", 'mostrar_todas_las_tareas a_enid_black cursor_pointer');

        }
        return append($r);
    }

    function create_notificacion_ticket($info_usuario, $param, $info_ticket)
    {


        if (es_data($info_usuario)) {

            $usuario = $info_usuario[0];
            $nombre_usuario = $usuario["nombre"] . " " . $usuario["apellido_paterno"] . $usuario["apellido_materno"] . " -  " . $usuario["email"];


            $asunto_email = "Nuevo ticket abierto [" . $param["ticket"] . "]";
            $r[] = d("Nuevo ticket abierto [" . $param["ticket"] . "]");
            $r[] = d("Cliente que solicita " . $nombre_usuario . "");

            $lista_prioridades = ["", "Alta", "Media", "Baja"];

            $asunto = "";
            $mensaje = "";
            $prioridad = "";
            $nombre_departamento = "";

            foreach ($info_ticket as $row) {

                $asunto = $row["asunto"];
                $mensaje = $row["mensaje"];
                $prioridad = $row["prioridad"];
                $nombre_departamento = $row["nombre_departamento"];

            }

            $r[] = d("Prioridad: " . $lista_prioridades[$prioridad]);
            $r[] = d("Departamento a quien está dirigido: " . $nombre_departamento);
            $r[] = d("Asunto:" . $asunto);
            $r[] = d("Reseña:" . $mensaje);


            $response = [
                "info_correo" => append($r),
                "asunto" => $asunto_email,
            ];


            return $response;


        }

    }

    function crea_tabla_resumen_ticket($info_ticket, $num_tareas)
    {


        $response = [];
        if (es_data($num_tareas)) {

            $tareas = pr($num_tareas, "tareas");
            $pendientes = $tareas - pr($num_tareas, "pendientes");

            $r = [];

            foreach ($info_ticket as $row) {


                $id_ticket = $row["id_ticket"];

                $nombre_departamento = $row["nombre_departamento"];
                $lista_prioridad = ["Alta", "Media", "Baja"];

                $asunto = $row["asunto"];

                $resumen = $pendientes . " / " . $tareas;
                $cerrar_ticket =
                    btn(
                        "CERRAR TICKET",
                        [
                            "onClick" => "cerrar_ticket({$id_ticket})",
                            "class" => "col-lg-3"
                        ],
                        0, 1, 0, 1
                    );

                $icon = ($pendientes != $tareas) ? "fa fa-check-circle text-secondary " : "fa fa-check-circle text-dark";


                $x[] = d(

                    btw(
                        h(add_text("#", $id_ticket, 1), 2),
                        $cerrar_ticket,
                        "d-flex align-items-center justify-content-between"
                    )
                );

                $x[] = d(h(add_text(text_icon($icon, $resumen), "TAREAS"), 5));
                $x[] = d(h(add_text("DEPARTAMENTO", strtoupper($nombre_departamento)), 6));
                $x[] = d(h(add_text("PRIORIDAD", strtoupper($lista_prioridad[$row["prioridad"]])), 6, "underline"));
                $x[] = d($asunto, "top_30 border padding_10 bottom_30");
                $x[] = d(h(strtoupper($row["fecha_registro"]), 6, "text-right"));
                $x[] = d(icon("fas fa-2x fa-plus-circle blue_enid"), " btn_agregar_tarea padding_1  cursor_pointer text-right");
                $r[] = d(append($x), "shadow padding_20");

            }

            $response[] = append($r);
            $response[] = valida_mostrar_tareas($num_tareas);

        }

        return append($response);

    }

    function form_tarea()
    {

        $x[] = h("TAREA", 4);
        $x[] = form_open("", ["class" => 'form_agregar_tarea']);
        $x[] = d("-", ["id" => "summernote", "class" => "summernote"], 1);
        $x[] = input_hidden(["class" => 'tarea_pendiente', "name" => 'tarea']);
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
            $descripcion = ($status > 0) ? del($row["descripcion"], "descripcion_tarea  cursor_pointer") : $row["descripcion"];


            $menu = [];
            $menu[] = icon(" fa-ellipsis-h ml-3 ", ["data-toggle" => "dropdown"]);
            $menu[] = d(
                append(
                    [

                        d(
                            text_icon("fas fa-minus cursor_pointer", "Quitar"),
                            [
                                "class" => "top_5  cursor_pointer",
                                "onClick" => "elimina_tarea({$id_tarea})"
                            ]
                        )

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
                            "onClick" => "edita_descripcion_tarea({$id_tarea})"
                        ]
                    ),
                    d(
                        input(
                            [
                                "name" => "descripcion",
                                "value" => $row["descripcion"],
                                "type" => "text",
                                "class" => "itarea_" . $id_tarea
                            ]
                        )
                        ,
                        [
                            "class" => "input_descripcion",
                            "id" => "tarea_" . $id_tarea
                        ]

                    )
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

        $r[] = crea_tabla_resumen_ticket($data['info_ticket'], $data['info_num_tareas']);
        $r[] = form_tarea();
        $r[] = format_listado_tareas($data);
        return append($r);

    }
}