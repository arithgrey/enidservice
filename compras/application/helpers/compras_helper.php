<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function form_entrega()
    {

        return input_frm(6, "FECHA DE ENTREGA",
            [
                "data-date-format" => "yyyy-mm-dd",
                "name" => 'fecha_inicio',
                "class" => "form-control input-sm datetimepicker4",
                "id" => 'datetimepicker4',
                "value" => date("Y-m-d"),

            ]
        );


    }

    function render_compras()
    {
        $opt_turnos[] =
            [
                "opcion" => "-1 MES",
                "val" => 1
            ];
        $opt_turnos[] =
            [
                "opcion" => "-3 MES",
                "val" => 3
            ];

        $opt_turnos[] =
            [
                "opcion" => "-6 MES",
                "val" => 6
            ];

        $opt_turnos[] =
            [
                "opcion" => "-1 AÑO",
                "val" => 12
            ];

        $r[] = form_entrega();

        $select = create_select(
            $opt_turnos,
            "tipo",
            "form-control",
            "tipo",
            "opcion",
            "val"
        );
        $r[] = ajustar(
            d("FECHA REFERENCIA", 'strong')
            ,
            d(
                $select
            )
            ,
            " d-flex align-items-center justify-content-between"
        );


        $x[] = form_open("",
            [
                "class" => "form_compras",
                "method" => "post"
            ]
        );
        $x[] = d(append($r), 6, 1);
        $x[] = form_close();
        $x[] = d(place("place_compras top_50"), 12);
        return append($x);
        
    }
}

