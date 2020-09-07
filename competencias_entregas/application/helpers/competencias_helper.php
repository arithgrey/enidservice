<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function sin_ventas()
    {

        $texto = 'Ups! parece que algo anda mal, no hay ventas, 
        tenemos que regresar a conseguir clientes!';
        $response[] = d(_titulo($texto), 4, 1);
        $response[] = d(
            format_link('Ver artículos disponibles',
            [
                'href' => path_enid('home')
            ]
        ),_text_(_4auto,'mt-5'));
        return append($response);

    }

    function render($data)
    {
        if (es_data($data["metricas"])) {

            $metricas = $data['metricas'];
            $response = [];
            $ids_comisionistas = array_column($data['comisionistas'], "idusuario");

            foreach ($metricas as $row) {

                $id_vendedor = $row['id_vendedor'];
                if (in_array($id_vendedor, $ids_comisionistas)) {


                    $ventas = $row['ventas'];
                    $nombre_vendedor = substr($row['nombre_vendedor'], 0, 17);
                    $path_imagen = $row['path_imagen'];

                    $seccion_ventas = d($ventas, 'strong');
                    $seccion_nombre_vendedor = p($nombre_vendedor, 'text-underline text-uppercase fp7');

                    $seccion = [];
                    $seccion[] = a_enid(
                        img(
                            [
                                "src" => $path_imagen,
                                "onerror" => "this.src='../img_tema/user/user.png'",
                                'class' => 'mx-auto d-block rounded-circle mah_50'
                            ]
                        ), path_enid('usuario_contacto', $id_vendedor)
                    );
                    $seccion[] = flex($seccion_ventas, $seccion_nombre_vendedor, 'd-flex flex-column text-center');
                    $response[] = d($seccion, 'col col-md-1 border border-info p-3');
                }
            }

            $textos_top = ['del día', 'de la semana', 'del mes', 'del año'];
            $texto_top = $textos_top[$data['tipo_top']];
            $tablero[] = _titulo(_text_('Top de entregas', $texto_top));

            $links[] = a_enid('Top del día',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencia_entrega')
                ]
            );
            $links[] = a_enid('Top semanal',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencias_entregas', 1)
                ]
            );
            $links[] = a_enid('Top mensual',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencias_entregas', 2)
                ]
            );
            $links[] = a_enid('Top anual',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencias_entregas', 3)
                ]
            );
            $tablero[] = flex($links);

            $tablero[] = d(d($response, 13), 'container-fluid');
            return d($tablero, 10, 1);
        } else {

            return sin_ventas();
        }

    }


}
