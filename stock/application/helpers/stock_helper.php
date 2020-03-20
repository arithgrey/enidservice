<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($inventario)
    {

        $response[] = d(compras(), 13);
        $response[] = listado($inventario);

        return d($response, 8, 1);
    }

    function listado($inventario)
    {
        $response = [];
        $contenido = [];
        $base = 'col-md-2 text-center';
        $contenido[] = d('', $base);
        $contenido[] = d('Unidades disponibles', $base);
        $contenido[] = d('Costo por unidad', $base);
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

            $base_dias = ($dias > 9) ? _text_($base, 'bg-danger  white strong') : $base;
            $contenido[] = d($link, $base);
            $contenido[] = d($unidades_disponibles, $base);
            $contenido[] = d(money($costo_unidad), $base);
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

}
