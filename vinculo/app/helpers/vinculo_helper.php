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
            $response[] = d($contenido, ' mt-5 p-3 border-secondary  border-bottom row mb-5');


            $seccion_compras_conjunto = d("","promociones_sugeridas col-md-5 col-xs-12 p-0");
            $seccion_compras_conjunto_top = d("","promociones_sugeridas_top col-md-5 col-xs-12 p-0");
        
            $adicionales[] = $seccion_compras_conjunto_top;        
            $adicionales[] = d("", 2);
            $adicionales[] = $seccion_compras_conjunto;                    

            $response[] = d(d(_titulo("Aquí algunas cosas que te pueden ayudar", 4)),13);
            $response[] = d(d("","place_tambien_podria_interezar"), 13);            
            $response[] = d($adicionales,13);  
            
            
        }
        
        return d($response, 10, 1);
    }

}

