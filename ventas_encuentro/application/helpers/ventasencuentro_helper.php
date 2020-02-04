<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $r[] = format_form();
        $r[] = d("", "time_line_ventas_puntos_encuentro", 4, 1);
        return append($r);

    }

    function format_form()
    {

        $r[] = _titulo("ventas punto de entrega",0,_mbt5);
        $r[] = form_open("",
            [
                "class" => 'form_ventas_encuentro'
            ]
        );
        $r[] = frm_fecha_busqueda();
        $r[] = form_close(place("place_usabilidad top_50"));
        return d($r, 8, 1);

    }


}