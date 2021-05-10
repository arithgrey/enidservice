<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function formato_respuestas($data, $session)
    {
        $response = [];
        if (es_data($data)) {

            $es_administrador = es_administrador($session);
            foreach ($data as $row) {

                $id = $row["id"];
                $titulos = $row["titulo"];
                $respuesta = $row["respuesta"];
                $tags = $row["tags"];
                $contenido = [];
                $contenido[] = controles($es_administrador, $tags, $id);
                $contenido[] = d(_titulo($titulos, 4));
                $contenido[] = d(d_p($respuesta));
                $response[] = d($contenido, 'border mt-5 p-3');


            }
        }

        return d($response,10,1);
    }

    function controles($es_administrador, $tags, $id)
    {
        $response = "";
        if ($es_administrador) {


            $array_tags = [];
            if (!is_null($es_administrador)) {
                $array_tags = explode(",", $tags);
            }


            $icono = icon(
                _text_(_eliminar_icon, 'eliminar_respuesta'),
                [
                    "id" => $id
                ]
            );

            $icono_editar = icon(
                _text_(_editar_icon, 'editar_respuesta'),
                [
                    "id" => $id
                ]
            );

            $num = count($array_tags);
            $numero_tags = ($num < 1) ? '' : $num;
            $etiquetas = d(_text_($numero_tags, "Etiquetas"),
                [
                    'class' => 'mr-3 black fp8 cursor_pointer etiqueta',
                    'id' => $id,
                    'tags_pregunta' => $tags
                ]
            );

            $elementos = [$etiquetas, $icono_editar, $icono];
            $iconos = d($elementos, "d-flex");
            $response = d($iconos, 'pull-right');
        }
        return $response;
    }
}
