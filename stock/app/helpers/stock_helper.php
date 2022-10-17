<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($inventario)
    {

        $response[] = d(compras(), 13);
        $response[] = listado($inventario);
        $response[] = calendario_ingresos();
        $response[] = unidades_diponibles_modal();
        return d($response, 10, 1);
    }

    function listado($inventario)
    {
        $response = [];
        $contenido = [];
        $base = 'col-md-2 text-center';
        $contenido[] = d('', $base);
        $contenido[] = d('Unidades disponibles', $base);
        $contenido[] = d('Costo por unidad', $base);
        $contenido[] = d('Ingresó el    ', $base);
        $contenido[] = d('Dias en almacen', $base);
        $contenido[] = d('Total', $base);
        $response[] = d($contenido, _text_('d-flex flex-md row mb-5 align-items-center', _strong));
        $inversion_total = 0;

        foreach ($inventario as $row) {

            $id_servicio = $row['id_servicio'];
            $unidades_disponibles = $row['unidades_disponibles'];
            $costo_unidad = $row['costo_unidad'];
            $url_img_servicio = $row['url_img_servicio'];
            $fecha_registro = $row['fecha_registro'];
            $id_stock = $row['id_stock'];

            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $dias = date_difference($hoy, $fecha_registro, $differenceFormat = '%a');
            $img = img(
                [
                    "src" => $url_img_servicio,
                    "class" => "img_servicio_def p-2 w_50",
                ]
            );

            $total = ($unidades_disponibles * $costo_unidad);
            $inversion_total = ($inversion_total + $total);

            $contenido = [];

            $link = a_enid($img,
                [
                    'href' => path_enid('producto', $id_servicio),
                    'target' => '_black'
                ]

            );
            $base = 'col-md-2 border-right text-center';
            $config_ingreso = [
                'class' => 'col-md-2 border-right text-center editar_fecha',
                'id' => $id_stock,
                'fecha_registro' => $fecha_registro
            ];

            $fecha = text_icon(_editar_icon, format_fecha($fecha_registro, 1));
            $base_dias = ($dias > 9) ? _text_($base, 'bg-danger white strong') : $base;
            $contenido[] = d($link, $base);


            $unidades = a_enid($unidades_disponibles,
                [
                    'class' => _text_(_strong, 'underline stock_unidades'),
                    'unidades_disponibles' => $unidades_disponibles,
                    'id' => $id_stock,

                ]
            );
            $contenido[] = d($unidades, $base);
            $contenido[] = d(money($costo_unidad), $base);
            $contenido[] = d($fecha, $config_ingreso);
            $contenido[] = d($dias, $base_dias);
            $contenido[] = d(money($total), $base);

            $response[] = d($contenido, 'd-flex flex-md border row align-items-center');
        }

        $contenido = [];
        $contenido[] = d('', 'col-md-9');
        $contenido[] = d(_titulo(money($inversion_total)), 'col-md-3');
        $response[] = d($contenido, 'd-flex flex-md row text-center mt-5');

        return append($response);
    }

    function compras()
    {

        $link = format_link('Compras',
            [
                'href' => path_enid('compras')
            ], 0
        );

        return d($link, 'ml-auto mb-5');
    }

    function calendario_ingresos()
    {

        $form[] = form_open('', ['class' => 'form_fecha_ingreso']);
        $form[] = d(_titulo('¿Fecha que ingresó al almacen?', 2), 'text-center mb-5');
        $form[] = input_hour_date();
        $form[] = hiddens(['class' => 'id_stock', 'name' => 'id_stock']);
        $form[] = d(btn('Modificar'), 'mt-5');
        $form[] = form_close();

        return gb_modal(append($form), 'modal_form_calendario');

    }

    function unidades_diponibles_modal()
    {
        $form[] = form_open('', ['class' => 'form_unidades_disponibles']);
        $form[] = d(_titulo('Unidades disponibles', 2), 'text-left mb-5');
        $options[] =
            [
                "opcion" => 0,
                "val" => 0
            ];
        $form[] = create_select(
            $options,
            'unidades',
            'unidades',
            'unidades',
            'opcion',
            'val'
        );
        $form[] = hiddens(['class' => 'id_stock', 'name' => 'id_stock']);
        $form[] = d(btn('Modificar'), 'mt-5');
        $form[] = form_close();

        return gb_modal(append($form), 'modal_unidades_disponibles');

    }


}
