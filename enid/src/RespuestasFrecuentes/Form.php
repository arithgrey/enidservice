<?php

namespace Enid\RespuestasFrecuentes;

class Form
{
    function busqueda()
    {

        $form[] = input_enid(
            [
                "name" => "q",
                "placeholder" => "Teclea / para encontrar una respuesta frecuente",
                "id" => "input_busqueda_respuesta_frecuente",
                "class" => "input_busqueda_respuesta_frecuente",

            ]
        );

        $form_busqueda = d($form, 12);
        $form_sugerencias = d(
            "",
            [
                "class" => "sugerencias_respuestas_frecuentes col-xs-12"
            ]
        );

        return  d([$form_busqueda, $form_sugerencias], 13);
    }
    function opciones($respuestas_frecuentes)
    {
        if (!es_data($respuestas_frecuentes) ) {
            return "";
        }
        $respuestas = [];

        foreach ($respuestas_frecuentes as $row) {

            $respuestas[] = flex(
                $row["atajo"],
                $row["respuesta"],
                'flex-column row borde_black mt-2 p-3',
                'text-secondary mb-1',
                'item_respuesta cursor_pointer'
            );
        }
        $respuestas_html = d($respuestas, 12);
        $extra = count($respuestas_frecuentes) > 2 ? 'height: 200px; overflow-y: auto' : '';

        $path = path_enid("editar_respuestas_rapidas");
        $editar = a_enid("Editar", ["href" => $path, 'class' => 'blue_enid'], 0);


        $respuestas_container[] = d(flex("Respuestas rápidas", $editar, _between, 'strong underline'), 'row mt-3 mb-2');
        $respuestas_container[] = d(d(
            $respuestas_html,
            [
                "class" => "respuestas_container",
                "style" => $extra
            ]
        ), 13);


        return d($respuestas_container, 12);
    }
}
