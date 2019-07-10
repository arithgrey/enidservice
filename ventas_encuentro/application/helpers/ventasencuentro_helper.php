<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('render')) {
        function render($data)
        {
            $r[] = format_form();
            $r[] = br(2);
            $r[] = div("", "time_line_ventas_puntos_encuentro", 4, 1);;
            return append($r);

        }
    }
    if (!function_exists('format_form')) {
        function format_form()
        {


            $r[] = div("VENTAS PUNTO ENCUENTRO", "titulo_enid_sm", 1);
            $r[] = form_open("", ["class" => 'form_ventas_encuentro']);
            $r[] = get_format_fecha_busqueda();
            $r[] = form_close(place("place_usabilidad top_50"));

            $form = append($r);
            return div(div($form, 8, 1), 13);

        }
    }

}