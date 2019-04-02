<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

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
        $r[] = div("MODULO, ASUNTO, TÓPICO", ["class" => "input-group-addon"]);
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
        $x[] = div(strtoupper($recibo["resumen"]));
        $r[] = div(div(append_data([$x]), ["class" => "padding_20"]), ['class' => 'jumbotron']);
        $r[] = guardar("CANCELAR ÓRDEN DE COMPRA",
            [
                "class" => "cancelar_orden_compra",
                "id" => $recibo['id_recibo'],
                "modalidad" => $modalidad
            ],
            1,
            1);

        return append_data([$r]);
    }

    function valida_check_tarea($id_tarea, $valor_actualizar, $status, $id_perfil)
    {

        if ($id_perfil != 20) {

            $config = [
                "type" => 'checkbox',
                "class" => 'tarea',
                "id" => $id_tarea,
                "value" => $valor_actualizar,
            ];
            if ($status == 1) {
                $config["checked"] = true;
            }

            $input = input($config);
        } else {
            $input = ($status == 1) ? " Tarea terminada" : " | En proceso";
        }
        return $input;
    }

    function valida_mostrar_tareas($data)
    {

        $r = [];
        if (count($data) > 0) {

            $config = ["class" => 'mostrar_tareas_pendientes a_enid_black cursor_pointer'];
            $config2 = ["class" => 'mostrar_todas_las_tareas a_enid_black cursor_pointer'];


            $r[] = div("MOSTRAR SÓLO TAREAS PENDIENTES", $config);
            $r[] = div("MOSTRAR TODAS LAS TAREAS", $config2);

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
        //$lista = "";
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
        $pendientes = $info_num_tareas[0]["pendientes"];

        foreach ($info_ticket as $row) {

            $id_ticket = $row["id_ticket"];
            $status = $row["status"];
            $fecha_registro = $row["fecha_registro"];
            $prioridad = $row["prioridad"];
            $nombre_departamento = $row["nombre_departamento"];
            $lista_prioridad = ["Alta", "Media", "Baja"];
            $lista_status = ["Abierto", "Cerrado", "Visto"];
            $asunto = $row["asunto"];


            $r[] = "
        <table class='table_resumen_ticket'>";
            $r[] = "
            <tr>";
            $r[] = get_td(heading_enid($asunto, 3, ["class" => "white"]));
            $r[] = get_td("#TAREAS " . $tareas);
            $r[] = get_td("#PENDIENTES " . $pendientes);
            $r[] = "
            </tr>
            ";

            $r[] = "
            <tr>";
            $r[] = get_td($info_ticket[0]["asunto"], ["colspan" => 3]);
            $r[] = "
            </tr>
            ";

            $r[] = "
            <tr>";
            $r[] = get_td(div($info_ticket[0]["mensaje"]));
            $r[] = "
            </tr>
            ";

            $r[] = get_td("TICKET # " . $id_ticket);
            $r[] = get_td("DEPARTAMENTO " . strtoupper($nombre_departamento));
            $r[] = get_td("ESTADO " . strtoupper($lista_status[$status]));
            $r[] = get_td("PRIORIDAD " . strtoupper($lista_prioridad[$prioridad]));
            $r[] = get_td("ALTA " . strtoupper($fecha_registro));
            $r[] = "</tr>";
            $r[] = "</table>";

        }
        return append_data($r);
    }

}