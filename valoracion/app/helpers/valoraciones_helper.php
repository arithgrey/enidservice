<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function get_form_valoracion($data)
    {

        $servicio = $data["servicio"];
        $extra = $data["extra"];
        $id_servicio = pr($servicio, 'id_servicio');
        $nombre_servicio = pr($servicio, "nombre_servicio");
        $propietario = ($extra["id_usuario"] == pr($servicio, 'id_usuario'));
        $nombre = ($extra["in_session"]) ? $extra["nombre"] : "";
        $email = ($extra["in_session"]) ? $extra["email"] : "";

        $r[] = d(_titulo("ESCRIBE UNA RESEÑA"),'mt-5');
        $r[] = d(_text("Sobre  ", $nombre_servicio));
        $r[] = form_open("",
            [
                "class" => "form_valoracion"
            ]
        );


        $r[] = flex_md(
            h("¿Qué valoración darías a este artículo?", 3, ' strong mr-3 '),
            posibilidades(
                [
                    "",
                    "Insuficiente",
                    "Aceptable",
                    "Promedio",
                    "Bueno",
                    "Excelente"
                ]
            ),
            _between, "text-valoracion"
        );
        $r[] = d("¿Recomendarías este producto?*", "text_recomendarias text-valoracion strong mb-5 mt-5");
        $r[] = btw(
            a_enid("SI", ["class" => 'recomendaria', "id" => 1]),
            a_enid("NO", ["class" => 'recomendaria', "id" => 0]),
            "display_flex_enid mt-4 mb-4"

        );
        $r[] = hiddens(
            [
                "name" => "propietario",
                "class" => "propietario",
                "value" => $propietario
            ]
        );
        $r[] = hiddens(
            [
                "name" => "id_servicio",
                "value" => $id_servicio
            ]
        );
        $r[] = input_frm(
            "mt-5",
            "Tu opinión en una frase*",
            [
                "type" => "text",
                "name" => "titulo",
                "class" => "opinion_frase",
                "id" => "opinion_frase",
                "placeholder" => "Por ejemplo: Me encantó!",
                "required" => "Agrega una breve descripción"
            ],
            "nuevo"
        );

        $r[] = input_frm(
            "mt-5", "Tu reseña (comentarios)*",
            [
                "type" => "text",
                "name" => "comentario",
                "class" => "comentario",
                "id" => "comentario",
                "placeholder" => "¿Por qué te gusta el producto o por qué no?",
                "required" => "Comenta tu experiencia"
            ]

        );
        $config =
            [
                "type" => "text",
                "name" => "nombre",
                "placeholder" => "Por ejemplo: Jonathan",
                "value" => $nombre,
                "class" => "nombre",
                "id" => "nombre",
                "required" => true,
            ];

        $readonly = valida_readonly($nombre);
        if (str_len($readonly, 0)) {
            $config['readonly '] = true;
        }
        $r[] = input_frm("mt-5", "Tu Nombre", $config);

        $config_email = [
            "type" => "email",
            "name" => "email",
            "class" => "email",
            "id" => 'email',
            "placeholder" => "Por ejemplo: jmedrano@enidservices.com",
            "value" => $email
        ];
        if (str_len($readonly, 0)) {
            $config_email['readonly '] = true;
        }

        $r[] = input_frm(
            "mt-5", "Tu correo electrónico*",
            $config_email

        );

        $r[] = place("nuevo");
        $r[] = btn(text_icon('fa fa-chevron-right ir', "ENVIAR RESEÑA "), ["class" => "top_40 bottom_40"]);
        $r[] = h('Tu valoración quedó registrada!', 4, 'text-center mt-5  registro_valoracion d-none');
        $r[] = d(
            d(
                format_link('más recomendaciones',
                    [
                        'href' => path_enid('producto', _text($id_servicio, '&valoracion=1')),

                    ], 0), 4, 1
            ), 'registro_valoracion d-none');

        $r[] = h('¿Aún no tienes una cuenta?', 4, 'text-center mt-5 registro_usuario d-none');

        $r[] = d(
            d(
                format_link('Registrate ahora!',
                    [
                        'href' => path_enid('nuevo_usuario')
                    ], 0), 4, 1
            ), 'registro_usuario d-none'
        );

        $r[] = form_close();

        $encuesta[] = d(append($r), 6, 1);
        $response[] = append($encuesta);
        return d($response, 'col-lg-12 p-0');

    }

    function posibilidades($calificacion)
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
                    "title" => $x . " - " . $calificacion[$x]
                ]
            );

        }
        return append($response);
    }

    function valida_readonly($text)
    {

        return mayorque(trim(strlen($text)), 1, "readonly");

    }
}
