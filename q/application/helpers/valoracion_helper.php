<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_articulo($data)
    {


        $num = $data["numero_valoraciones"];
        $comentarios = $data["comentarios"];


        $promedio_valoraciones = valorados($num);
        $z[] = place("table_orden_1");
        $z[] = criterios($comentarios);
        $z[] = add_text(
            comentarios($comentarios, $data["respuesta_valorada"]),
            d(redactar($comentarios, $data), "mt-1 d-flex justify-content-between")
        );

        $b = d($z);
        if (es_data($comentarios)) {
            $response[] = _titulo("VALORACIONES Y RESEÑAS", 2, "strong col-lh-12 p-0 mb-5");
        }
        $response[] = dd($promedio_valoraciones, $b);

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
            puedes consultarla aquí " . a_enid("buzón aquí", ["href" => "https://enidservices.com/web/producto/?producto={$id_servicio}&valoracion=1"]);
            $cuerpo = img_enid([], 1, 1) . h($text, 5);
            return get_request_email($email, $asunto, $cuerpo);

        }
    }


    function criterios($comentarios)
    {
        $response = [];
        if (es_data($comentarios)) {

            $criterios = ["RELEVANTE", "RECIENTE"];
            $r = [];
            for ($z = 0; $z < count($criterios); $z++) {
                $extra_criterios = [
                    "class" => 'col-lg-6  criterio_busqueda ordenar_valoraciones_button  padding_5 border  text-center',
                    "id" => $z
                ];
                if ($z == 0) {

                    $extra_criterios =
                        [
                            "class" => 'col-lg-6  criterio_busqueda white ordenar_valoraciones_button  padding_5 white text-center bg_black',
                            "id" => $z
                        ];
                }
                $r[] = d($criterios[$z], $extra_criterios);
            }

            $response[] = _titulo("ordernar por",4, 'mb-2');
            $response[] = d(append($r), "d-flex mb-5");

        }
        return append($response);
    }

    function valorados($numero_valoraciones, $persona = 0)
    {

        if (es_data($numero_valoraciones)) {

            $valoracion = $numero_valoraciones[0];
            $num = $valoracion["num_valoraciones"];
            $promedio = number_format($valoracion["promedio"], 1, '.', '');
            $parte_promedio = flex(

                _titulo($promedio,0,'mb-4 mt-4')
                ,
                crea_estrellas($promedio)
                ,
                'contenedor_promedios border border-secondary text-center p-3 flex-column mt-5 mb-5 azul_deporte'
            );
            if ($persona > 0) {

                $parte_promedio .= d(
                    add_text(
                        porcentaje($num, $valoracion["personas_recomendarian"])
                        ,
                        "%"
                    )
                );

                $parte_promedio .= igual($persona, 1, "de los consumidores recomiendan", "de los consumidores recomiendan este producto");
            }

            return $parte_promedio;

        }

    }

    function comentarios($comentarios, $es_valorado)
    {

        $response = [];
        foreach ($comentarios as $row) {
            $r = [];
            $id = $row["id_valoracion"];
            $num_util = $row["num_util"];
            $fecha_registro = $row["fecha_registro"];
            $r[] = flex(crea_estrellas($row["valoracion"], 1), format_fecha($fecha_registro), 'justify-content-between');
            $r[] = h($row["titulo"], 4, "strong text-uppercase");
            $r[] = p($row["comentario"], "mb-3");

            if ($row["recomendaria"] == 1) {
                $r[] = d(text_icon("fa fa-check-circle", "Recomiendo este producto"), 'recomendaria_valoracion strong color_recomendaria');
            }

            $r[] = d_p($row["nombre"], 'strong black mt-1');
            $texto_valoracion = ($es_valorado === $id) ? "Gracias! Se ha enviado correctamente tus comentarios de esta reseña " : "";
            $es_util = a_enid("SI" . span("[" . $num_util . "]", 'num_respuesta'),
                [
                    "class" => 'respuesta_util respuesta_ok valorar_respuesta mr-4 black',
                    "id" => $id,
                    "onclick" => "agrega_valoracion_respuesta('" . $id . "' , 1)"
                ]
            );

            $btn_no_util = a_enid("NO" . span("[" . $row["num_no_util"] . "]", 'num_respuesta'),
                [
                    "class" => 'respuesta_no valorar_respuesta mr-4 black',
                    "id" => $id,
                    "onclick" => "agrega_valoracion_respuesta('" . $id . "' , 0)"
                ]
            );


            $a = add_text(
                d_p("¿Te ha resultado útil?", "mr-5"),
                d($es_util),
                d($btn_no_util)
            );


            $r[] = d($a, "letter-spacing-1 mt-5 d-flex");
            $r[] = d_p($texto_valoracion, "mt-5");
            $str = d(append($r),
                [
                    "class" => 'contenedor_valoracion_info',
                    "numero_utilidad" => $num_util,
                    "fecha_info_registro" => $fecha_registro
                ]);
            $response[] = section($str, "contenedor_global_recomendaciones border-bottom mb-5");
        }
        return article(append($response));
    }

    function redactar($comentarios, $data)
    {

        $id_servicio = $data["servicio"];
        $id_usuario = $data["id_usuario"];

        $response = [];
        $response[] = format_link(
            text_icon("fa fa-chevron-right ir", "ESCRIBE UNA RESEÑA")
            ,
            [
                "href" => "../valoracion?servicio=" . $id_servicio,

            ]
        );

        $response[] = format_link(
            "MÁS SOBRE EL VENDEDOR"
            ,
            [
                "href" => "../recomendacion/?q=" . $id_usuario,
            ], 0


        );
        if (es_data($comentarios) && count($comentarios) > 5) {

            $response[] = format_link(
                text_icon("fa fa-chevron-right ir", "CARGAR MÁS")
                ,
                ["class" => "cargar_mas_valoraciones"]
            );
        }

        return append($response);
    }


}
