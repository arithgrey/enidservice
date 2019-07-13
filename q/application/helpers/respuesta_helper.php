<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_form_respuestas($data)
    {

        $info_usuario = $data["info_usuario"];
        $data_send = $data["data_send"];
        $respuestas = $data["respuestas"];

        $next = 0;
        if ($info_usuario != 0) {
            $cliente = $info_usuario[0];
            $nombre = $cliente["nombre"] . " " . $cliente["apellido_paterno"];
            $telefono =
                (strlen($cliente["tel_contacto"]) > 4) ? $cliente["tel_contacto"] :
                    $cliente["tel_contacto_alterno"];
            $next++;
        }

        $g[] = h($data_send["pregunta"], 2);
        $g[] = anchor_enid(strong("SOBRE") . strtoupper($data_send["nombre_servicio"]),
            [
                "href" => get_url_servicio($data_send["id_servicio"]),
                "class" => 'a_enid_blue_sm'
            ]
            ,
            1
        );
        $g[] = get_format_resumen_cliente($next, $nombre, $telefono);


        $response[] = d("Seguimiento", ["class" => "panel-heading"]);

        $r = [];
        foreach ($respuestas as $row) {

            $t[] = span(
                img(
                    [
                        "src" => path_enid("imagen_usuario", $row["id_usuario"]),
                        "onerror" => "this.src='../img_tema/user/user.png'",
                        "style" => "width: 40px!important;height: 32px!important;",
                        "class" => "img-circle"
                    ]
                ),
                "chat-img pull-left"
            );

            $t[] = btw(
                strong($row["nombre"] . $row["apellido_paterno"]),
                small(text_icon("fa fa-clock", $row["fecha_registro"]), "pull-right text-muted"),
                "header"
            );
            
            $t[] = p($row["respuesta"]);
            $r[] = li(d(append($t), "chat-body clearfix"), "left clearfix");

        }

        $response[] =

            d(d(
                ul(append($r), "chat"),
                [
                    "class" => mayorque(count($respuestas), 4, " scroll_chat_enid ")
                ]
            ), "panel-body");


        $response[] = get_form_valoracion_pregunta();
        $g[] = d(d(append($response), "panel panel-primary"), "contenedor_preguntas");

        return append($g);

    }

    function get_format_listado($respuestas, $id_pregunta, $es_vendedor)
    {

        $r = [];
        $z = [];
        foreach ($respuestas as $row) {


            $respuesta = d($row["respuesta"]);
            $fecha_registro = d(text_icon("fa fa fa-clock-o", $row["fecha_registro"], [], 0));

            $id_usuario = $row["id_usuario"];
            $sender = $row["nombre"] . " " . $row["apellido_paterno"];


            $pick = get_img_usuario($id_usuario);
            $l = [];
            $l[] = btw($pick, $sender, "descripcion_usuario col-lg-3");
            $l[] = btw($respuesta, $fecha_registro, "descripcion_respuesta col-lg-9 text-right");

            $z[] = d(append($l), 1) . br(2);

        }


        if (es_data($respuestas)) {

            $z[] = place("final");
            $r[] = d(append($z), "contenedor_respuestas padding_10");
        }


        $r[] = br();
        $r[] = form_open("", ["class" => 'form_comentario']);
        $r[] = d("-", ["id" => "summernote", "class" => "summernote", "name" => "respuesta"], 1);
        $r[] = input_hidden(["class" => 'id_pregunta', "name" => 'id_pregunta', "value" => $id_pregunta]);
        $r[] = input_hidden(["class" => 'es_vendedor', "name" => 'es_vendedor', "value" => $es_vendedor]);
        $r[] = btn("RESPONDER");
        $r[] = form_close(place("place_repuesta_pregunta"));

        return d(append($r), "contenedor_respuestas_formulario padding_10");
    }

    function get_format_resumen_cliente($next, $nombre, $telefono)
    {


        $r = [];
        if ($next > 0):

            $x[] = strong("CLIENTE:");
            $x[] = span(strtoupper($nombre), "underline");
            $r[] = d(append($x), "top_15");

            if (strlen($telefono) > 4) :

                $r[] = strong("TELÉFONO DE CONTACTO:");
                $r[] = span($telefono, "underline");

            endif;

        endif;

        return append($r);


    }

    function get_form_valoracion_pregunta()
    {

        $r[] = form_open("", ["class" => "form_valoracion_pregunta"]);
        $r[] = input(
            [
                "id" => "btn-input",
                "type" => "text",
                "class" => "form-control input-sm",
                "placeholder" => "Agrega una respuesta",
                "name" => "respuesta"
            ]);
        $r[] = btn("Enviar respuesta",
            [
                "class" => "btn btn-warning btn-sm input-group-btn",
                "id" => "btn-chat"
            ]);
        $r[] = form_close();
        return append($r);

    }

}

