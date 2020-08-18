<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function reporte($data)
    {

        $response = [];
        if (es_data($data)) {

            foreach ($data as $row) {

                $tipificacion = $row['nombre_tipificacion'];
                $total = $row['total'];

                $response[] = flex(
                    $total, $tipificacion, _text_(_between, 'text-uppercase border p-2'),_strong);

            }
        }
        return d($response,'mt-5 col-sm-12 p-0');
    }

}