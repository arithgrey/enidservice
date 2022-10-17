<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render($usuarios, $intentos_reventa)
    {

        $numero_usuarios = 0;

        if (es_data($usuarios)) {

            $ids_usuario_reventa = array_unique(array_column($intentos_reventa, 'id_usuario'));
            $titulos[] = d("Cliente", 3);
            $titulos[] = d("# Compras", 3);
            $titulos[] = d("# Cancelaciones", 2);
            $titulos[] = d("# Solicitudes", 2);
            $titulos[] = d("Puntuación", 2);

            $formato_titulos = d($titulos, "row strong black text-uppercase mb-5");
            $response[] = $formato_titulos;

            foreach ($usuarios as $row) {

                $nombre = format_nombre($row);
                $num_cancelaciones = $row["num_cancelaciones"];
                $puntuacion = $row["puntuacion"];
                $id_usuario = $row["id_usuario"];
                $total_compras = $row["total_compras"];
                $total = $total_compras["total"];
                $compras = $total["compras"];
                $solicitudes = $total["solicitudes"];

                if (!in_array($id_usuario, $ids_usuario_reventa)) {

                    $linea = [];
                    $atributos = [
                        'href' => "",
                        'class' => "black fp9"
                    ];
                    $linea[] = d(a_enid($nombre, $atributos), 'text-uppercase black col-md-3');
                    $linea[] = d($compras, 3);
                    $linea[] = d($num_cancelaciones, 2);
                    $linea[] = d($solicitudes, 2);
                    $linea[] = d($puntuacion, 2);

                    $response[] = d(
                        $linea,
                        [
                            'class' => 'row border-bottom p-1 border-dark',
                        ]
                    );

                    $numero_usuarios++;

                }

            }

            $titulo = _titulo(_text_('total', $numero_usuarios));
            $texto_total = d(d($titulo, 12), 13);

            array_unshift($response, $texto_total);

        }else{
            $response[] = busqueda_clientes();
        }




        return d($response, 10, 1);

    }

    function busqueda_clientes()
    {

        $response[] = d(
            'Aquí verás  clientes que podrían comprarte nuevamente, realiza tus primeras ventas para aumentar tu lista',
            _text_('h3 text-uppercase black font-weight-bold', _6auto));

        $response[] = d(
            format_link('Ver artículos disponibles',
                [
                    'href' => path_enid('home')
                ]
            ), _text_(_4auto, 'mt-5'));
        $response[] = d(

            img(
                [
                    "src" => "https://media.giphy.com/media/2hAjRJoLzYLqoRHvq2/giphy.gif",
                    "class" => "mt-5 mx-auto"
                ]
            )
            ,_6auto
        );
        $response[] = d(format_link(
            "Actividades recién notificadas",
            [
                "href" => path_enid("busqueda")   ,
                "class" =>  "mt-5"             
            ],0
        ),4,1);

        return append($response);

    }

}
