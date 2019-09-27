<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_articulo($data)
    {


        $servicio = $data["servicio"];
        $num = $data["numero_valoraciones"];
        $comentarios = $data["comentarios"];

        $f[] = a_enid(
            text_icon("fa fa-chevron-right ir", "ESCRIBE UNA RESEÑA")
            ,
            [
                "class" => "escribir_valoracion white escribir",
                "href" => "../valoracion?servicio=" . $servicio,

            ]
        );
        $f[] = resumem_valoracion($num);
        $f[] = a_enid(
            "MÁS SOBRE EL VENDEDOR"
            ,
            [
                "href" => "../recomendacion/?q=" . $data["id_usuario"],
                "class" => "link_vendedor mt-5 f11 black underline bottom_100 strong"
            ]


        );
        $a = d(append($f), "d-flex flex-column justify-content-center text-center");
        $z[] = place("table_orden_1");
        $z[] = criterios();
        $z[] = add_text(
            comentarios($comentarios, $data["respuesta_valorada"]),
            d(redactar($comentarios, $num, $servicio), "mt-1")
        );

        $b = d(append($z), 12);
        return d($a,4).d("","col-lg-1"). d($b, 7);

    }

    function get_form_valoracion($servicio, $extra, $id_servicio)
    {

        $propietario = ($extra["id_usuario"] == $servicio[0]["id_usuario"]) ? 1 : 0;
        $nombre = ($extra["in_session"] == 1) ? $extra["nombre"] : "";
        $email = ($extra["in_session"] == 1) ? $extra["email"] : "";

        $r[] = h("ESCRIBE UNA RESEÑA", 3, "underline");
        $r[] = d("Sobre  " . pr($servicio, "nombre_servicio"));
        $r[] = form_open("", ["class" => "form_valoracion"]);
        $r[] = place("nuevo");
        $r[] = flex(
            "Valoración*",
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
            "", "text-valoracion"
        );
        $r[] = place("nuevo");
        $r[] = d("¿Recomendarías este producto?*", "text-valoracion strong");
        $r[] = btw(
            a_enid("SI", ["class" => 'recomendaria', "id" => 1]),
            a_enid("NO", ["class" => 'recomendaria', "id" => 0]),
            "display_flex_enid mt-4 mb-4"

        );
        $r[] = place("place_recomendaria");
        $r[] = place("nuevo");
        $r[] = ajustar(
            d("Tu opinión en una frase*", "text-valoracion strong"),

            input(
                [
                    "type" => "text",
                    "name" => "titulo",
                    "class" => "input-sm input",
                    "placeholder" => "Por ejemplo: Me encantó!",
                    "required" => "Agrega una breve descripción"
                ])
            , 6
        );

        $r[] = hiddens([
            "name" => "propietario",
            "class" => "propietario",
            "value" => $propietario
        ]);
        $r[] = place("nuevo");
        $r[] = btw(
            d("Tu reseña (comentarios)*", "text-valoracion strong"),
            d(
                input(
                    [
                        "type" => "text",
                        "name" => "comentario",
                        "placeholder" => "¿Por qué te gusta el producto o por qué no?",
                        "required" => "Comenta tu experiencia"
                    ]
                )
            )
            ,
            "display_flex_enid"

        );
        $r[] = place("nuevo");

        $input = d(
            input([

                "type" => "text",
                "name" => "nombre",
                "placeholder" => "Por ejemplo: Jonathan",
                "value" => $nombre . '"  ' . valida_readonly($nombre),
                "class" => "input form-control",
                "required" => true,
            ])
        );

        $r[] = btw(
            d("Nombre*", "text-valoracion strong"),
            $input,

            "display_flex_enid"

        );
        $r[] = hiddens(
            [
                "name" => "id_servicio",
                "value" => $id_servicio
            ]
        );
        $r[] = place("nuevo");


        $r[] = btw(
            d(
                "Tu correo electrónico*", "text-valoracion strong"
            ),
            d(
                input([
                    "type" => "email",
                    "name" => "email",
                    "class" => "input form-control",
                    "placeholder" => "Por ejemplo: jmedrano@enidservices.com",
                    "required" => valida_readonly($email),
                    "value" => $email
                ])
            ),
            "display_flex_enid"

        );
        $r[] = place("nuevo");
        $r[] = btn(text_icon('fa fa-chevron-right ir', "ENVIAR RESEÑA "), ["class"=> "top_40 bottom_40"]);
        $r[] = place("place_registro_valoracion");
        $r[] = form_close();

        $social = social(0, "Mira lo que compré en Enid service!");
        $encuesta[] = d(d(append($r), 10, 1), 1);
        $encuesta[] = d(d($social, "col-lg-10 col-lg-offtse-1 bottom_50"), 1);
        $response[] = d(append($encuesta), "col-lg-6 col-lg-offset-3 shadow padding_10 bottom_50");


        return append($response);

    }

    function get_form_pregunta_consumidor($id_servicio, $propietario, $vendedor, $servicio)
    {

        if (!es_data($servicio) || !es_data($vendedor)) {
            return "";
        }
        $r[] = textarea(
            [
                "class" => "form-control",
                "id" => "pregunta",
                "name" => "pregunta",
                "placeholder" => "Tu pregunta"
            ]
        );

        $r[] = hiddens(["name" => "servicio", "value" => $id_servicio]);
        $r[] = hiddens(["name" => "propietario", "class" => "propietario", "value" => $propietario]);
        $r[] = place("place_area_pregunta");
        $r[] = place("nuevo");
        $r[] = btn(text_icon("fa fa-chevron-right ir", "ENVIAR PREGUNTA"));
        $r[] = place("place_registro_valoracion");
        $z[] = h(add_text(
            "ESCRIBE UNA PREGUNTA ",
            pr($vendedor, "nombre"),
            pr($vendedor, "apellido_paterno")
        ), 3);

        $nombre = a_enid(
            pr($servicio, "nombre_servicio"),
            [
                "class" => "underline black strong",
                "href" => get_url_servicio($id_servicio)
            ]
        );
        $z[] = d(add_text("SOBRE TU ", $nombre), "top_30  bottom_30");
        $z[] = form_open("", ["class" => "form_valoracion top_30"]);
        $z[] = append($r);
        $z[] = form_close();
        return append($z);

    }

    function get_notificacion_valoracion($usuario, $id_servicio)
    {

        if (es_data($usuario)) {

            $u = $usuario[0];
            $nombre = $u["nombre"];
            $email = $u["email"];
            $asunto = "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
            $text = "Que tal {$nombre}  un nuevo cliente dejó una reseña sobre uno de tus artículos 
            puedes consultarla aquí " . a_enid("buzón aquí", ["href" => "https://enidservices.com/inicio/producto/?producto={$id_servicio}&valoracion=1"]);
            $cuerpo = img_enid([], 1, 1) . h($text, 5);
            return get_request_email($email, $asunto, $cuerpo);

        }
    }

    function valida_readonly($text)
    {

        return mayorque(trim(strlen($text)), 1, "readonly");

    }

    function criterios()
    {
        $criterios = ["RELEVANTE", "RECIENTE"];
        $r = [];
        for ($z = 0; $z < count($criterios); $z++) {
            $extra_criterios = [
                "class" => 'criterio_busqueda ordenar_valoraciones_button  padding_5 border ',
                "id" => $z
            ];
            if ($z == 0) {

                $extra_criterios =
                    [
                        "class" => 'criterio_busqueda white ordenar_valoraciones_button  padding_5 white text-center bg-dark',
                        "id" => $z
                    ];
            }
            $r[] = d($criterios[$z], $extra_criterios);
        }

        return d(append($r), "d-flex   justify-content-end");
    }

    function resumem_valoracion($numero_valoraciones, $persona = 0)
    {

        if (es_data($numero_valoraciones)) {

            $valoracion = $numero_valoraciones[0];
            $num = $valoracion["num_valoraciones"];
            $comentarios = $num . ($num > 1) ? "COMENTARIOS" : "COMENTARIO";
            $promedio = number_format($valoracion["promedio"], 1, '.', '');
            $parte_promedio = d(crea_estrellas($promedio) . span($promedio, ["class" => 'promedio_num f15 strong black']), ["class" => 'contenedor_promedios']);
            $parte_promedio .= tb(tr(td($comentarios, 'info_comentarios')));
            $parte_promedio .= d(porcentaje($num, $valoracion["personas_recomendarian"], 1) . "%", 'porcentaje_recomiendan');
            $parte_promedio .= igual($persona, 1, "de los consumidores recomiendan", "de los consumidores recomiendan este producto");
            return $parte_promedio;

        }

    }

    function comentarios($comentarios, $es_valorado)
    {

        $z = [];
        foreach ($comentarios as $row) {

            $id = $row["id_valoracion"];
            $num_util = $row["num_util"];

            $fecha_registro = $row["fecha_registro"];

            $config =
                [
                    "class" => 'contenedor_valoracion_info ',
                    "numero_utilidad" => $num_util,
                    "fecha_info_registro" => $fecha_registro
                ];


            $r[] = d(crea_estrellas($row["valoracion"], 1));
            $r[] = d($row["titulo"], 'titulo_valoracion');
            $r[] = d($row["comentario"], 'comentario_valoracion');

            if ($row["recomendaria"] == 1) {
                $r[] = d(text_icon("fa fa-check-circle", "Recomiendo este producto"), 'recomendaria_valoracion strong color_recomendaria');
            }

            $r[] = d(add_text($row["nombre"],  $fecha_registro ) , 'nombre_comentario_valoracion');
            $texto_valoracion = ($es_valorado === $id) ? d("Recibimos tu valoracion! ", 'text_recibimos_valoracion') :  "";
            $es_util = a_enid("SI" . span("[" . $num_util . "]", 'num_respuesta'),
                [
                    "class" => 'respuesta_util respuesta_ok valorar_respuesta mr-4 blue_enid',
                    "id" => $id,
                    "onclick" => "agrega_valoracion_respuesta('" . $id . "' , 1)"
                ]
            );

            $btn_no_util = a_enid("NO" . span("[" . $row["num_no_util"] . "]", 'num_respuesta'),
                [
                    "class" => 'respuesta_no valorar_respuesta mr-4 blue_enid',
                    "id" => $id,
                    "onclick" => "agrega_valoracion_respuesta('" . $id . "' , 0)"
                ]
            );


            $a = tr(
                add_text(

                    td(h("¿Te ha resultado útil?", 5, "letter-spacing-5 strong")),
                    td($es_util . $btn_no_util)
                )
            );
            $b = tr(td($texto_valoracion));
            $r[] = d(tb(add_text($a, $b)), 'contenedor_utilidad');
            $z[] = d(d(append($r), add_attributes($config)), "contenedor_global_recomendaciones");
        }
        return d(append($z));
    }

    function redactar($comentarios, $numero_valoraciones, $servicio)
    {
        $response = "";
        if (es_data($comentarios) && count($comentarios) > 5) {

            if (pr($numero_valoraciones, "num_valoraciones") > 6) {

                $response = a_enid(text_icon("fa fa-chevron-right ir", "CARGAR MÁS"),
                    "cargar_mas_valoraciones");

            } else {

                $response = a_enid(text_icon("fa fa-chevron-right ir", "ESCRIBE UNA RESEÑAESCRIBE UNA RESEÑA "),
                    [
                        "class" => "escribir_valoracion",
                        "href" => "../valoracion?servicio=" . $servicio
                    ]);
            }

        }
        return $response;
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
                    "class" => 'input-start',
                    "type" => "radio"
                ]
            );

            $response[] = label("★",
                [
                    "class" => 'estrella ' . "estrella_" . $x,
                    "for" => "$id_input",
                    "id" => $x,
                    "title" => $x . " - " . $calificacion[$x]
                ]
            );

        }
        return append($response);
    }
}