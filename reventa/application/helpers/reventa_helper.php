<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render($usuarios, $intentos_reventa)
    {

        $response = [];
        $numero_usuarios = 0;
        if (es_data($usuarios)) {

            $ids_usuario_reventa =  array_unique(array_column($intentos_reventa,'id_usuario'));


            $titulos[] = d("Cliente", 3);
            $titulos[] = d("# Compras", 3);
            $titulos[] = d("# Cancelaciones", 2);
            $titulos[] = d("# Solicitudes", 2);
            $titulos[] = d("Puntuación", 2);
            $response[] = d($titulos, "row strong black text-uppercase");

            foreach ($usuarios as $row) {

                $nombre = format_nombre($row);
                $num_compras = $row["num_compras"];
                $num_cancelaciones = $row["num_cancelaciones"];
                $puntuacion = $row["puntuacion"];
                $id_usuario =  $row["id_usuario"];
                $total_compras = $row["total_compras"];
                $total =  $total_compras["total"];
                $compras = $total["compras"];
                $solicitudes = $total["solicitudes"];


                if (!in_array($id_usuario,$ids_usuario_reventa)){

                    $linea = [];
                    $linea[] = d(a_enid($nombre,['href' => path_enid('cross_selling', $id_usuario)]), 'text-uppercase black col-md-3');
                    $linea[] = d($compras, 3);
                    $linea[] = d($num_cancelaciones, 2);
                    $linea[] = d($solicitudes, 2);
                    $linea[] = d($puntuacion, 2);


                    $response[] = d(
                        $linea,
                        [
                            'class' => 'row border-bottom p-1',
                        ]
                    );

                    $numero_usuarios ++;


                }


            }

        }

        $titulo = _titulo(_text_('total', $numero_usuarios));
        $texto_total = d(d($titulo,12),13);

        array_unshift($response,$texto_total);

        return d($response, 8, 1);

    }

}
