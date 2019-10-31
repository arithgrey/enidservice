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
        $r[] = h("ESCRIBE UNA RESEÑA", 3, "strong");
        $r[] = d("Sobre  " . $nombre_servicio);
        $r[] = form_open("",
            [
                "class" => "form_valoracion"
            ]
        );


        $r[] = flex(
            h("¿Qué valoración darías a este artículo?",3 , ' strong mr-3 '),
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
            "d-flex align-items-end", "text-valoracion"
        );
        $r[] = d("¿Recomendarías este producto?*", "text_recomendarias text-valoracion strong mb-5 mt-5");
        $r[] = btw(
            a_enid("SI", ["class" => 'recomendaria', "id" => 1]),
            a_enid("NO", ["class" => 'recomendaria', "id" => 0]),
            "display_flex_enid mt-4 mb-4"

        );

        $r[] = place("nuevo");

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
        if (strlen($readonly) > 0) {
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
        if (strlen($readonly) > 0) {
            $config_email['readonly '] = true;
        }

        $r[] = input_frm(
            "mt-5", "Tu correo electrónico*",
            $config_email

        );

        $r[] = place("nuevo");
        $r[] = btn(text_icon('fa fa-chevron-right ir', "ENVIAR RESEÑA "), ["class" => "top_40 bottom_40"]);
        $r[] = place("place_registro_valoracion");
        $r[] = form_close();

        $social = social(0, "Mira lo que compré en Enid service!");
        $encuesta[] = d(append($r), 6, 1);
//        $encuesta[] = d(d($social, "col-lg-10 col-lg-offtse-1 bottom_50"), 1);
        $response[] = append($encuesta);


        //DEJÉ col-lg-12 para el margen del mobile
        return d(append($response), 'col-lg-12');

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
