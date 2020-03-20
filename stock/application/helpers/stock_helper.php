<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($inventario)
    {

        $response = [];
        $contenido = [];
        $base = 'col-md-3 text-center';
        $contenido[] = d('', $base);
        $contenido[] = d('Unidades disponibles', $base);
        $contenido[] = d('Costo por unidad', $base);
        $contenido[] = d('Total', $base);
        $response[] = d($contenido, _text_('d-flex flex-md row mb-5 align-items-center', _strong));
        $inversion_total = 0;

        foreach ($inventario as $row) {

            $id_servicio = $row['id_servicio'];
            $unidades_disponibles = $row['unidades_disponibles'];
            $costo_unidad = $row['costo_unidad'];
            $url_img_servicio = $row['url_img_servicio'];

            $img = img(
                [
                    "src" => $url_img_servicio,
                    "class" => "img_servicio_def p-2 w_50",
                ]
            );

            $total = ($unidades_disponibles * $costo_unidad);
            $inversion_total  = ($inversion_total + $total);

            $contenido = [];
            $base = 'col-md-3 border-right text-center';
            $link = a_enid($img,
                [
                    'href' => path_enid('producto', $id_servicio),
                    'target' => '_black'
                ]

            );
            $contenido[] = d($link, $base);
            $contenido[] = d($unidades_disponibles, $base);
            $contenido[] = d(money($costo_unidad), $base);
            $contenido[] = d(money($total), $base);
            $response[] = d($contenido, 'd-flex flex-md border row align-items-center');
        }
        $contenido = [];
        $contenido[] = d('', 'col-md-9');
        $contenido[] = d(_titulo(money($inversion_total)), 'col-md-3');
        $response[] = d($contenido, 'd-flex flex-md row text-center mt-5');

        return d($response, 8, 1);
    }
}
