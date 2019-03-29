<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_form_valoracion($servicio, $extra, $id_servicio)
    {

        $propietario = ($extra["id_usuario"] == $servicio[0]["id_usuario"]) ? 1 : 0;
        $nombre = "";
        $email = "";
        if ($extra["in_session"] == 1) {
            $nombre = $extra["nombre"];
            $email = $extra["email"];
        }

        $r[] = heading_enid("ESCRIBE UNA RESEÑA", 3, ["class" => "3em"]);
        $r[] = div("Sobre  " . $servicio[0]["nombre_servicio"], ["style" => "font-size: 1.4em"]);
        $r[] = form_open("", ["class" => "form_valoracion"]);
        $r[] = place("nuevo");
        $r[] = get_btw(
            div("Valoración*", ["class" => "text-valoracion"]),
            get_posibles_calificaciones(["", "Insuficiente", "Aceptable", "Promedio", "Bueno", "Excelente"]),
            "displa_flex_enid"
        );
        $r[] = place("nuevo");
        $r[] = div(strong("¿Recomendarías este producto?*", ["class" => "text-valoracion"]));
        $r[] = get_btw(
            anchor_enid("SI", ["class" => 'recomendaria', "id" => 1]),
            anchor_enid("NO", ["class" => 'recomendaria', "id" => 0]),
            "display_flex_enid"

        );
        $r[] = place("place_recomendaria");
        $r[] = place("nuevo");
        $r[] = get_btw(
            div("Tu opinión en una frase*", ["class" => "text-valoracion strong"]),
            div(input([
                "type" => "text",
                "name" => "titulo",
                "class" => "input-sm input",
                "placeholder" => "Por ejemplo: Me encantó!",
                "required" => "Agrega una breve descripción"
            ])),
            "display_flex_enid"
        );
        $r[] = input_hidden([
            "name" => "propietario",
            "class" => "propietario",
            "value" => $propietario
        ]);
        $r[] = place("nuevo");
        $r[] = get_btw(
            div(strong("Tu reseña*", ["class" => "text-valoracion"])),
            div(input([
                "type" => "text",
                "name" => "comentario",
                "placeholder" => "¿Por qué te gusta el producto o por qué no?",
                "required" => "Comenta tu experiencia"
            ]))
            ,
            "display_flex_enid"

        );
        $r[] = place("nuevo");

        $input =
            '<input type="text" name="nombre" 
	        placeholder="Por ejemplo: Jonathan" 
	        value="' . $nombre . '"  ' . valida_readonly($nombre) . ' 
            required>';

        $r[] = get_btw(
            div("Nombre*", ["class" => "text-valoracion strong"]),
            $input,

            "display_flex_enid"

        );
        $r[] = input_hidden(["name" => "id_servicio", "value" => $id_servicio]);
        $r[] = place("nuevo");

        $in = '<input type="email" 
        name="email" 
        placeholder="Por ejemplo: jmedrano@enidservice.com" 
        required ' . valida_readonly($email) . ' value="' . $email . '">';

        $r[] = get_btw(
            div(strong("Tu correo electrónico*", ["class" => "text-valoracion"])),
            $in,
            "display_flex_enid"

        );
        $r[] = place("nuevo");
        $r[] = guardar("ENVIAR RESEÑA" . icon('fa fa-chevron-right ir'));
        $r[] = place("place_registro_valoracion");
        $r[] = form_close();

        $response = div(append_data($r), ["class" => "col-lg-6 col-lg-offset-3"]);
        return $response;

    }

    function get_form_pregunta_consumidor($id_servicio, $propietario, $vendedor, $servicio)
    {


        $r[] = textarea([
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
        $z[] = heading_enid("ESCRIBE UNA PREGUNTA " . $text, 2);
        $z[] = div("SOBRE SU" . $servicio[0]["nombre_servicio"]);
        $z[] = br(2);
        $z[] = form_open("", ["class" => "form_valoracion "]);
        $z[] = append_data($r);
        $z[] = form_close();

        return append_data($z);

    }

    function get_title_valoraciones($id_usuario)
    {

        $a = anchor_enid("MÁS SOBRE EL VENDEDOR" . icon("fa fa-chevron-right ir"),
            [
                "class" => "a_enid_black",
                "href" => "../recomendacion/?q=" . $id_usuario,
                "style" => "color: white!important"
            ]);

        $h = append_data([heading_enid("VALORACIONES Y RESEÑAS", 2, ["class" => "strong"]), $a]);
        return addNRow($h, ["id" => "opiniones"]);

    }

    function get_notificacion_valoracion($usuario, $id_servicio)
    {

        $nombre = $usuario[0]["nombre"];
        $email = $usuario[0]["email"];
        $asunto = "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
        $text = "Que tal {$nombre}  un nuevo cliente dejó una reseña sobre uno de tus artículos 
          puedes consultarla aquí " . anchor_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/producto/?producto={$id_servicio}&valoracion=1"]);
        $cuerpo = img_enid([], 1, 1) . heading_enid($text, 5);
        $sender = get_request_email($email, $asunto, $cuerpo);
        return $sender;

    }

    function valida_readonly($text)
    {

        $response = (trim(strlen($text)) > 1) ? "readonly" : "";
        return $response;
    }

    function get_texto_por_modalidad($modalidad)
    {

        $response = ($modalidad == 1) ? " TU HISTORIAL DE COMPRAS " : "TU HISTORIAL DE VENTAS";
        return $response;
    }

    function ver_totalidad_por_modalidad($modalidad, $total)
    {

        $icon = icon("fa fa-shopping-bag");
        $resposne = ($modalidad == 1) ? $icon . "TUS VENTAS HASTA EL MOMENTO " . $total : $icon . "TUS COMPRAS HASTA EL MOMENTO " . $total;
        return $resposne;
    }

    function create_seccion_saldo_pendiente($saldo_pendiente)
    {
        return $saldo_pendiente;
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
        $estrellas = $estrellas_valoraciones . $restantes;
        return $estrellas;
    }

    function get_criterios_busqueda()
    {
        $criterios = ["RELEVANTE", "RECIENTE"];
        $l = "";
        for ($z = 0; $z < count($criterios); $z++) {
            $extra_criterios = [
                "class" => 'criterio_busqueda ordenar_valoraciones_button',
                "id" => $z
            ];
            if ($z == 0) {
                $extra_criterios = [
                    "style" => 'padding:8px;background:#002753;color:white',
                    "class" => 'criterio_busqueda ordenar_valoraciones_button',
                    "id" => $z
                ];
            }
            $l .= get_td($criterios[$z], $extra_criterios);
        }
        return $l;
    }

    function crea_resumen_valoracion($numero_valoraciones, $persona = 0)
    {

        $mensaje_final = "de los consumidores recomiendan este producto";
        if ($persona == 1) {
            $mensaje_final = "de los consumidores recomiendan";
        }
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
            //$fecha_registro = $row["fecha_registro"];
            $fecha_registro = $row["fecha_registro"];

            $config_comentarios = [
                "class" => 'contenedor_valoracion_info',
                "numero_utilidad" => $num_util,
                "fecha_info_registro" => $fecha_registro
            ];
            $extra_config_comentarios = add_attributes($config_comentarios);
            $lista_comentario .= "<div class='contenedor_global_recomendaciones'>
                            <div " . $extra_config_comentarios . ">" . div(crea_estrellas($valoracion, 1));

            $lista_comentario .= div($titulo, ["class" => 'titulo_valoracion']);
            $lista_comentario .= div($comentario, ["class" => 'comentario_valoracion']);

            if ($recomendaria == 1) {
                $lista_comentario .= div(icon("fa fa-check-circle") . "Recomiendo este producto",
                    ["class" => 'recomendaria_valoracion']);
            }
            $lista_comentario .= div($nombre . "- " . $fecha_registro, ["class" => 'nombre_comentario_valoracion']);
            //$function_valoracion_funciona = 'onclick="agrega_valoracion_respuesta(' . $id_valoracion . ' , 1)"';
            //$function_valoracion_NO_funciona = 'onclick="agrega_valoracion_respuesta(' . $id_valoracion . ' , 0)"';
            $texto_valoracion = "";
            if ($respuesta_valorada == $id_valoracion) {
                $texto_valoracion = div("Recibimos tu valoracion! ", ["class" => 'text_recibimos_valoracion']);
            }


            $btn_es_util = anchor_enid("SI" . span("[" . $num_util . "]", ["class" => 'num_respuesta']),
                [
                    "class" => 'respuesta_util respuesta_ok valorar_respuesta',
                    "id" => $id_valoracion,
                    "onclick" => "agrega_valoracion_respuesta('" . $id_valoracion . "' , 1)"
                ]);

            $btn_no_util = anchor_enid("NO" . span("[" . $num_no_util . "]", ["class" => 'num_respuesta']),
                [
                    "class" => 'respuesta_no valorar_respuesta',
                    "id" => $id_valoracion,
                    "onclick" => "agrega_valoracion_respuesta('" . $id_valoracion . "' , 0)"
                ]);


            $lista_comentario .= "<hr>
                            <div class='contenedor_utilidad'>
                              <table>
                                <tr>
                                  " . get_td(span("¿Te ha resultado útil?", ['class' => 'strong'])) . "
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

                $response = anchor_enid("CARGAR MÁS" . icon("fa fa-chevron-right ir"),
                    [
                        "class" => "cargar_mas_valoraciones",
                        "style" => "color:white!important"
                    ]);
            } else {
                $response = anchor_enid("ESCRIBE UNA RESEÑA " . icon("fa fa-chevron-right ir"),
                    [
                        "class" => "escribir_valoracion",
                        "href" => "../valoracion?servicio=" . $servicio,
                        "style" => "color:white!important",
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


            $response[] = input([
                "id" => $id_input,
                "value" => $x,
                "class" => 'input-start',
                "type" => "radio"
            ]);

            $response[] = label("★",
                ["class" => 'estrella ' . $num_estrella,
                    "for" => "$id_input",
                    "id" => $x,
                    "title" => $x . " - " . $calificacion[$x]
                ]
            );

        }
        return append_data($response);
        
    }
}