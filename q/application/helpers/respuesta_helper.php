<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function get_format_listado($respuestas, $id_pregunta, $es_vendedor)
    {

        $r = [];
        $z = [];
        foreach ($respuestas as $row) {


            $respuesta = div($row["respuesta"]);
            $fecha_registro = div($row["fecha_registro"] . icon("fa fa fa-clock-o"));
            //$id_response = $row["id_pregunta"];
            $id_usuario = $row["id_usuario"];
            $sender = $row["nombre"] . " " . $row["apellido_paterno"];


            $pick = get_img_usuario($id_usuario);
            $l = [];
            $l[] = get_btw($pick, $sender, "descripcion_usuario col-lg-3");
            $l[] = get_btw($respuesta, $fecha_registro, "descripcion_respuesta col-lg-9 text-right");

            $z[] = div(append_data($l), 1) . br(2);

        }


        if (count($respuestas) > 0) {

            $z[] = place("final");
            $r[] = div(append_data($z), ["class" => "contenedor_respuestas padding_10"]);
        }


        $r[] = br();
        $r[] = form_open("", ["class" => 'form_comentario']);
        $r[] = div("-", ["id" => "summernote", "class" => "summernote", "name" => "respuesta"], 1);
        $r[] = input_hidden(["class" => 'id_pregunta', "name" => 'id_pregunta', "value" => $id_pregunta]);
        $r[] = input_hidden(["class" => 'es_vendedor', "name" => 'es_vendedor', "value" => $es_vendedor]);
        $r[] = guardar("RESPONDER");
        $r[] = form_close(place("place_repuesta_pregunta"));

        return div(append_data($r), ["class" => "contenedor_respuestas_formulario padding_10"]);
    }

    function get_format_resumen_cliente($next, $nombre, $telefono)
    {

        $r = [];
        if ($next > 0):
            $x[] = strong("CLIENTE:");
            $x[] = span(strtoupper($nombre), ["class" => "underline"]);
            $r[] = div(append_data($x), ["class" => "top_15"]);

            if (strlen($telefono) > 4) {
                $r[] = strong("TELÉFONO DE CONTACTO:");
                $r[] = span($telefono, ["class" => "underline"]);

            }
        endif;
        return append_data($r);


    }

    function get_form_valoracion_pregunta()
    {

        $r[] = form_open("", ["class" => "form_valoracion_pregunta"]);
        $r[] = input([
            "id" => "btn-input",
            "type" => "text",
            "class" => "form-control input-sm",
            "placeholder" => "Agrega una respuesta",
            "name" => "respuesta"
        ]);
        $r[] = guardar("Enviar respuesta",
            [
                "class" => "btn btn-warning btn-sm input-group-btn",
                "id" => "btn-chat"
            ]);
        $r[] = form_close();
        return append_data($r);

    }

    function verifica_scroll_respuesta($num)
    {
        $response = ($num > 4) ? " scroll_chat_enid " : "";
        return $response;

    }

    function carga_imagen_usuario_respuesta($id_usuario)
    {
        return "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;
    }

}

