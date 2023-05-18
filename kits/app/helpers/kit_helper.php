<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $seccion_kits[] = d($data["kits"], 13);
        $seccion_kits[]  = d(modal_kits_servicio(), 13);
        $seccion_kits[] = d(modal_nuevo_kit(), 13);

        $response[] = d(format_link("+ Nuevo kit", ["class" => "boton_nuevo_kit"]), 2);
        $response[] = d($seccion_kits, 10);

        return d($response, 10, 1);
    }
    function modal_kits_servicio()
    {

        $contenido[] = input_frm(
            12,
            'Filtrar',
            [
                "id" => "textinput",
                "name" => "textinput",
                "placeholder" => "Nombre del producto o servicio",
                "class" => "q_recompensa",
                "onkeyup" => "onkeyup_colfield_check(event);"
            ]
        );

        $contenido[] = place("place_nuevo_servicio_kit");
        return gb_modal($contenido, 'modal_servicios_kit');
    }
    function modal_nuevo_kit()
    {

        $contenido[] = form_open("",["class" => "form_kit"]);
        $contenido[] = input_frm(
            12,
            'Nombre del kit',
            [
                "id" => "text_input_kit",
                "name" => "nombre",
                "placeholder" => "Nombre del kit",
                "class" => "nombre_kit",
                "onkeyup" => "onkeyup_colfield_check(event);"
            ]
        );        
        $contenido[] = form_close();

        return gb_modal($contenido, 'modal_kit');
    }
}
