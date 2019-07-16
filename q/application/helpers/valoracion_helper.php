<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_articulo($data)
    {


        $servicio = $data["servicio"];
        $numero_valoraciones = $data["numero_valoraciones"];
        $comentarios = $data["comentarios"];

        $r[] = titulo_valoraciones($data["id_usuario"]);
        $r[] = btw(
            anchor_enid(
                text_icon("fa fa-chevron-right ir", "ESCRIBE UNA RESEÑA")
                ,
                [
                    "class" => "escribir_valoracion white escribir",
                    "href" => "../valoracion?servicio=" . $servicio,

                ]
            )
            ,
            crea_resumen_valoracion($numero_valoraciones)
            ,
            "col-lg-4 h-400 d-flex flex-column justify-content-center text-center"
        );

        $z[] = d("", "table_orden_1");
        $z[] = btw(
            d(h("ORDENAR POR", 4), 4),
            d(criterios_busqueda(), 8),
            " mb-5"
        );
        $z[] = btw(
            crea_resumen_valoracion_comentarios($comentarios, $data["respuesta_valorada"]),
            d(get_redactar_valoracion($comentarios, $numero_valoraciones, $servicio), "btn_escribir_valoracion"),
            "contenedor_comentarios"
        );

        $r[] = d(append($z), 8);
        return append($r);

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
            anchor_enid("SI", ["class" => 'recomendaria', "id" => 1]),
            anchor_enid("NO", ["class" => 'recomendaria', "id" => 0]),
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
        placeholder="Por ejemplo: jmedrano@enidservice.com" 
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


        $social = get_social(0, "Mira lo que compré en Enid service!");
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
        $r[] = btn("ENVIAR PREGUNTA" . icon("fa fa-chevron-right ir"));
        $r[] = place("place_registro_valoracion");


        $text = strtoupper(
            pr($vendedor, "nombre")
            . " " .
            pr($vendedor, "apellido_paterno")
        );

        $z[] = h("ESCRIBE UNA PREGUNTA " . $text, 3);

        $url = get_url_servicio($id_servicio);
        $nombre = anchor_enid(pr($servicio, "nombre_servicio"), [
            "class" => "underline black strong",
            "href" => $url
        ]);
        $z[] = d("SOBRE SU " . $nombre, "top_30  bottom_30");
        $z[] = form_open("", ["class" => "form_valoracion top_30"]);
        $z[] = append($r);
        $z[] = form_close();

        return append($z);

    }

    function titulo_valoraciones($id_usuario)
    {

        $r[] = h("VALORACIONES Y RESEÑAS", 3);
        $r[] = d(
            anchor_enid(
                text_icon("fa fa-chevron-right ir", "MÁS SOBRE EL VENDEDOR", 0, 0)
                ,
                [
                    "class" => "a_enid_black hover_padding",
                    "href" => "../recomendacion/?q=" . $id_usuario,
                    "style" => "color: white!important"
                ]
            ), "mt-5 mb-5"
        );


        return append($r);

    }

    function get_notificacion_valoracion($usuario, $id_servicio)
    {

        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $nombre = $usuario["nombre"];
            $email = $usuario["email"];

            $asunto = "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
            $text = "Que tal {$nombre}  un nuevo cliente dejó una reseña sobre uno de tus artículos 
            puedes consultarla aquí " . anchor_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/producto/?producto={$id_servicio}&valoracion=1"]);
            $cuerpo = img_enid([], 1, 1) . h($text, 5);
            $sender = get_request_email($email, $asunto, $cuerpo);
            return $sender;

        }

    }

    function valida_readonly($text)
    {

        return mayorque(trim(strlen($text)), 1, "readonly");

    }

    function get_texto_por_modalidad($modalidad)
    {

        return ($modalidad == 1) ? " TU HISTORIAL DE COMPRAS " : "TU HISTORIAL DE VENTAS";

    }

    function ver_totalidad_por_modalidad($modalidad, $total)
    {

        $icon = icon("fa fa-shopping-bag");
        return ($modalidad == 1) ? $icon . "TUS VENTAS HASTA EL MOMENTO " . $total :
            $icon . "TUS COMPRAS HASTA EL MOMENTO " . $total;

    }

    function crea_estrellas($calificacion, $sm = 0)
    {

        $estrellas_valoraciones = "";
        $restantes = "";
        $num_restantes = 1;

        for ($x = 1; $x <= $calificacion; $x++) {

            $estrellas_valoraciones .= label("★", ["class" => 'estrella f2']);
            $num_restantes++;
        }

        for ($num_restantes; $num_restantes <= 5; $num_restantes++) {
            $extra = "font-size: 2em;-webkit-text-fill-color: white;-webkit-text-stroke: 0.5px rgb(0, 74, 252);";

            $restantes .= label("★",
                [
                    "class" => 'estrella',
                    "style" => $extra
                ]);

        }
        return $estrellas_valoraciones . $restantes;

    }

    function criterios_busqueda()
    {
        $criterios = ["RELEVANTE", "RECIENTE"];
        $l = [];
        for ($z = 0; $z < count($criterios); $z++) {
            $extra_criterios = [
                "class" => 'criterio_busqueda ordenar_valoraciones_button col-lg-6 padding_5 border ',
                "id" => $z
            ];
            if ($z == 0) {

                $extra_criterios =
                    [
                        "style" => 'background:#04013c;color:white',
                        "class" => 'criterio_busqueda ordenar_valoraciones_button col-lg-6 padding_5 white',
                        "id" => $z
                    ];
            }
            $l[] = d($criterios[$z], $extra_criterios);
        }

        return d(append($l), "top_20 bottom_20");
    }

    function crea_resumen_valoracion($numero_valoraciones, $persona = 0)
    {

        if (es_data($numero_valoraciones)){

            $valoraciones = $numero_valoraciones[0];
            $num_valoraciones = $valoraciones["num_valoraciones"];
            $text_comentarios = ($num_valoraciones > 1) ? "COMENTARIOS" : "COMENTARIO";
            $comentarios = $num_valoraciones . $text_comentarios;
            $promedio = $valoraciones["promedio"];
            $personas_recomendarian = $valoraciones["personas_recomendarian"];

            $promedio_general = number_format($promedio, 1, '.', '');
            $parte_promedio = d(crea_estrellas($promedio_general) . span($promedio_general, ["class" => 'promedio_num']), ["class" => 'contenedor_promedios']);

            $config = ["class" => 'info_comentarios'];
            $parte_promedio .= "<table>
                            <tr>
                              " . td($comentarios, $config) . "
                            </tr>
                          </table>";

            $parte_promedio .= d(porcentaje($num_valoraciones, $personas_recomendarian, 1) . "%", ["class" => 'porcentaje_recomiendan']);
            $parte_promedio .= d(
                ($persona == 1) ? "de los consumidores recomiendan" : "de los consumidores recomiendan este producto"
            );
            return $parte_promedio;

        }

    }

    function crea_resumen_valoracion_comentarios($comentarios, $respuesta_valorada)
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
                $lista_comentario .= d(icon("fa fa-check-circle") . "Recomiendo este producto", ["class" => 'recomendaria_valoracion strong', "style" => "color:#02071a"]);
            }

            $lista_comentario .= d($nombre . br() . $fecha_registro, 'nombre_comentario_valoracion');
            $texto_valoracion = "";
            if ($respuesta_valorada == $id_valoracion) {
                $texto_valoracion = d("Recibimos tu valoracion! ", 'text_recibimos_valoracion');
            }


            $btn_es_util = anchor_enid("SI" . span("[" . $num_util . "]", 'num_respuesta'),
                [
                    "class" => 'respuesta_util respuesta_ok valorar_respuesta mr-4 blue_enid',
                    "id" => $id_valoracion,
                    "onclick" => "agrega_valoracion_respuesta('" . $id_valoracion . "' , 1)"
                ]);

            $btn_no_util = anchor_enid("NO" . span("[" . $num_no_util . "]", 'num_respuesta'),
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

    function get_redactar_valoracion($comentarios, $numero_valoraciones, $servicio)
    {
        $response = "";
        if (count($comentarios) > 5) {

            if (pr($numero_valoraciones, "num_valoraciones") > 6) {

                $response = anchor_enid(text_icon("fa fa-chevron-right ir", "CARGAR MÁS"), "cargar_mas_valoraciones");

            } else {

                $response = anchor_enid(text_icon("fa fa-chevron-right ir", "ESCRIBE UNA RESEÑAESCRIBE UNA RESEÑA "),
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
            $num_estrella = "estrella_" . $x;

            $response[] = input(
                [
                    "id" => $id_input,
                    "value" => $x,
                    "class" => 'input-start',
                    "type" => "radio"
                ]);

            $response[] = label("★",
                [
                    "class" => 'estrella ' . $num_estrella,
                    "for" => "$id_input",
                    "id" => $x,
                    "title" => $x . " - " . $calificacion[$x]
                ]
            );

        }

        return append($response);

    }
}