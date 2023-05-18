<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $response[] = d($data["kits"],13);
        $response[]  = d(modal_kits_servicio(),13);
        return d($response,10,1);
    }
    function modal_kits_servicio(){
        
        $contenido[] = input_frm(12, 'Filtrar',
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

    
}
