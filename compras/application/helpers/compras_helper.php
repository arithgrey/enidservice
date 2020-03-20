<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

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


        $r[] = d('Fecha entrega', 'mr-5 strong text-uppercase black');
        $r[] = input_frm('', "",
            [
                "data-date-format" => "yyyy-mm-dd",
                "name" => 'fecha_inicio',
                "class" => " datetimepicker4",
                "id" => 'datetimepicker4',
                "value" => date("Y-m-d"),
                "type" => 'date'

            ]
        );

        $select = create_select(
            $opt_turnos,
            "tipo",
            "form-control",
            "tipo",
            "opcion",
            "val"
        );
        $r[] = flex("comparado con", $select,
            'flex-column ml-md-5 mt-5 ',
            'strong black text-uppercase', 'mt-3');

        $ext = (is_mobile()) ? 'p-0' : '';
        $r[] = d(btn('Validar'),

            _text_('col-md-2 col-sm-12 mt-5 mt-md-0', $ext)
        );

        $x[] = form_open("",
            [
                "class" => "form_compras d-md-flex justify-content-center align-items-end mx-auto mt-5",
                "method" => "post"
            ]
        );
        $x[] = append($r);
        $x[] = form_close();
        $x[] = place("place_compras mt-5");
        $response[] = d(_titulo("planeación y compras"), 'col-lg-12 mt-5');

        $link_inventario = format_link('INVENTARIO',
            [
                'href' => path_enid('inventario')
            ], 0);
        $response[] = d('', 'col-sm-9 mt-3');
        $response[] = d($link_inventario, 'col-sm-3 mt-3');

        $response[] = d($x, 'col-sm-12 mt-3');
        $response[] = form_stock();
        return append($response);

    }

    function form_stock()
    {

        $form[] = d(_titulo('¿Cúantos artículos iguales a este tenemos en existencia?'), 'mb-5');
        $form[] = form_open("",
            [
                "class" => "form_stock_servicio",
                "method" => "post"
            ]
        );

        $form[] = input_frm('', '¿Stock en almacén?',
            [
                'class' => 'stock',
                'id' => 'stock',
                'name' => 'stock',
                'value' => 0,
                'required' => true
            ]
        );
        $form[] = input_frm('mt-5', '¿Cuanto nos cuesta el artículo?',
            [
                'class' => 'costo',
                'id' => 'costo',
                'name' => 'costo',
                'value' => 0,
                'required' => true
            ]
        );
        $form[] = hiddens(['name' => 'id_servicio', 'class' => 'id_servicio', 'value' => 0]);
        $form[] = btn('Actualizar', ['class' => 'mt-5']);
        $form[] = form_close();

        return gb_modal(append($form), 'stock_servicio_modal');
    }
}

