<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function get_format_listado($preguntas_format)
    {

        $a = d(h("TUS PREGUNTAS ENVIADAS"), 8, 1);
        $b = $preguntas_format;
        return add_text($a, $b);

    }


    function format_preguntas($preguntas, $es_vendedor)
    {

        $r = [];
        foreach ($preguntas as $row) {

            $pregunta = $row["pregunta"];
            $fecha_registro = $row["fecha_registro"];
            $id_servicio = $row["id_servicio"];
            $id_pregunta = $row["id_pregunta"];
            $num = $row["num"];

            $p = [];
            $p[] = d($pregunta, "texto_pregunta");
            $p[] = d(text_icon("fa fa-clock-o", $fecha_registro), "fecha_registro");

            if ($num > 0) {

                $t = ($num > 1) ? $num . " COMENTARIOS" : "1 COMENTARIO ";

                $p[] = d($t,
                    [
                        "class" => "cursor_pointer",
                        "onclick" => "carga_respuestas('" . $id_pregunta . "', '" . $es_vendedor . "');"
                    ]
                );
            } else {

                $p[] = d(
                    text_icon("fa fa-comment" , " AGREGAR RESPUESTA "),
                    [
                        "class" => "cursor_pointer",
                        "onclick" => "carga_respuestas('" . $id_pregunta . "' , '" . $es_vendedor . "');"
                    ]
                );

            }

            $texto = d(append($p), "bloque_texto top_20");
            $img = a_enid(img_servicio($id_servicio),
                [
                    "href" => get_url_servicio($id_servicio),
                    "class" => "anchor_imagen_servicio"

                ]
            );


            $principal_seccion = dd($img, $texto, 2);

            $id = "pregunta" . $id_pregunta;
            $id_pĺace = "comentarios_" . $id_pregunta;

            $r[] = d(
                $principal_seccion,
                [
                    "class" => "descripcion_pregunta top_10 padding_20 col-lg-8 col-lg-offset-2",
                    "id" => $id
                ]
            );


            $r[] = d(place($id_pĺace), "top_10 padding_20 col-lg-8 col-lg-offset-2");


        }


        return d(append($r), "contenedor_pregunta");

    }


    function get_format_pregunta($formulario_valoracion, $id_servicio)
    {


        $r[] = addNRow(d($formulario_valoracion, 8, 1));
        $r[] = hiddens(["class" => "servicio", "value" => $id_servicio]);
        $r[] = addNRow(d(d("ENVIAMOS TU PREGUNTA AL VENDEDOR!", "registro_pregunta display_none padding_10 top_30"), 8, 1));
        $r[] = d("", "top_50");
        $r[] = d(place("place_tambien_podria_interezar", ["id" => "place_tambien_podria_interezar"]), 10, 1);
        $r[] = d(place("place_valoraciones top_50", ["id" => "place_valoraciones"]), 8, 1);
        return d(append($r), 1);
    }

}