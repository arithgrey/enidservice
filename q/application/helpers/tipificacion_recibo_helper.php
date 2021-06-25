<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function reporte($data)
    {

        $response = [];
        if (es_data($data)) {

            $class = _text_(_between, 'text-uppercase border p-2 col-md-6 text-center');
            $titulos[] = d_c(
                [
                    "Veces que se canceló por está razón",
                    "Motivo cancelación"
                ],
                _text_($class, 'blue_enid3 white')
            );

            $response[] = d($titulos);

            $contenido = [];
            foreach ($data as $row) {

                $tipificacion = $row['nombre_tipificacion'];
                $total = $row['total'];
                $contenido[] = d_c(
                    [
                        $total,
                        $tipificacion
                    ], $class
                );

            }
            $response[] = d($contenido);
        }else{

            $titulo = _titulo("Aún no hay tipificaciones",3);
            $response[] = d($titulo,'text-center');

        }
        return d($response, 'mt-5 col-sm-12 p-0');
    }

}