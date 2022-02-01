<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render($data)
    {

        $response = [];
        if (es_data($data)) {


            $tel_contacto = array_column($data, "tel_contacto");
            $correo = array_column($data, "email");
            $veces_telefono = array_count_values($tel_contacto);
            $veces_correo = array_count_values($correo);
            $contenido = [
                d(_titulo('Cliente'),2),
                d(_titulo('Compras'),'col-sm-2 text-center')
            ];
            $response[] = d($contenido, 'row');

            foreach ($data as $row) {

                $tel_contacto = $row["tel_contacto"];
                $email = $row["email"];
                $id_usuario = $row["id_usuario"];
                $nombre_cliente = d(format_nombre($row), 'col-md-2 text-uppercase');

                $total_telefono = busqueda_totales($veces_telefono, $tel_contacto);
                $total_correo = busqueda_totales($veces_correo, $email);

                $compras_totales = 0;
                if ($total_telefono > $total_correo) {
                    $compras_totales = $total_telefono;
                } elseif ($total_telefono == $total_correo) {
                    $compras_totales = $total_telefono;
                } else {
                    $compras_totales = $total_correo;
                }


                $contenido = [
                    $nombre_cliente,
                    d(
                        $compras_totales,
                        'col-sm-2 text-center'
                    )
                ];
                $response[] = d($contenido, 'row');


            }
        }

        return d($response, 12);

    }

    function busqueda_totales($data, $elemento)
    {

        $response = 0;
        foreach ($data as $clave => $valor) {

            if ($clave == $elemento) {


                $response = $valor;
                break;
            }
        }
        return $response;

    }

}
