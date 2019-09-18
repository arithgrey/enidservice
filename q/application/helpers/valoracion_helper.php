<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_articulo($data)
    {


        $servicio = $data["servicio"];
        $num_valoraciones = $data["numero_valoraciones"];
        $comentarios = $data["comentarios"];

        $f[] = a_enid(
            text_icon("fa fa-chevron-right ir", "ESCRIBE UNA RESEÑA")
            ,
            [
                "class" => "escribir_valoracion white escribir",
                "href" => "../valoracion?servicio=" . $servicio,

            ]
        );
        $f[] = resumem_valoracion($num_valoraciones);
        $f[] = a_enid(
            "MÁS SOBRE EL VENDEDOR"
            ,
            [
                "href" => "../recomendacion/?q=" . $data["id_usuario"] ,
                "class" => "link_vendedor mt-5 f11 black underline bottom_100 strong"
        ]


        );
        $a = d(append($f), "d-flex flex-column justify-content-center text-center");


        $z[] = d("", "table_orden_1");
        //$z[] = flex("", criterios_busqueda(), "row","col-lg-8 row", "col-lg-4  row");
        $z[] = d(criterios_busqueda(), "d-flex row  justify-content-end");


        $z[] = add_text(
            valoraciones_comentarios($comentarios, $data["respuesta_valorada"]),
            d(redacta_valoracion($comentarios, $num_valoraciones, $servicio), "btn_escribir_valoracion")
        );

        $b = d(append($z),12);
        return ajustar($a , $b , 4, "top_100 ");

    }

    function get_form_valoracion($servicio, $extra, $id_servicio)
    {

        $propietario = ($extra["id_usuario"] == $servicio[0]["id_usuario"]) ? 1 : 0;
        $nombre = "";
        $email = "";
        if ($extra["in_session"] == 1) {
            $nombre = $extra["nombre"];
            $email = $extra["email"];
        }

        $r[] = h("ESCRIBE UNA RESEÑA", 3, "underline");
        $r[] = d("Sobre  " . pr($servicio, "nombre_servicio"));
        $r[] = form_open("", ["class" => "form_valoracion"]);
        $r[] = place("nuevo");
        $r[] = btw(
            d("Valoración*", "text-valoracion"),
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
            "displa_flex_enid"
        );
        $r[] = place("nuevo");
        $r[] = d("¿Recomendarías este producto?*", "text-valoracion strong");
        $r[] = btw(
            a_enid("SI", ["class" => 'recomendaria', "id" => 1]),
            a_enid("NO", ["class" => 'recomendaria', "id" => 0]),
            "display_flex_enid top_30 bottom_20"

        );
        $r[] = place("place_recomendaria");
        $r[] = place("nuevo");
        $r[] = btw(
            d("Tu opinión en una frase*", "text-valoracion strong"),
            d(
                input(
                    [
                        "type" => "text",
                        "name" => "titulo",
                        "class" => "input-sm input",
                        "placeholder" => "Por ejemplo: Me encantó!",
                        "required" => "Agrega una breve descripción"
                    ])
            ),
            "display_flex_enid"
        );

        $r[] = input_hidden([
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

        $input =
            d('<input type="text" name="nombre" 
	        placeholder="Por ejemplo: Jonathan" 
	        value="' . $nombre . '"  ' . valida_readonly($nombre) . ' 
	        class="input form-control"
            required>');

        $r[] = btw(
            d("Nombre*", "text-valoracion strong"),
            $input,

            "display_flex_enid"

        );
        $r[] = input_hidden(
            [
                "name" => "id_servicio",
                "value" => $id_servicio
            ]
        );
        $r[] = place("nuevo");

        $in = d('<input type="email" 
        name="email" 
        	        class="input form-control"
        placeholder="Por ejemplo: jmedrano@enidservices.com" 
        required ' . valida_readonly($email) . ' value="' . $email . '">');

        $r[] = btw(
            d(
                "Tu correo electrónico*", "text-valoracion strong"
            ),
            $in,
            "display_flex_enid"

        );
        $r[] = place("nuevo");
        $r[] = br(3);
        $r[] = btn(text_icon('fa fa-chevron-right ir', "ENVIAR RESEÑA "), ["class" => "top_40 bottom_40"]);
        $r[] = place("place_registro_valoracion");
        $r[] = form_close();
        $r[] = br(3);


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
            ]);

        $r[] = input_hidden(["name" => "servicio", "value" => $id_servicio]);
        $r[] = input_hidden(["name" => "propietario", "class" => "propietario", "value" => $propietario]);
        $r[] = place("place_area_pregunta");
        $r[] = place("nuevo");
        $r[] = btn(text_icon("fa fa-chevron-right ir", "ENVIAR PREGUNTA"));
        $r[] = place("place_registro_valoracion");


        $text = strtoupper(
            pr($vendedor, "nombre")
            . " " .
            pr($vendedor, "apellido_paterno")
        );

        $z[] = h("ESCRIBE UNA PREGUNTA " . $text, 3);


        $nombre = a_enid(pr($servicio, "nombre_servicio"), [
            "class" => "underline black strong",
            "href" => get_url_servicio($id_servicio)
        ]);
        $z[] = d("SOBRE SU " . $nombre, "top_30  bottom_30");
        $z[] = form_open("", ["class" => "form_valoracion top_30"]);
        $z[] = append($r);
        $z[] = form_close();
        return append($z);

    }


    function get_notificacion_valoracion($usuario, $id_servicio)
    {

        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $nombre = $usuario["nombre"];
            $email = $usuario["email"];

            $asunto = "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
            $text = "Que tal {$nombre}  un nuevo cliente dejó una reseña sobre uno de tus artículos 
            puedes consultarla aquí " . a_enid("buzón aquí", ["href" => "https://enidservices.com/inicio/producto/?producto={$id_servicio}&valoracion=1"]);
            $cuerpo = img_enid([], 1, 1) . h($text, 5);
            $sender = get_request_email($email, $asunto, $cuerpo);
            return $sender;

        }

    }

    function valida_readonly($text)
    {

        return mayorque(trim(strlen($text)), 1, "readonly");

    }

    function criterios_busqueda()
    {
        $criterios = ["RELEVANTE", "RECIENTE"];
        $l = [];
        for ($z = 0; $z < count($criterios); $z++) {
            $extra_criterios = [
                "class" => 'criterio_busqueda ordenar_valoraciones_button  padding_5 border ',
                "id" => $z
            ];
            if ($z == 0) {

                $extra_criterios =
                    [
                        "style" => 'background:#04013c;',
                        "class" => 'criterio_busqueda white ordenar_valoraciones_button  padding_5 white text-center',
                        "id" => $z
                    ];
            }
            $l[] = d($criterios[$z], $extra_criterios);
        }

        return append($l);
    }

    function resumem_valoracion($numero_valoraciones, $persona = 0)
    {

        if (es_data($numero_valoraciones)) {

            $valoraciones = $numero_valoraciones[0];
            $num_valoraciones = $valoraciones["num_valoraciones"];
            $comentarios = $num_valoraciones . ($num_valoraciones > 1) ? "COMENTARIOS" : "COMENTARIO";
            $personas_recomendarian = $valoraciones["personas_recomendarian"];
            $promedio_general = number_format($valoraciones["promedio"], 1, '.', '');
            $parte_promedio = d(crea_estrellas($promedio_general) . span($promedio_general, ["class" => 'promedio_num f15 strong black']), ["class" => 'contenedor_promedios']);
            $parte_promedio .= tb(tr(td($comentarios, 'info_comentarios')));
            $parte_promedio .= d(porcentaje($num_valoraciones, $personas_recomendarian, 1) . "%", 'porcentaje_recomiendan');
            $parte_promedio .= d(
                ($persona == 1) ? "de los consumidores recomiendan" : "de los consumidores recomiendan este producto"
            );
            return $parte_promedio;

        }

    }

    function valoraciones_comentarios($comentarios, $respuesta_valorada)
    {

        $lista_comentario = "";
        $a = 0;
        foreach ($comentarios as $row) {

            $id_valoracion = $row["id_valoracion"];
            $num_util = $row["num_util"];
            $num_no_util = $row["num_no_util"];
            $valoracion = $row["valoracion"];
            $titulo = $row["titulo"];
            $comentario = $row["comentario"];
            $recomendaria = $row["recomendaria"];
            $nombre = $row["nombre"];
            $fecha_registro = $row["fecha_registro"];

            $config_comentarios =
                [

                    "class" => 'contenedor_valoracion_info ',
                    "numero_utilidad" => $num_util,
                    "fecha_info_registro" => $fecha_registro

                ];

            $extra_config_comentarios = add_attributes($config_comentarios);
            $lista_comentario .= "<div class='contenedor_global_recomendaciones'>
                            <div " . $extra_config_comentarios . ">" . d(crea_estrellas($valoracion, 1));

            $lista_comentario .= d($titulo, 'titulo_valoracion');
            $lista_comentario .= d($comentario, 'comentario_valoracion');

            if ($recomendaria == 1) {
                $lista_comentario .= d(text_icon("fa fa-check-circle", "Recomiendo este producto"), ["class" => 'recomendaria_valoracion strong', "style" => "color:#02071a"]);
            }

            $lista_comentario .= d($nombre . br() . $fecha_registro, 'nombre_comentario_valoracion');
            $texto_valoracion = "";
            if ($respuesta_valorada === $id_valoracion) {
                $texto_valoracion = d("Recibimos tu valoracion! ", 'text_recibimos_valoracion');
            }


            $btn_es_util = a_enid("SI" . span("[" . $num_util . "]", 'num_respuesta'),
                [
                    "class" => 'respuesta_util respuesta_ok valorar_respuesta mr-4 blue_enid',
                    "id" => $id_valoracion,
                    "onclick" => "agrega_valoracion_respuesta('" . $id_valoracion . "' , 1)"
                ]);

            $btn_no_util = a_enid("NO" . span("[" . $num_no_util . "]", 'num_respuesta'),
                [
                    "class" => 'respuesta_no valorar_respuesta mr-4 blue_enid',
                    "id" => $id_valoracion,
                    "onclick" => "agrega_valoracion_respuesta('" . $id_valoracion . "' , 0)"
                ]);


            $lista_comentario .= "<hr>
                            <div class='contenedor_utilidad'>
                              <table>
                                <tr>
                                  " . td(h("¿Te ha resultado útil?", 5, "letter-spacing-5 strong")) . "
                                  " . td($btn_es_util . $btn_no_util) . "
                                </tr>
                                <tr>
                                    " . td($texto_valoracion) . "
                                </tr>
                              </table>
                            </div>
                          ";
            $lista_comentario .= "<hr>";
            $a++;
        }
        $lista_comentario .= "</div>
                        </div>";
        return $lista_comentario;
    }

    function redacta_valoracion($comentarios, $numero_valoraciones, $servicio)
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