<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function format_tablero($tickets){

        $pendiente[] = div(heading_enid("Por hacer", 3 ,"underline"),1);
        $haciendo[] = div(heading_enid("En proceso", 3),1,"underline");
        $hecho[] = div(heading_enid("hecho", 3),1,"underline");

        foreach ($tickets as $row ){

            $id_ticket = $row["id_ticket"];
            $asunto = $row["asunto"];

            switch ($row["status"]){
                case 0:

                    $pendiente[] =  div( div( $asunto , 12 ) ,
                        [
                            "class" =>"row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ] );

                    break;

                case 1:

                    $haciendo[] =  div( div( $asunto , 12 ) ,
                        [
                            "class" =>"row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ] );

                    break;
                case 2:

                    $hecho[] =  div( div( $asunto , 12 ) ,
                        [
                            "class" =>"row ui-widget-content border draggable padding_10 shadow blue_target cursor_pointer ver_detalle_ticket top_5",
                            "id" => $id_ticket

                        ] );


                    break;

            }
        }
        $response[]  =  div(append_data($pendiente) ,["class"=> "col-lg-3 border pading_10 mh_700 droppable" , "id" => 0 ]);
        $response[]  =  div("" ,"col-lg-1");
        $response[]  =  div(append_data($haciendo) ,["class"=> "col-lg-3 border pading_10 mh_700 droppable" , "id" => 1 ]);
        $response[]  =  div("" ,"col-lg-1");
        $response[]  =  div(append_data($hecho) ,["class"=> "col-lg-3 border pading_10 mh_700 droppable" , "id" => 2 ]);

        return append_data($response);

    }
    function get_format_tickets($departamentos)
    {

        $r[] = div(div("ABRIR SOLICITUD", "titulo_enid"), 6, 1);
        $r[] = div(get_form_ticket($departamentos), 6, 1);
        $r[] = place("place_registro_ticket");
        return append_data($r);


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
        return append_data($r);

    }

    function get_form_ticket($departamentos)
    {


        $r[] = form_open("", ["class" => 'form_ticket']);
        $r[] = input_hidden([
            "name" => "prioridad",
            "value" => "1"
        ]);
        $r[] = input_hidden([
            "name" => "mensaje",
            "id" => "mensaje",
            "class" => "mensaje"
        ]);
        $r[] = div("DEPARTAMENTO AL CUAL SOLICITAS", 1);
        $r[] = addNRow(create_select(
            $departamentos,
            "departamento",
            "form-control",
            "departamento",
            "nombre",
            "id_departamento"
        ));
        $r[] = n_row_12();
        $r[] = div("MODULO, ASUNTO, TÓPICO", "input-group-addon");
        $r[] = input([
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

        return append_data($r);


    }

    function valida_tipo_usuario_tarea($id_perfil)
    {
        $response = ($id_perfil == 20) ? "Cliente" : "Equipo Enid Service";
        return $response;

    }

    function get_form_cancelar_compra($recibo, $modalidad)
    {

        $x[] = heading_enid("¿REALMENTE DESEAS CANCELAR LA COMPRA?", 3);
        $x[] = div($recibo["resumen"]);
        $r[] = div(div(append_data($x), "padding_20"));

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


        return div(append_data($r), 6, 1);
    }

    function valida_check_tarea($id_tarea, $valor_actualizar, $status)
    {

        $config = [
            "type" => 'checkbox',
            "class" => 'tarea form-check-input input ',
            "id" => $id_tarea,
            "value" => $valor_actualizar,
        ];

        if ($status == 1) {

            $config["checked"] = true;

        }

        return div(check($config), 1);

    }

    function valida_mostrar_tareas($data)
    {

        $r = [];
        if (count($data) > 0) {

            $r[] = div("MOSTRAR SÓLO TAREAS PENDIENTES", 'mostrar_tareas_pendientes a_enid_black cursor_pointer');
            $r[] = div("MOSTRAR TODAS LAS TAREAS", 'mostrar_todas_las_tareas a_enid_black cursor_pointer');

        }
        return append_data($r);
    }

    function create_notificacion_ticket($info_usuario, $param, $info_ticket)
    {

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

        $msj_email["info_correo"] = append_data($r);
        $msj_email["asunto"] = $asunto_email;

        return $msj_email;

    }

    function crea_tabla_resumen_ticket($info_ticket, $info_num_tareas)
    {

        $tareas = $info_num_tareas[0]["tareas"];
        $pendientes = $tareas - $info_num_tareas[0]["pendientes"];

        $r = [];

        foreach ($info_ticket as $row) {


            $id_ticket = $row["id_ticket"];
            $status = $row["status"];
            $fecha_registro = $row["fecha_registro"];
            $prioridad = $row["prioridad"];
            $nombre_departamento = $row["nombre_departamento"];
            $lista_prioridad = ["Alta", "Media", "Baja"];
            $lista_status = ["Abierto", "Cerrado", "Visto"];
            $asunto = $row["asunto"];

            $resumen =    $pendientes ." / " .$tareas;
            $cerrar_ticket =
                guardar(
                    "CERRAR TICKET",
                    [
                        "onClick" => "cerrar_ticket({$id_ticket})",
                        "class" => "col-lg-3"
                    ],
                    0,1,0,1
                )
            ;

            $icon = ($pendientes != $tareas) ? "fa fa-check-circle text-secondary " : "fa fa-check-circle text-dark";


            $x[] = div(

                get_btw(
                    heading_enid(add_text("#", $id_ticket, 1), 2),
                    $cerrar_ticket ,
                    "d-flex align-items-center justify-content-between"
                )
            );
            $x[] = div(heading_enid(add_text(text_icon($icon, $resumen), "TAREAS"), 5));
            $x[] = div(heading_enid(add_text("DEPARTAMENTO", strtoupper($nombre_departamento)), 6));
            $x[] = div(heading_enid(add_text("PRIORIDAD", strtoupper($lista_prioridad[$prioridad])), 6, "underline"));

            $x[] = div($asunto, "top_30 border padding_10 bottom_30");
            $x[] = div(heading_enid(strtoupper($fecha_registro), 6, "text-right"));
            $x[] = div(icon("fas fa-2x fa-plus-circle blue_enid"), " btn_agregar_tarea padding_1  cursor_pointer text-right");

            $r[] = div(append_data($x), "shadow padding_20");

        }
        $response[] = append_data($r);
        $response[] = valida_mostrar_tareas($info_num_tareas);
        return append_data($response);


    }

    function form_tarea()
    {

        $x[] = heading_enid("TAREA", 4);
        $x[] = form_open("", ["class" => 'form_agregar_tarea']);
        $x[] = div("-", ["id" => "summernote", "class" => "summernote"], 1);
        $x[] = input_hidden(["class" => 'tarea_pendiente', "name" => 'tarea']);
        $x[] = guardar("Solicitar", [], 1);
        $x[] = form_close();

        return div(append_data($x), "seccion_nueva_tarea top_20");

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


            $menu   = [];
            $menu[] = icon(" fa-ellipsis-h ml-3 ", ["data-toggle" => "dropdown"]);
            $menu[] = div(
                append_data(
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

            $bloque_descripcion = append_data(
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


            $descripcion = get_btw(
                div($bloque_descripcion)
                ,
                div(append_data($menu), "btn-group")
                ,
                " d-flex align-items-center justify-content-between  "
            );



            $text = get_btw(

                $input
                ,
                $descripcion
                ,
                "d-flex align-items-center justify-content-between "

            );


            $r[] = div($text, $estado_tarea . ' top_30   ');


        }

        $x[] = heading_enid(text_icon("fa fa-check-square", "Checklist"), 5, "strong underline");
        $x[] = div(append_data($r), 1);
        return div(append_data($x), "top_40 padding_20 contenedor_tareas bottom_50");


    }

    function format_tareas($info_ticket, $info_num_tareas, $info_tareas, $perfil)
    {

        $r[] = crea_tabla_resumen_ticket($info_ticket, $info_num_tareas);
        $r[] = form_tarea();
        $r[] = format_listado_tareas($info_tareas);
        return append_data($r);


    }
}