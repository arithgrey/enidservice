<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($data)
    {
        $response = [];
        foreach ($data as $row) {

            $titulos = $row["titulo"];
            $respuesta = $row["respuesta"];
            $contenido = [];
            $contenido[] = d(_titulo($titulos, 4));
            $contenido[] = d(d_p($respuesta));
            $response[] = d($contenido, ' mt-5 p-3');
        }
        
        return d($response, 8, 1);
    }

}

