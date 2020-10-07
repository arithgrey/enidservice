<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function recibos_evaluaciones($evaluaciones)
    {

        $response = [];
        if (es_data($evaluaciones)) {

            $items = ["Miembro", "Evaluaciones - recibos", "Promedio general"];
            $linea = d(d_c($items, 'col-lg-4 strong text-uppercase mt-5 black'),13);
            $response[] = $linea;
            foreach ($evaluaciones as $row) {

                $nombre_usuario = format_nombre($row);
                $puntuacion = $row["puntuacion"];
                $promedio = $row["promedio"];

                $path = path_enid('usuario_contacto', $row['id_usuario']);

                $estrellas = crea_estrellas($puntuacion);
                $estrellas_puntuacion = flex($puntuacion, $estrellas);
                $items = [
                    a_enid($nombre_usuario,
                        [
                            'href' => $path,
                            'class' => 'text-uppercase black '
                        ]
                    ),
                    $estrellas_puntuacion,
                    $promedio
                ];
                $linea = d(d_c($items, 'col-lg-4'), 'row border-bottom mt-2');
                $response[] = $linea;

            }

        }
        return d($response,12);
    }

}