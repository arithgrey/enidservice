<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {
        $agregar_icono = icon(_text_(_agregar_icon,'white'));
        $icon = format_link(_text_($agregar_icono,'Agregar'),
        [
            'class' => "row text-center accion_agregar_repuesta_frecuente"
        ]);
        $agregar = d($icon,'col-xs-2 pull-right');
        $response[] = d($agregar,"col-xs-12 mb-5");                
        $response[] = d(_titulo("Respuestas frecuentes"),"col-xs-12 mb-5");                
        $response[] = d($data["formulario_busqueda_frecuente"],12);
        $response[] = d(gb_modal($data["formulario_registro"],'modal_registro'));
        return d($response, 8,1);
    }
}
