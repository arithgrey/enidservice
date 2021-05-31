<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function sin_seguir()
    {

        $response[] = d(_titulo("Sigue a otros para ver qué posición ocupas en la tabla", 4), "mt-5");
        $response[] = d("", "seccion_sugerencias mt-5");
        return d($response,10,1);

    }
    function render($data)
    {

        $conexiones_ranking = $data["conexiones_ranking"];
        $id_seguidor = $data["id_seguidor"];

        if (es_data($conexiones_ranking)){
            $response[] = d(ranking($conexiones_ranking, $id_seguidor), 10, 1);
        }else{

            $response[] = sin_seguir();
        }
        $response[] = hiddens(
            [
                "name" => "id_usuario",
                "class" => "id_usuario",
                "value" => $id_seguidor
            ]
        );
        return append($response);

    }

    function ranking($usuarios, $id_seguidor)
    {
        sksort($usuarios, "ventas", false);
        $response = [];
        $a = 1;
        $response[] = d(_titulo("Clasificación", 4), 'text-center');



        $texto = flex(icon(_flecha_derecha), "Descubre otras cuentas ", "", "mr-3");
        $response[] = d($texto, 'f12 black cursor_pointer otras_cuentas');
        $response[] = d(d("","seccion_sugerencias"), 'seccion_sugerencias_disponibles col-sm-12 d-none mt-5 mb-5');

        $texto = flex(icon(_flecha_derecha), "Mira tus estadísticas ", "", "mr-3");
        $path = path_enid("busqueda");
        $response[] = d(a_enid($texto, ['href' => $path , "class" => "f12 black cursor_pointer"]), "link_estadisticas d-none");

        $titulos = flex("Participantes", "Ventas", _text_(_between, 'f12 black text-secondary'));
        $response[] = d($titulos," mt-5");
        foreach ($usuarios as $row) {

            $id_usuario = $row["id_usuario"];
            $nombre_vendedor = substr(format_nombre($row), 0, 17);
            $path_imagen = $row['path_imagen'];
            $seccion_nombre_vendedor = p($nombre_vendedor, 'fp9');
            $seccion = [];
            $ext = ($id_usuario == $id_seguidor) ? 'bg_custom_green white':'';
            $imagen = a_enid(
                img(
                    [
                        "src" => $path_imagen,
                        "onerror" => "this.src='../img_tema/user/user.png'",
                        'class' => 'mx-auto d-block rounded-circle mah_50'
                    ]
                ), path_enid('usuario_contacto', $id_usuario)
            );

            $posicion = d($a, 'bg_custom_green p-2 white');
            $seccion[] = flex($imagen, $posicion, 'mt-4');

            $seccion[] = d($seccion_nombre_vendedor, 'my-auto text-uppercase mr-auto ml-5');
            $ventas = $row["ventas"];

            $atributos = [
                "class" => 'my-auto text-center cursor_pointer',
                "id" => $id_usuario
            ];
            $seccion[] = d($ventas, $atributos);
            $response[] = d($seccion, _text_('border-bottom d-flex flex-row justify-content-between p-3', $ext));

            $a++;
        }


        return append($response);

    }


}
