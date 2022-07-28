<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function sin_ventas()
    {

        $links[] = a_enid('Top del día',
            [
                'class' => 'black mr-5 mt-5 mb-5 underline',
                'href' => path_enid('top_competencia')
            ]
        );
        $links[] = a_enid('Top semanal',
            [
                'class' => 'black mr-5 mt-5 mb-5 underline',
                'href' => path_enid('top_competencias', 1)
            ]
        );
        $links[] = a_enid('Top mensual',
            [
                'class' => 'black mr-5 mt-5 mb-5 underline',
                'href' => path_enid('top_competencias', 2)
            ]
        );
        $links[] = a_enid('Top anual',
            [
                'class' => 'black mr-5 mt-5 mb-5 underline',
                'href' => path_enid('top_competencias', 3)
            ]
        );


        $texto = 'Ups! parece que algo anda mal, no hay ventas, 
        tenemos que regresar a conseguir clientes!';
        $response[] = d(_titulo($texto), 4, 1);
        $response[] = d(
            format_link('Ver artículos disponibles',
            [
                'href' => path_enid('home')
            ]
        ),_text_(_4auto,'mt-5'));

        $response[] = d(flex($links),4,1);
        $response[] = d(mas_actividades(),4,1);

        return append($response);

    }  
    function mas_actividades(){

        return format_link(
            "Actividades recién notificadas",
            [
                "href" => path_enid("busqueda")   ,
                "class" =>  "mt-5"             
            ],0
        );
    }

    function render($data)
    {
        if (es_data($data["metricas"])) {

            $metricas = $data['metricas'];
            $response = [];            
            $ids_comisionistas = array_column($data['comisionistas'], "id");

            foreach ($metricas as $row) {

                $id_vendedor = $row['id_vendedor'];
                if (in_array($id_vendedor, $ids_comisionistas)) {

                    $ventas = $row['ventas'];
                    $nombre_vendedor = substr($row['nombre_vendedor'], 0, 17);
                    $url_img_usuario = $row['url_img_usuario'];

                    $seccion_ventas = d($ventas, 'strong');
                    $seccion_nombre_vendedor = p($nombre_vendedor, 'text-underline text-uppercase fp7');

                    $seccion = [];
                    $seccion[] = a_enid(
                        img(
                            [
                                "src" => $url_img_usuario,
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
            $tablero[] = d(_titulo(_text_('Top de ventas', $texto_top)), 'text-center');
            $tablero[] = d("Aquí verás el top de personas que han vendido más en este tiempo","text-center");


            $links[] = a_texto(
                'Top del día',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencia')
                ]
            );
            $links[] = a_texto(
                'Top semanal',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencias', 1)
                ]
            );
            $links[] = a_texto(
                'Top mensual',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencias', 2)
                ]
            );
            $links[] = a_texto(
                'Top anual',
                [
                    'class' => 'black mr-5 mt-5 mb-5 underline',
                    'href' => path_enid('top_competencias', 3)
                ]
            );

            $tablero[] = flex($links, ' justify-content-center f12');
            $fotos_top = d($response, 'row justify-content-center ');
            $tablero[] = d($fotos_top, 'container-fluid');
            $tablero[] = d(mas_actividades(),4,1);
            

            return d($tablero, 10, 1);
        } else {

            return sin_ventas();
        }

    }


}
