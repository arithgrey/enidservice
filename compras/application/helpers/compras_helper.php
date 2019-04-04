<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_form_entrega')) {

        function get_form_entrega()
        {
            return get_btw(

                div("FECHA DE ENTREGA", ["class" => 'strong']),

                input([
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_inicio',
                    "class" => "form-control input-sm datetimepicker4",
                    "id" => 'datetimepicker4',
                    "value" => date("Y-m-d")
                ]),
                6
            );

        }
    }
    if (!function_exists('get_format_compras')) {
        function get_format_compras()
        {
            $opt_turnos[] = array(
                "opcion" => "-1 MES",
                "val" => 1
            );
            $opt_turnos[] = array(
                "opcion" => "-3 MES",
                "val" => 3
            );

            $opt_turnos[] = array(
                "opcion" => "-6 MES",
                "val" => 6
            );

            $opt_turnos[] = array(
                "opcion" => "-1 AÑO",
                "val" => 12
            );


            $r[] = get_form_entrega();
            $r[] = get_btw(
                div("FECHA REFERENCIA", ["class" => 'strong']),
                create_select($opt_turnos, "tipo", "form-control", "tipo", "opcion", "val"),
                6
            );


            $x[] = form_open("", ["class" => "form_compras", "method" => "post"]);
            $x[] = div(append_data(), 6);
            $x[] = form_close(place("place_compras"));
            return append_data($x);


        }
    }
}

