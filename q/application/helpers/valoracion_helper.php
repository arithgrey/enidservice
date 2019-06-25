<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_form_valoracion($servicio, $extra, $id_servicio)
    {

        $propietario = ( $extra["id_usuario"] ==  $servicio[0]["id_usuario"]) ? 1 : 0;
        $nombre = "";
        $email = "";
        if ($extra["in_session"] == 1) {
            $nombre = $extra["nombre"];
            $email = $extra["email"];
        }

        $r[] = heading_enid("ESCRIBE UNA RESEÑA", 3, "underline");
        $r[] = div("Sobre  " . $servicio[0]["nombre_servicio"]);
        $r[] = form_open("", ["class" => "form_valoracion"]);
        $r[] = place("nuevo");
        $r[] = get_btw(
            div("Valoración*", "text-valoracion"),
            get_posibles_calificaciones([
                "",
                "Insuficiente",
                "Aceptable",
                "Promedio",
                "Bueno",
                "Excelente"
            ]),
            "displa_flex_enid"
        );
        $r[] = place("nuevo");
        $r[] = div("¿Recomendarías este producto?*", "text-valoracion strong");
        $r[] = get_btw(
            anchor_enid("SI", ["class" => 'recomendaria', "id" => 1]),
            anchor_enid("NO", ["class" => 'recomendaria', "id" => 0]),
            "display_flex_enid top_30 bottom_20"

        );
        $r[] = place("place_recomendaria");
        $r[] = place("nuevo");
        $r[] = get_btw(
            div("Tu opinión en una frase*", "text-valoracion strong"),
            div(
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
        $r[] = get_btw(
            div("Tu reseña (comentarios)*", "text-valoracion strong"),
            div(
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
            div('<input type="text" name="nombre" 
	        placeholder="Por ejemplo: Jonathan" 
	        value="' . $nombre . '"  ' . valida_readonly($nombre) . ' 
	        class="input form-control"
            required>');

        $r[] = get_btw(
            div("Nombre*", "text-valoracion strong"),
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

        $in = div('<input type="email" 
        name="email" 
        	        class="input form-control"
        placeholder="Por ejemplo: jmedrano@enidservice.com" 
        required ' . valida_readonly($email) . ' value="' . $email . '">');

        $r[] = get_btw(
            div(
                "Tu correo electrónico*", "text-valoracion strong"
            ),
            $in,
            "display_flex_enid"

        );
        $r[] = place("nuevo");
        $r[] = br(3);
        $r[] = guardar(text_icon('fa fa-chevron-right ir', "ENVIAR RESEÑA "), ["class" => "top_40 bottom_40"]);
        $r[] = place("place_registro_valoracion");
        $r[] = form_close();
        $r[] = br(3);


        $social     = get_social(0, "Mira lo que compré en Enid service!");
        $encuesta[] =  div(div(append_data($r), 10, 1),1);
        $encuesta[] =  div(div($social , "col-lg-10 col-lg-offtse-1 bottom_50"),1);
        $response[] = div( append_data($encuesta), "col-lg-6 col-lg-offset-3 shadow padding_10 bottom_50");
        return append_data($response);

    }

    function get_form_pregunta_consumidor($id_servicio, $propietario, $vendedor, $servicio)
    {

        if (!es_data($servicio)){ return ""; }

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
        $r[] = guardar("ENVIAR PREGUNTA" . icon("fa fa-chevron-right ir"));
        $r[] = place("place_registro_valoracion");


        $text = strtoupper($vendedor[0]["nombre"] . " " . $vendedor[0]["apellido_paterno"]);
        $z[] = heading_enid("ESCRIBE UNA PREGUNTA " . $text, 3);

        $url = get_url_servicio($id_servicio);
        $nombre = anchor_enid($servicio[0]["nombre_servicio"], ["class" => "underline black strong", "href" => $url]);
        $z[] = div("SOBRE SU " . $nombre, "top_30  bottom_30");
        $z[] = form_open("", ["class" => "form_valoracion top_30"]);
        $z[] = append_data($r);
        $z[] = form_close();

        return append_data($z);

    }

    function get_title_valoraciones($id_usuario)
    {

        $r[] = heading_enid("VALORACIONES Y RESEÑAS", 3);
        $r[] = div(
            anchor_enid(text_icon("fa fa-chevron-right ir", "MÁS SOBRE EL VENDEDOR", 0, 0)
                ,
                [
                    "class" => "a_enid_black hover_padding",
                    "href" => "../recomendacion/?q=" . $id_usuario,
                    "style" => "color: white!important"
                ]), "mt-5 mb-5"
        );


        return  append_data($r);

    }

    function get_notificacion_valoracion($usuario, $id_servicio)
    {

        if (es_data($usuario)){

            $usuario =  $usuario[0];
            $nombre = $usuario["nombre"];
            $email = $usuario["email"];

            $asunto = "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
            $text = "Que tal {$nombre}  un nuevo cliente dejó una reseña sobre uno de tus artículos 
            puedes consultarla aquí " . anchor_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/producto/?producto={$id_servicio}&valoracion=1"]);
            $cuerpo = img_enid([], 1, 1) . heading_enid($text, 5);
            $sender = get_request_email($email, $asunto, $cuerpo);
            return $sender;

        }

    }

    function valida_readonly($text)
    {

        return mayorque(trim(strlen($text)) ,  1 , "readonly" );

    }

    function get_texto_por_modalidad($modalidad)
    {

        return ($modalidad == 1) ? " TU HISTORIAL DE COMPRAS " : "TU HISTORIAL DE VENTAS";

    }
    function ver_totalidad_por_modalidad($modalidad, $total)
    {

        $icon = icon("fa fa-shopping-bag");
        return   ($modalidad == 1) ? $icon . "TUS VENTAS HASTA EL MOMENTO " . $total : $icon . "TUS COMPRAS HASTA EL MOMENTO " . $total;

    }

    function crea_estrellas($calificacion, $sm = 0)
    {

        $estrellas_valoraciones = "";
        $restantes = "";
        $num_restantes = 1;

        for ($x = 1; $x <= $calificacion; $x++) {
            $extra = "font-size: 2em;";
            $estrellas_valoraciones .= label("★", ["class" => 'estrella', "style" => $extra]);
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

    function get_criterios_busqueda()
    {
        $criterios = ["RELEVANTE", "RECIENTE"];
        $l = [];
        for ($z = 0; $z < count($criterios); $z++) {
            $extra_criterios = [
                "class" => 'criterio_busqueda ordenar_valoraciones_button col-lg-6 padding_5 border ',
                "id" => $z
            ];
            if ($z == 0) {

                $extra_criterios = [
                    "style" => 'background:#04013c;color:white',
                    "class" => 'criterio_busqueda ordenar_valoraciones_button col-lg-6 padding_5 white',
                    "id" => $z
                ];
            }
            $l[] = div($criterios[$z], $extra_criterios);
        }

        return div(append_data($l),"top_20 bottom_20" );
    }

    function crea_resumen_valoracion($numero_valoraciones, $persona = 0)
    {


        $mensaje_final =  ($persona == 1) ? "de los consumidores recomiendan": "de los consumidores recomiendan este producto";
        $valoraciones = $numero_valoraciones[0];
        $num_valoraciones = $valoraciones["num_valoraciones"];
        $text_comentarios = ($num_valoraciones > 1) ? "COMENTARIOS" : "COMENTARIO";
        $comentarios = $num_valoraciones . $text_comentarios;
        $promedio = $valoraciones["promedio"];
        $personas_recomendarian = $valoraciones["personas_recomendarian"];

        $promedio_general = number_format($promedio, 1, '.', '');
        $parte_promedio = div(crea_estrellas($promedio_general) . span($promedio_general, ["class" => 'promedio_num']), ["class" => 'contenedor_promedios']);

        $config = ["class" => 'info_comentarios'];
        $parte_promedio .= "<table>
                            <tr>
                              " . get_td($comentarios, $config) . "
                            </tr>
                          </table>";

        $parte_promedio .= div(porcentaje($num_valoraciones, $personas_recomendarian, 1) . "%", ["class" => 'porcentaje_recomiendan']);
        $parte_promedio .= div($mensaje_final);
        return $parte_promedio;
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

            $config_comentarios = [

                "class" => 'contenedor_valoracion_info ',
                "numero_utilidad" => $num_util,
                "fecha_info_registro" => $fecha_registro

            ];
            $extra_config_comentarios = add_attributes($config_comentarios);
            $lista_comentario .= "<div class='contenedor_global_recomendaciones'>
                            <div " . $extra_config_comentarios . ">" . div(crea_estrellas($valoracion, 1));

            $lista_comentario .= div($titulo, 'titulo_valoracion');
            $lista_comentario .= div($comentario, 'comentario_valoracion');

            if ($recomendaria == 1) {
                $lista_comentario .= div(icon("fa fa-check-circle") . "Recomiendo este producto", ["class" => 'recomendaria_valoracion strong', "style" => "color:#02071a"]);
            }

            $lista_comentario .= div($nombre . br() . $fecha_registro, 'nombre_comentario_valoracion');
            $texto_valoracion = "";
            if ($respuesta_valorada == $id_valoracion) {
                $texto_valoracion = div("Recibimos tu valoracion! ", 'text_recibimos_valoracion');
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
                                  " . get_td(heading_enid("¿Te ha resultado útil?", 5, "letter-spacing-5 strong")) . "
                                  " . get_td($btn_es_util . $btn_no_util) . "
                                </tr>
                                <tr>
                                    " . get_td($texto_valoracion) . "
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

            if ($numero_valoraciones[0]["num_valoraciones"] > 6) {

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

    function get_posibles_calificaciones($calificacion)
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

        return append_data($response);

    }
}