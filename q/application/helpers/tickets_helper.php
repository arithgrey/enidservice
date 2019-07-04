<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function format_tablero($tickets)
    {

        $pendiente[] = div(heading_enid("Por hacer", 3, "underline"), 1);
        $haciendo[] = div(heading_enid("En proceso", 3), 1, "underline");
        $hecho[] = div(heading_enid("hecho", 3), 1, "underline");

        foreach ($tickets as $row) {

            $id_ticket = $row["id_ticket"];
            $asunto = $row["asunto"];

            switch ($row["status"]) {
                case 0:

                    $pendiente[] = div(div($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ]);

                    break;

                case 1:

                    $haciendo[] = div(div($asunto, 12),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ]);

                    break;
                case 2:

                    $text = ajustar($asunto, icon("fas fa-check-circle hecho", ["id" => $id_ticket]));
                    $hecho[] = div(
                        div(
                            $text, 12
                        ),
                        [
                            "class" => "row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ]);


                    break;

            }
        }
        $response[] = div(append($pendiente), ["class" => "col-lg-3 border pading_10 mh_700 droppable", "id" => 0]);
        $response[] = div("", "col-lg-1");
        $response[] = div(append($haciendo), ["class" => "col-lg-3 border pading_10 mh_700 droppable", "id" => 1]);
        $response[] = div("", "col-lg-1");
        $response[] = div(append($hecho), ["class" => "col-lg-3 border pading_10 mh_700 droppable", "id" => 2]);

        return append($response);

    }

    function get_format_tickets($departamentos)
    {

        $r[] = div(div("ABRIR SOLICITUD", "titulo_enid"), 6, 1);
        $r[] = div(get_form_ticket($departamentos), 6, 1);
        $r[] = place("place_registro_ticket");

        return append($r);

    }

    function get_form_respuesta($tarea)
    {

        $r[] = form_open("", ["class" => "form_respuesta_ticket top_20"]);
        $r[] = heading_enid("COMENTARIO", 3);
        $r[] = textarea([
            "class" => "form-control",
            "id" => "mensaje",
            "name" => "mensaje",
            "required" => ""
        ]);
        $r[] = input_hidden(["name" => "tarea", "value" => $tarea]);
        $r[] = guardar("Enviar");
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
        $r[] = div("DEPARTAMENTO AL CUAL SOLICITAS", 1);
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
        $r[] = div("MODULO, ASUNTO, TÓPICO", "input-group-addon");
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
        $r[] = guardar("ABRIR TICKET");
        $r[] = form_close();
        return append($r);


    }

    function valida_tipo_usuario_tarea($id_perfil)
    {

        return val_class($id_perfil, 20, "Cliente", "Equipo Enid Service");

    }

    function get_form_cancelar_compra($recibo, $modalidad)
    {

        $x[] = heading_enid("¿REALMENTE DESEAS CANCELAR LA COMPRA?", 3);
        $x[] = div($recibo["resumen"]);
        $r[] = div(div(append($x), "padding_20"));
        $url = path_enid("area_cliente_compras", $recibo['id_recibo']);
        $r[] = guardar("SEGUIR COMPRANDO",
            [

                "class" => "top_30",

            ],
            1,
            1, 0, $url);

        $r[] = guardar("CANCELAR ÓRDEN DE COMPRA",
            [
                "class" => "cancelar_orden_compra top_20",
                "id" => $recibo['id_recibo'],
                "modalidad" => $modalidad
            ],
            1,
            1);


        return div(append($r), 6, 1);
    }

    function valida_check_tarea($id_tarea, $valor_actualizar, $status)
    {

        $config = [
            "type" => 'checkbox',
            "class" => 'tarea form-check-input input ',
            "id" => $id_tarea,
            "value" => $valor_actualizar,
        ];

        $f = ($status == 1) ? (array_push($config, true)) : "";

        return div(check($config), 1);

    }

    function valida_mostrar_tareas($data)
    {

        $r = [];
        if (es_data($data)) {

            $r[] = div("MOSTRAR SÓLO TAREAS PENDIENTES", 'mostrar_tareas_pendientes a_enid_black cursor_pointer');
            $r[] = div("MOSTRAR TODAS LAS TAREAS", 'mostrar_todas_las_tareas a_enid_black cursor_pointer');

        }
        return append($r);
    }

    function create_notificacion_ticket($info_usuario, $param, $info_ticket)
    {


        if (es_data($info_usuario)) {

            $usuario = $info_usuario[0];
            $nombre_usuario = $usuario["nombre"] . " " . $usuario["apellido_paterno"] . $usuario["apellido_materno"] . " -  " . $usuario["email"];


            $asunto_email = "Nuevo ticket abierto [" . $param["ticket"] . "]";
            $r[] = div("Nuevo ticket abierto [" . $param["ticket"] . "]");
            $r[] = div("Cliente que solicita " . $nombre_usuario . "");

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

            $r[] = div("Prioridad: " . $lista_prioridades[$prioridad]);
            $r[] = div("Departamento a quien está dirigido: " . $nombre_departamento);
            $r[] = div("Asunto:" . $asunto);
            $r[] = div("Reseña:" . $mensaje);


            $response = [
                "info_correo" => append($r),
                "asunto" => $asunto_email,
            ];


            return $response;


        }

    }

    function crea_tabla_resumen_ticket($info_ticket, $info_num_tareas)
    {


        $response = [];
        if (es_data($info_num_tareas)) {


            $tareas = $info_num_tareas[0]["tareas"];
            $pendientes = $tareas - $info_num_tareas[0]["pendientes"];

            $r = [];

            foreach ($info_ticket as $row) {


                $id_ticket = $row["id_ticket"];

                $fecha_registro = $row["fecha_registro"];
                $prioridad = $row["prioridad"];
                $nombre_departamento = $row["nombre_departamento"];
                $lista_prioridad = ["Alta", "Media", "Baja"];

                $asunto = $row["asunto"];

                $resumen = $pendientes . " / " . $tareas;
                $cerrar_ticket =
                    guardar(
                        "CERRAR TICKET",
                        [
                            "onClick" => "cerrar_ticket({$id_ticket})",
                            "class" => "col-lg-3"
                        ],
                        0, 1, 0, 1
                    );

                $icon = ($pendientes != $tareas) ? "fa fa-check-circle text-secondary " : "fa fa-check-circle text-dark";


                $x[] = div(

                    btw(
                        heading_enid(add_text("#", $id_ticket, 1), 2),
                        $cerrar_ticket,
                        "d-flex align-items-center justify-content-between"
                    )
                );

                $x[] = div(heading_enid(add_text(text_icon($icon, $resumen), "TAREAS"), 5));
                $x[] = div(heading_enid(add_text("DEPARTAMENTO", strtoupper($nombre_departamento)), 6));
                $x[] = div(heading_enid(add_text("PRIORIDAD", strtoupper($lista_prioridad[$prioridad])), 6, "underline"));
                $x[] = div($asunto, "top_30 border padding_10 bottom_30");
                $x[] = div(heading_enid(strtoupper($fecha_registro), 6, "text-right"));
                $x[] = div(icon("fas fa-2x fa-plus-circle blue_enid"), " btn_agregar_tarea padding_1  cursor_pointer text-right");
                $r[] = div(append($x), "shadow padding_20");

            }

            $response[] = append($r);
            $response[] = valida_mostrar_tareas($info_num_tareas);

        }

        return append($response);

    }

    function form_tarea()
    {

        $x[] = heading_enid("TAREA", 4);
        $x[] = form_open("", ["class" => 'form_agregar_tarea']);
        $x[] = div("-", ["id" => "summernote", "class" => "summernote"], 1);
        $x[] = input_hidden(["class" => 'tarea_pendiente', "name" => 'tarea']);
        $x[] = guardar("Solicitar", [], 1);
        $x[] = form_close();
        return div(append($x), "seccion_nueva_tarea top_20");

    }

    function format_listado_tareas($info_tareas)
    {

        $r = [];
        foreach ($info_tareas as $row) {

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
            $menu[] = div(
                append(
                    [

                        div(
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
                    div(
                        $descripcion,
                        [
                            "class" => "contenedor_descripcion cursor_pointer text_tarea_" . $id_tarea,
                            "onClick" => "edita_descripcion_tarea({$id_tarea})"
                        ]
                    ),
                    div(
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
                div($bloque_descripcion)
                ,
                div(append($menu), "btn-group")
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


            $r[] = div($text, $estado_tarea . ' top_30   ');


        }

        $x[] = heading_enid(text_icon("fa fa-check-square", "Checklist"), 5, "strong underline");
        $x[] = div(append($r), 1);
        return div(append($x), "top_40 padding_20 contenedor_tareas bottom_50");


    }

    function format_tareas($info_ticket, $info_num_tareas, $info_tareas, $perfil)
    {

        $r[] = crea_tabla_resumen_ticket($info_ticket, $info_num_tareas);
        $r[] = form_tarea();
        $r[] = format_listado_tareas($info_tareas);
        return append($r);


    }
}