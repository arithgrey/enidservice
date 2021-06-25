<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_busqueda($data)
    {

        $response[] = d(_titulo('Busqueda', 2), _mbt5);
        $response[] = input_frm('', '¿A quién buscamos? Nombre, email, teléfono', [
                'name' => 'q',
                'id' => 'q',
                'class' => 'q nombre_usuario'
            ]
        );

        $contenido[] = d($response, 8, 1);
        $contenido[] = d(place("seccion_usuarios"), 8, 1);

        return append($contenido);

    }

    function render($data)
    {

        $response = [];
        $usuario_busqueda = $data['usuario_busqueda'];
        if (es_data($usuario_busqueda)) {

            $usuario_calificacion = $data['usuario_calificacion'];
            $calificacion = $usuario_calificacion['promedio'];
            $encuestas = $usuario_calificacion['encuestas'];
            $nombre_usuario = pr($usuario_busqueda, 'nombre_usuario');
            $id_usuario = pr($usuario_busqueda, 'id_usuario');
            $url_img_usuario = pr($usuario_busqueda, 'url_img_usuario');
            $nombre = format_nombre($usuario_busqueda);
            $descripcion[] = h($nombre, 1, ['class' => 'display-2 text-uppercase strong']);
            $link = es_administrador($data) ? path_enid('busqueda_usuario', $id_usuario) : '';
            $es_propietario = ($data['in_session'] && $data['id_usuario'] === $id_usuario);

            $imagen = a_enid(
                img(
                    [
                        "src" => $url_img_usuario,
                        "onerror" => "this.src='../img_tema/user/user.png'",
                        "class" => "rounded-circle img_servicio_def"
                    ]
                )
                ,
                $link
            );


            $seccion_calificacion = posibilidades($calificacion, $encuestas, $id_usuario, $data, $es_propietario);

            if ($es_propietario) {

                $icono_link = icon(_text_(_editar_icon, 'black border p-5 border-info'));
                $contenido[] = a_enid(
                    $icono_link,
                    [
                        'href' => path_enid('administracion_cuenta')
                    ]
                );
            }

            $contenido[] = flex($imagen, $seccion_calificacion, _between);
            $texto_puesto = roll($data);
            $texto_titulo = h($texto_puesto, 2, 'title display-5');
            $contenido[] = d(d(_text_($texto_titulo), 'caption'), 'circle');
            $contenido[] = p($nombre_usuario, 'update-note');
            $response[] = d($descripcion, 'demo-title col-md-12');
            $response[] = get_base_html("header", append($contenido), ['class' => ' col-md-12', 'id' => 'header1']);
            $response[] = seguidores($data);
            $response[] = d(seccion_estadisticas($data), "col-md-12 mt-5");
            $contenedor[] = d($response, 'col-md-6 col-md-offset-3  bg-light p-5 contenedor_perfil');

            $contenedor[] = d(formulario_calificacion($data), 'col-md-6 col-md-offset-3  bg-light p-5 mt-5 contenedor_encuesta_estrellas d-none');
            $contenedor[] = d(formulario_calificacion_tipificacion($data), 'col-md-6 col-md-offset-3  bg-light p-5 mt-5 d-none contenedor_encuesta_tipificcion');


        } elseif ($data['encuesta'] > 0) {
            $contenedor[] = d(notificacion_encuesta(), 'col-md-6 col-md-offset-3 bg-light p-5 mb-5');
        } else {

            $texto[] = h(_text_(strong('Ups!'), 'no encontramos a este ', strong('usuario')), 1, 'text-center  text-uppercase');
            $texto[] = format_link('Sigue comprando', ['class' => 'mt-5 col-md-8 col-md-offset-2', 'href' => path_enid('home')]);
            $contenedor[] = d($texto, 'col-md-4 col-md-offset-4 mt-5 bg-light p-5');
        }

        return append($contenedor);

    }


    function seguidores($data)
    {
        $response = "";
        $usuario_busqueda = $data["usuario_busqueda"];
        if (!es_cliente($usuario_busqueda)) {
            $response = d(d($data["total_seguidores"], _4p), "col-md-12");
        }
        return $response;
    }

    function roll($data)
    {

        $usuario_busqueda = $data["usuario_busqueda"];
        $texto_puesto = "";
        if (!es_cliente($usuario_busqueda)) {
            $perfil_busqueda = $data['perfil_busqueda'];
            $nombre_perfil = pr($perfil_busqueda, 'nombreperfil');
            $texto_puesto = _text_('Equipo', strong($nombre_perfil));
        }

        return $texto_puesto;
    }

    function seccion_estadisticas($data)
    {
        $usuario_busqueda = $data["usuario_busqueda"];
        $r = [];
        if (!es_cliente($usuario_busqueda)) {

            $r[] = d(_titulo("estadísticas", 4), "mt-5");
            $r[] = d(p("Actividades en los últimos 30 días", "text-secondary"));

            $meta_semanal_comisionista = $data['meta_semanal_comisionista'];
            $total_ventas_semana = (es_data($data['ventas_semana'])) ? count($data['ventas_semana']) : 0;

            $restantes = ($meta_semanal_comisionista - $total_ventas_semana);

            $icono_meta = text_icon(_dolar_icon, 'Meta semanal');
            $seccion_meta = flex($icono_meta, $meta_semanal_comisionista, 'flex-column');

            $icono_logros = text_icon(_checked_icon, 'Logros fecha');
            $ventas_actuales = flex($icono_logros, $total_ventas_semana, 'flex-column');

            $icono_restantes = text_icon(_spinner, "restantes");
            $restantes = flex($icono_restantes, $restantes, 'flex-column strong black');

            $link_ventas = a_texto('Mis ventas',
                [
                    'class' => 'text-center ',
                    'href' => path_enid('pedidos')
                ]
            );
            $text_ventas = text_icon(_bomb_icon, $link_ventas);
            $texto_top = 'Identifica tus ordenes de compras enviadas';
            $texto_ventas = flex(
                $text_ventas, $texto_top, 'flex-column', "", "fp8 mt-3 text-secondary");

            $link_top_ventas = a_texto('Top ventas',
                [
                    'class' => 'text-center black',
                    'href' => path_enid('top_competencia')
                ]
            );

            $icono_top = text_icon(_estrellas_icon, $link_top_ventas);
            $texto_top = 'Mira qué posición ocupas en la tabla';
            $texto_top_ventas = flex(
                $icono_top, $texto_top, 'flex-column', "", "fp8 mt-3 text-secondary");

            $r[] = d(
                d_c(
                    [
                        $seccion_meta,
                        $ventas_actuales,
                        $restantes,
                        $texto_ventas,
                        $texto_top_ventas
                    ],
                    'f11 col-lg-2 mx-auto text-center mt-5'), 'row black');

        }
        return append($r);

    }

    function notificacion_encuesta()
    {

        $response[] = d(_titulo('Gracias por ayudar a mejorar nuestro servicio!', 2), 'text-center  text-uppercase');
        $response[] = d(format_link('Sigue explorando',
            [
                "href" => path_enid("home")
            ]
        ), 'col-md-4 col-md-offset-4 mt-5');
        return append($response);
    }

    function posibilidades($calificacion, $encuestas, $id_usuario, $data, $es_propietario)
    {
        $response = [];
        for ($x = 1; $x <= 5; $x++) {

            $id_input = "radio" . $x;
            $estrellas[] = input(
                [
                    "id" => $id_input,
                    "value" => $x,
                    "class" => 'input-start f2',
                    "type" => "radio"
                ]
            );

            $estrellas[] = label("★",
                [
                    "class" => ' black' . " f2 estrella_" . $x,
                    "for" => "$id_input",
                    "id" => $x,
                    "title" => $x . " - " . $calificacion[$x]
                ]
            );

        }

        $response[] = d(_titulo(round($calificacion, 2)), 'text-center');
        $response[] = d(_text_('Valoraciones', strong($encuestas)), 'text-center');
        $response[] = d($estrellas);


        if (!$es_propietario) {

            $response[] = d(
                format_link('Califícame',
                    [
                        'class' => 'calificame',
                        'id' => $id_usuario
                    ]
                )
            );

        }


        $id_usuario_califica = ($data['in_session']) ? $data['id_usuario'] : 0;
        $response[] = hiddens(['class' => 'input_id_usuario', 'value' => $id_usuario]);
        $response[] = hiddens(['class' => 'input_id_usuario_califica', 'value' => $id_usuario_califica]);
        return append($response);
    }

    function formulario_calificacion($data)
    {

        $usuario_busqueda = $data['usuario_busqueda'];
        $id_usuario = pr($usuario_busqueda, 'id_usuario');
        $titulo = _titulo('¿Qué calificación me darías?');
        $imagen = img(
            [
                "src" => path_enid("imagen_usuario", $id_usuario),
                "onerror" => "this.src='../img_tema/user/user.png'",
                "class" => "rounded-circle mah_50"
            ]
        );
        $titulo_imagen = flex($imagen, $titulo, '', 'mr-3');
        $r[] = $titulo_imagen;
        $r[] = posibles_calificaciones(
            [
                "",
                "Insuficiente",
                "Aceptable",
                "Promedio",
                "Bueno",
                "Excelente!"
            ]
        );
        $r[] = d_p('', 'texto_calificacion display-4 black');
        $r[] = d_p("Ayúdanos a mejorar nuestro servicio", 'text-center');

        $encuesta[] = d($r, _text_('col-md-8 col-md-offset-2 '));
        $response[] = append($encuesta);
        return d($response, 'col-lg-12 text-center');

    }

    function formulario_calificacion_tipificacion($data)
    {

        $usuario_busqueda = $data['usuario_busqueda'];
        $tipificaciones = $data['tipificaciones'];
        $id_usuario = pr($usuario_busqueda, 'id_usuario');
        $titulo = _titulo('¿Aspecto a  calificar?');
        $imagen = img(
            [
                "src" => path_enid("imagen_usuario", $id_usuario),
                "onerror" => "this.src='../img_tema/user/user.png'",
                "class" => "rounded-circle mah_50"
            ]
        );
        $titulo_imagen = flex($imagen, $titulo, _between, 'mr-3');
        $r[] = d($titulo_imagen, 12);
        $label_tipificacion = [];
        foreach ($tipificaciones as $row) {


            $label_tipificacion[] = d(
                format_link(
                    $row['tipificacion'],
                    [
                        'class' => 'tipificacion',
                        'id' => $row['id']
                    ], 0
                ), 'col-md-4 mt-4'
            );

        }


        $response[] = d($r, 13);
        $response[] = d($label_tipificacion, 13);
        $input = d(input_frm(12, 'Dejar un comentario',
            [
                'class' => 'input_comentario',
                'id' => 'input_comentario'
            ]), 'mt-5 row');

        $response[] = $input;


        $response[] = hiddens(["class" => "input_id_servicio", "value" => prm_def($data, "id_servicio")]);
        $enviar_puntuacion = btn('Enviár',
            [
                'class' => 'enviar_formulario_boton col-md-3 ml-auto'
            ]
        );
        $response[] = d($enviar_puntuacion, 'row mt-5');

        return d($response, 'col-lg-10 col-md-offset-1 text-center');

    }

    function posibles_calificaciones($calificacion)
    {
        $response = [];
        for ($x = 1; $x <= 5; $x++) {

            $id_input = "radio" . $x;
            $response[] = input(
                [
                    "id" => $id_input,
                    "value" => $x,
                    "class" => 'input-start f2',
                    "type" => "radio"
                ]
            );

            $response[] = label("★",
                [
                    "class" => 'estrella ' . " f2 estrella_" . $x,
                    "for" => "$id_input",
                    "id" => $x,
                    "title" => $x . " - " . $calificacion[$x],
                    "texto_calificacion" => $calificacion[$x]
                ]
            );

        }
        return append($response);
    }
}
