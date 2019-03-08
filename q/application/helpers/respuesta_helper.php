<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_resumen_cliente($next, $nombre, $telefono){

        $r =  [];
        if ($next > 0):
                $x[] =  strong("CLIENTE:");
                $x[] =  span(strtoupper($nombre), ["class" => "underline"]);
                $r[] = div(append_data($x) ,  ["class"=>"top_15"]);

            if (strlen($telefono) > 4):
                $r[] =  strong("TELÉFONO DE CONTACTO:");
                $r[] = span($telefono, ["class" => "underline"]);

            endif;
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
        if ($num > 4) {
            return " scroll_chat_enid ";
        }
    }

    function carga_imagen_usuario_respuesta($id_usuario)
    {
        return "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;
    }

}

