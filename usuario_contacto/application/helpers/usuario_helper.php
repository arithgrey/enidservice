<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render($data)
    {


        $response = [];
        $usuario_busqueda = $data['usuario_busqueda'];
        if (es_data($usuario_busqueda)) {

            $sexo = pr($usuario_busqueda, 'sexo');
            $opt = ["MUJER", "HOMBRE", "INDEFINIDO"];
            $texto_sexo = $opt[$sexo];

            $perfil_busqueda = $data['perfil_busqueda'];
            $nombre_perfil = pr($perfil_busqueda, 'nombreperfil');
            $nombre_usuario = pr($usuario_busqueda, 'nombre_usuario');

            $tel_contacto = format_phone(pr($usuario_busqueda, 'tel_contacto'));
            $email = pr($usuario_busqueda, 'email');

            $id_usuario = pr($usuario_busqueda, 'id_usuario');
            $nombre = format_nombre($usuario_busqueda);
            $descripcion[] = h($nombre, 1, ['class' => 'display-2 text-uppercase strong']);

            $contenido[] = img(
                [
                    'src' => path_enid("imagen_usuario", $id_usuario),
                    "onerror" => "this.src='../img_tema/user/user.png'"
                ]
            );

            $texto_puesto = _text_('Equipo', strong($nombre_perfil));
            $texto_titulo = h($texto_puesto, 2, 'title display-5');
            $descripcion_puesto = a_enid($email, ['class' => 'black']);

            $whats = p(_text_('WhatsApp', a_enid($tel_contacto, ['class' => 'strong black'])), 'black');

            $contenido[] = d(d(_text_($texto_titulo, $descripcion_puesto, $texto_sexo, $whats), 'caption'), 'circle');
            $contenido[] = p($nombre_usuario, 'update-note');
            $response[] = d($descripcion, 'demo-title col-md-12');
            $response[] = get_base_html("header", append($contenido), ['class' => 'header col-md-12', 'id' => 'header1']);


        } else {

            $texto[] = h(_text_(strong('Ups!'), 'no encontramos a este ', strong('usuario')), 1, 'text-center  text-uppercase');
            $texto[] = format_link('Sigue comprando', ['class' => 'mt-5 col-md-8 col-md-offset-2', 'href' => path_enid('home')]);
            $response = d($texto, 'col-md-6 col-md-offset-3 mt-5 bg-light p-5');
        }

        return d($response, 'col-md-6 col-md-offset-3  bg-light p-5');

    }

}
