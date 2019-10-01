<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('render')) {
        function render($data)
        {
            $r[] = format_form();
            $r[] = d("", "time_line_ventas_puntos_encuentro", 4, 1);
            return append($r);

        }
    }
    if (!function_exists('format_form')) {
        function format_form()
        {

            $r[] = d("VENTAS PUNTO ENCUENTRO", "titulo_enid_sm");
            $r[] = form_open("", ["class" => 'form_ventas_encuentro']);
            $r[] = frm_fecha_busqueda();
            $r[] = form_close(place("place_usabilidad top_50"));
            return d(d(append($r), 8, 1), 13);

        }
    }

}