<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $seguidores = $data["seguidores"];
        $siguiendo = $data["seguimiento"];

        $total_seguidores = count($seguidores);
        $total_siguiendo = count($siguiendo);

        $texto_seguidores = d(_text("Seguidores (", $total_seguidores, ")"), "black text-center mb-3 cursor_pointer");
        $texto_siguiendo = d(_text("Siguiendo (", $total_siguiendo, ")"), "text-secondary text-center mb-3 cursor_pointer");

        $response[] = d(_titulo("conexiones", 4), 'text-center');
        $linea_seguidores = d($texto_seguidores, "col-sm-6 solid_bottom_2 boton_seguidores");
        $linea_siguiendo = d($texto_siguiendo, "col-sm-6 boton_siguiendo");

        $selectores = append([$linea_seguidores, $linea_siguiendo]);
        $response[] = d($selectores, 'border-bottom row');

        $lista_siguiendo = lista_siguiendo($siguiendo);
        $contenido[] = $lista_siguiendo;

        $lista_seguidores = lista_seguidores($seguidores);
        $contenido[] = $lista_seguidores;


        $response[] = d(append($contenido));
        $response[] = form_dejar_seguir();


        return d($response, 6, 1);

    }

    function form_dejar_seguir()
    {

        $response[] = form_open("", [
            "method" => "PUT",
            "id" => "form_dejar_seguimiento",
            "class" => "form_dejar_seguimiento",
            "enctype" => "multipart/form-data"

        ]);

        $response[] = hiddens(
            [
                "id" => "usuario_conexion",
                "class" => "usuario_conexion",
                "name" => 'id',
                "value" => 0
            ]
        );

        $response[] = form_close();

        return append($response);

    }


    function lista_seguidores($usuarios)
    {
        $response = [];

        foreach ($usuarios as $row) {

            $id_vendedor = $row['id_usuario'];
            $nombre_vendedor = substr(format_nombre($row), 0, 17);
            $path_imagen = $row['path_imagen'];
            $seccion_nombre_vendedor = p($nombre_vendedor, 'black fp9');

            $seccion = [];
            $seccion[] = d(
                a_enid(
                    img(
                        [
                            "src" => $path_imagen,
                            "onerror" => "this.src='../img_tema/user/user.png'",
                            'class' => 'mx-auto d-block rounded-circle mah_50'
                        ]
                    ), path_enid('usuario_contacto', $id_vendedor)
                ));

            $seccion[] = d($seccion_nombre_vendedor, 'text-uppercase mrl-auto');
            $response[] = d($seccion, _text_(_between, "d-flex border-bottom p-3"));


        }

        if (!es_data($usuarios)) {

            $response[] = d(_titulo("Cuentas que te siguen", 4), "mt-5");
            $texto = flex(icon(_flecha_derecha), "Aquí verás las personas que te siguen", "", "mr-3");

            $response[] = d(p($texto, ["class" => "black"]), 'f12 black');

        }

        return d($response, 'mt-5 seccion_usuarios_seguidores');

    }

    function lista_siguiendo($usuarios)
    {
        $response = [];
        foreach ($usuarios as $row) {

            $id_vendedor = $row['id_usuario'];
            $id = $row["id"];
            $nombre_vendedor = substr(format_nombre($row), 0, 17);
            $path_imagen = $row['path_imagen'];
            $seccion_nombre_vendedor = p($nombre_vendedor, 'black fp9');

            $seccion = [];
            $seccion[] = d(
                a_enid(
                    img(
                        [
                            "src" => $path_imagen,
                            "onerror" => "this.src='../img_tema/user/user.png'",
                            'class' => 'mx-auto d-block rounded-circle mah_50'
                        ]
                    ), path_enid('usuario_contacto', $id_vendedor)
                ));

            $seccion[] = d($seccion_nombre_vendedor, 'text-uppercase mrl-auto');
            $seguir = d("Siguiendo", ['class' => 'strong black pr-3 pl-3 siguiendo', "id" => $id]);

            $atributos = [
                "class" => 'text-center border border-info rounded_enid cursor_pointer ',
                "id" => $id_vendedor
            ];
            $seccion[] = d($seguir, $atributos);
            $response[] = d($seccion, _text_(_between, "d-flex border-bottom p-3"));


        }

        return d($response, 'mt-5 seccion_usuarios_seguimiento d-none');

    }


}
