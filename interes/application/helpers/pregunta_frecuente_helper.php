<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function form_ingreso()
    {

        $response[] = d(_titulo("Pregunta frecuente", 4), 'text-center mb-5 col-sm-12');
        $response[] = form_open("", ["class" => "form_preguntas_frecuentes"]);
        $response[] = input_frm("col-sm-12 mt-5", "Pregunta frecuente",
            [
                "id" => "titulo",
                "name" => "titulo",
                "required" => true,
                "type" => "text",
                "placeholder" => 'Sobre precios'
            ]

        );

        $response[] = d(label("Respuesta"), 'col-sm-12 mt-5');
        $response[] = hiddens(["class" => "edicion", "name" => "edicion", "id" => "edicion", "value" => 0]);
        $response[] = hiddens(["class" => "id_respuesta", "name" => "id_respuesta", "id" => "id_respuesta", "value" => 0]);

        $response[] = d(place("", ["id" => "summernote"]), "col-lg-12 ");
        $response[] = d(btn("Agregar", []), 'col-sm-12 mt-3');
        $response[] = form_close();

        return gb_modal(append($response), "form_ingreso_modal");


    }

    function tags()
    {

        $response[] = d(_titulo("Tags asociadas", 4), 'text-center mb-5 col-sm-12');
        $response[] = form_open("", ["class" => "form_tags"]);
        $response[] = input_frm("col-sm-12 mt-5",
            "Tags",
            [
                "id" => "tags",
                "name" => "tags",
                "required" => true,
                "type" => "text",
                "placeholder" => 'tags'
            ]

        );

        $response[] = hiddens(
            [
                "class" => "respuesta_id",
                "name" => "id",
                "id" => "respuesta_id",
                "value" => 0
            ]);

        $response[] = d(place("tags_asociados"),"col-sm-12 mt-5");
        $response[] = form_close();

        return gb_modal(append($response), "form_tags_modal");


    }


}

