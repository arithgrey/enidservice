<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_busqueda($data)
    {

        $response[] = d(_titulo('Busqueda', 2), _mbt5);
        $response[] = input_frm(
            '',
            '¿A quién buscamos? Nombre, email, teléfono',
            [
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

            $id_usuario = pr($usuario_busqueda, 'id_usuario');        
            $imagen_perfil = formato_imagen_perfil($data, $id_usuario);
            $usuario_perfil = usuario_perfil($data, $imagen_perfil);

            $contenedor[] = d($usuario_perfil, 'row p-5 contenedor_perfil');
            $contenedor[] = d(formulario_calificacion($data), 'row p-5 mt-5 contenedor_encuesta_estrellas d-none');
            $contenedor[] = d(formulario_calificacion_tipificacion($data), 'row  p-5 mt-5 d-none contenedor_encuesta_tipificcion');
        } elseif ($data['encuesta'] > 0) {
            $contenedor[] = d(notificacion_encuesta(), 'row p-5 mb-5');
        } else {

            $texto[] = h(_text_(strong('Ups!'), 'no encontramos a este ', strong('usuario')), 1, 'text-center  text-uppercase');
            $texto[] = format_link('Sigue comprando', ['class' => 'mt-5 col-md-8 col-md-offset-2', 'href' => path_enid('home')]);
            $contenedor[] = d($texto, 'row mt-5 p-5');
        }

        $contenedor[] = form_busqueda_ordenes_compra_hidden($data, $id_usuario);


        $_response[] = es_lista_negra_format($data);
        $_response[] = d(tareas_control($data, $contenedor), 3);

        $_response[] = d(actividad_central($data), 5);
        $_response[] = d(place("place_pedidos"), 4);
        $_response[] = modal_acciones_seguimiento($data);
        $_response[] = modal_descubrimiento_accion_seguimiento($data);
        $_response[] = modal_recordatorio_seguimiento($data);
        $_response[] = modal_recordatorio_seguimiento_evento($data);
        return d(d($_response, 12), 13);
    }
    function es_lista_negra_format($data)
    {

        $es_lista_negra = $data["es_lista_negra"];
        $response = "";
        if (es_data($es_lista_negra)) {
            $response = d(
                _text_(
                    icon("white fa fa-user-secret  fa-2x"),
                    "No le vendemos más a esta persona es lista negra"
                ),
                'col-xs-12 p-4 bg_red red_enid_background white text-center borde_black mb-5 f13 strong'
            );
        }
        return $response;
    }

    function actividad_central($data)
    {

        $response[] = d($data["formulario_busqueda_frecuente"], 'col-xs-12 mb-3');
        $response[] = d(hr('border_black'), 12);

        $response[] = d(format_link("+ Seguimiento", ["class" => "white boton_accion_seguimiento"], 2), 'col-xs-12 mt-3');
        $response[] = d(d("Historial de seguimiento", 'f13 black strong'), 'col-xs-12 mt-5');
        $response[] = d(d(place("tarjetas_acciones_seguimiento"), 12), 12);
        return append($response);
    }

    function formato_imagen_perfil($data, $id_usuario)
    {

        $es_propietario = ($data['in_session'] && $data['id_usuario'] === $id_usuario);
        $usuario_busqueda = $data['usuario_busqueda'];
        $usuario_calificacion = $data['usuario_calificacion'];
        $calificacion = $usuario_calificacion['promedio'];
        $encuestas = $usuario_calificacion['encuestas'];
        $nombre_usuario = pr($usuario_busqueda, 'nombre_usuario');
        $tel_contacto = pr($usuario_busqueda, 'tel_contacto');
        $seccion_calificacion = posibilidades($calificacion, $encuestas, $id_usuario, $data, $es_propietario);

        $url_img_usuario = pr($usuario_busqueda, 'url_img_usuario');
        $link = es_administrador($data) ? path_enid('busqueda_usuario', $id_usuario) : '';
        $imagen = a_enid(
            img(
                [
                    "src" => $url_img_usuario,
                    "onerror" => "this.src='../img_tema/user/user.png'",
                    "class" => "rounded-circle img_servicio_def"
                ]
            ),
            $link
        );  
        

        $contenido[] = hiddens(["class" =>  "input_tel_contacto", "value" => $tel_contacto]);
        $contenido[] = flex($imagen, $seccion_calificacion, _between, 'col-xs-4', 'col-xs-8');
        $contenido[] = seccion_facebook($data);
        $texto_puesto = roll($data);
        $texto_titulo = h($texto_puesto, 2, 'title display-5');
        $contenido[] = d(d(_text_($texto_titulo), 'caption'), 'circle');

        $contenido[] = p($nombre_usuario, 'update-note');
        $contenido[] = d(_text_(span("Cliente", 'black strong'), _text("#", $id_usuario)), 'display-6 black ');
        $contenido[] = d(format_phone($tel_contacto));
        if ($es_propietario) {

            $icono_link = icon(_text_(_editar_icon, 'black border '));
            $contenido[] = a_enid(
                $icono_link,
                [
                    'href' => path_enid('administracion_cuenta')
                ]
            );
        }

        return $contenido;
    }
    function usuario_perfil($data, $contenido)
    {


        $usuario_busqueda = $data['usuario_busqueda'];
        $nombre = format_nombre($usuario_busqueda);
        $descripcion[] = h($nombre, 1, ['class' => 'display-4 text-uppercase strong']);
        $response[] = d($descripcion, 'demo-title col-md-12');
        $response[] = get_base_html("header", append($contenido), ['class' => ' col-md-12', 'id' => 'header1']);
        $response[] = seguidores($data);


        $response[] = d(seccion_estadisticas($data), "col-md-12 mt-5");

        $response[] = d(seccion_estadisticas_compras($data), "col-md-12 mt-5");
        $response[] = d(seccion_deseos_compra($data), "col-md-12 mt-5");
        return $response;
    }
    function tareas_control($data, $contenedor_perfil_usuario_busqueda)
    {
        
        
        if (es_administrador($data)) {

            $response[] = d(format_link(
                text_icon(_text_(_money_icon, 'white'), "Clientes Frecuentes"),
                [

                    "href" => path_enid("leads"),
                    "class" => "text-uppercase white",
                ],
                1
            ), 'col-xs-12 mt-3');

            $response[] = d(format_link(
                text_icon(_text_(_money_icon, 'white'), "Dasboards"),
                [

                    "href" => path_enid("reporte_enid"),
                    "class" => "text-uppercase black",
                ]
            ), 'col-xs-12 mt-3');

            $response[] = d(format_link(
                text_icon(_text_(_money_icon, 'white'), "Pedidos"),
                [

                    "href" => path_enid("pedidos"),
                    "class" => "text-uppercase black",
                ]
            ), 'col-xs-12 mt-3');


            $response[] = d(format_link(
                text_icon(_text_(_eliminar_icon, 'white'), "Enviar a lista negra"),
                [
                    
                    "class" => "text-uppercase black envio_lista_negra",
                ],5
            ), 'col-xs-12 mt-3');

        }


        $response[] = d(d($contenedor_perfil_usuario_busqueda, 'bg-light'), ' col-xs-12 mt-5');

        return d($response, 13);
    }


    function form_busqueda_ordenes_compra_hidden($data, $id_usuario)
    {


        $response[] = form_open("", ["class" => "form_busqueda_pedidos_hidden mt-5", "method" => "post"]);
        $response[] = hiddens(['class' => 'usuarios', 'name' => 'usuarios', 'value' => 1]);
        $response[] = hiddens(['class' => 'ids', 'name' => 'ids', 'value' => $id_usuario]);
        $response[] = hiddens(['class' => 'es_busqueda_reparto', 'name' => 'es_busqueda_reparto', 'value' => 0]);
        $response[] = hiddens([
            'class' => 'es_administrador', 'name' => 'es_administrador',
            'value' => es_administrador($data)
        ]);

        $response[] = hiddens(
            [
                "name" => "perfil",
                "class" => "perfil_consulta",
                "value" => $data["id_perfil"],
            ]
        );


        $response[] = hiddens(
            [
                "name" => "id_usuario_referencia",
                'value' => 0,
            ]
        );


        $response[] = hiddens(
            [
                "name" => "cliente",
                'value' => "",
            ]
        );

        $response[] = hiddens(
            [
                "name" => "v",
                'value' => 1,
            ]
        );
        $response[] = hiddens(
            [
                "name" => "tipo_entrega",
                'value' => 0,
            ]
        );
        $response[] = hiddens(
            [
                "name" => "status_venta",
                'value' => 0,
            ]
        );
        $response[] = hiddens(
            [
                "name" => "recibo",
                'value' => "",
            ]
        );
        $response[] = hiddens(
            [
                "name" => "tipo_orden",
                'value' => 5,
            ]
        );



        $response[] = d(frm_fecha_busqueda(), 'd-none');

        $response[] = form_close();
        return d($response, 12);
    }
    function seccion_facebook($data)
    {
        $response = [];
        $usuario_busqueda = $data["usuario_busqueda"];
        if (es_cliente($usuario_busqueda)) {

            $link_facebook = pr($usuario_busqueda, "facebook");
            if (str_len($link_facebook, 11)) {

                $icon = icon(_facebook_icon);
                $config = ["href" => $link_facebook, "target" => "_blac"];
                $response[] = a_enid($icon, $config);
            }
        }
        return append($response);
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
        if (es_cliente($data["perfil_busqueda"])) {
            return "";
        }
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

            $link_ventas = a_texto(
                'Mis ventas',
                [
                    'class' => 'text-center ',
                    'href' => path_enid('pedidos')
                ]
            );
            $text_ventas = text_icon(_bomb_icon, $link_ventas);
            $texto_top = 'Identifica tus ordenes de compras enviadas';
            $texto_ventas = flex(
                $text_ventas,
                $texto_top,
                'flex-column',
                "",
                "fp8 mt-3 text-secondary"
            );

            $link_top_ventas = a_texto(
                'Top ventas',
                [
                    'class' => 'text-center black',
                    'href' => path_enid('top_competencia')
                ]
            );

            $icono_top = text_icon(_estrellas_icon, $link_top_ventas);
            $texto_top = 'Mira qué posición ocupas en la tabla';
            $texto_top_ventas = flex(
                $icono_top,
                $texto_top,
                'flex-column',
                "",
                "fp8 mt-3 text-secondary"
            );

            $r[] = d(
                d_c(
                    [
                        $seccion_meta,
                        $ventas_actuales,
                        $restantes,
                        $texto_ventas,
                        $texto_top_ventas
                    ],
                    'f11 col-lg-4 mx-auto text-center mt-5'
                ),
                'row black'
            );
        }
        return append($r);
    }

    function seccion_estadisticas_compras($data)
    {

        $response = [];
        $usuario_busqueda = $data["usuario_busqueda"];
        if (es_cliente($usuario_busqueda)) {


            $response[] = add_deseos($data);
        }

        return append($response);
    }

    function seccion_deseos_compra($data)
    {
        $usuario_busqueda = $data["usuario_busqueda"];
        $response = [];
        if (es_cliente($usuario_busqueda)) {
            $otros_productos_interes = $data["otros_productos_interes"];

            if (es_data($otros_productos_interes)) {
                $response[] = d(_titulo("Cosas que le interesan al cliente", 2), 'col-xs-12 mb-3');
            }


            foreach ($otros_productos_interes as $row) {

                $icon = icon(_eliminar_icon);
                $tag = flex($icon, $row["tag"], "", "mr-3");

                $response[] = d(d($tag, "border-bottom border-info mt-1"), 'col-xs-12');
            }
        }
        return d($response, 13);
    }

    function total_cancelaciones($recibos)
    {

        $total = 0;
        foreach ($recibos as $row) {

            $num_ciclos_contratados = $row["num_ciclos_contratados"];
            if (es_orden_cancelada($row)) {

                $total = $total + $num_ciclos_contratados;
            }
        }
        return $total;
    }

    function totales($recibos)
    {

        $total = 0;
        foreach ($recibos as $row) {

            $num_ciclos_contratados = $row["num_ciclos_contratados"];

            $total = $total + $num_ciclos_contratados;
        }
        return $total;
    }

    function notificacion_encuesta()
    {

        $response[] = d(_titulo('Gracias por ayudar a mejorar nuestro servicio!', 2), 'text-center  text-uppercase');
        $response[] = d(format_link(
            'Sigue explorando',
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

            $estrellas[] = label(
                "★",
                [
                    "class" => ' black' . " f2 estrella_" . $x,
                    "for" => "$id_input",
                    "id" => $x,
                ]
            );
        }

        $response[] = d(_titulo(round($calificacion, 2)), 'text-center');
        $response[] = d(_text_('Valoraciones', strong($encuestas)), 'text-center');
        $response[] = d($estrellas, 'text-center');


        if (!$es_propietario) {

            $response[] = d(
                format_link(
                    'Califícame',
                    [
                        'class' => 'calificame',
                        'id' => $id_usuario
                    ]
                )
            );
        }
        $response[] = deseos($data);


        $id_usuario_califica = ($data['in_session']) ? $data['id_usuario'] : 0;
        $response[] = hiddens(['class' => 'input_id_usuario', 'value' => $id_usuario]);
        $response[] = hiddens(['class' => 'input_id_usuario_califica', 'value' => $id_usuario_califica]);
        return append($response);
    }

    function add_deseos($data)
    {

        $usuario_busqueda = $data["usuario_busqueda"];
        $id_usuario = pr($usuario_busqueda, "id_usuario");

        $form_otros[] = _titulo('¿El cliente tiene interés sobre otros artículos?');
        $form_otros[] = form_open('', ['class' => 'form_articulo_interes_entrega mt-5']);
        $form_otros[] = input_frm(
            '',
            '¿Qué artículo?',
            [
                'class' => 'nuevo_articulo_interes',
                'id' => 'nuevo_articulo_interes',
                'name' => 'tag',
                'placeholder' => 'Ej. camisa',
                'type' => 'text',
                'required' => true
            ]
        );
        $form_otros[] = hiddens(['name' => 'usuario', 'value' => $id_usuario]);
        $form_otros[] = hiddens(['name' => 'recibo', 'value' => ""]);
        $form_otros[] = hiddens(['name' => 'tipo', 'value' => 2]);
        $form_otros[] = d(btn('Agregar'), 'mt-5');
        $form_otros[] = form_close();


        return gb_modal(d($form_otros, 'form_otros'), "modal_otros");
    }

    function modal_acciones_seguimiento($data)
    {

        $acciones_seguimiento = $data["acciones_seguimiento"];
        $lista_acciones_seguimiento[] = _titulo("¿Que tipo de seguimiento realizaremos?");
        
        foreach ($acciones_seguimiento as $row) {

            $acccion = $row["accion"];
            $card_body  = d(p($acccion, ''), ["class" => "card-body"]);
            $tarjeta = d(d(
                $card_body,
                [
                    "class" => "card mt-3 accion_seguimiento_usuario",
                    "onmouseover" => "this.style.backgroundColor='#f2f2f2'",
                    "onmouseout" => "this.style.backgroundColor='white'",
                    "id" => $row["id"],
                ]
            ));

            $lista_acciones_seguimiento[] = $tarjeta;
        }
        $lista_acciones_seguimiento[] = hiddens(["class" => "input_id_recibo", "value" => $data["id_recibo"]]);

        return gb_modal(d($lista_acciones_seguimiento, 'form_otros'), "modal_accion_seguimiento");
    }

    function modal_descubrimiento_accion_seguimiento($data)
    {

        $usuario_busqueda = $data['usuario_busqueda'];
        $tel_contacto = pr($usuario_busqueda, 'tel_contacto');


        $acciones_seguimiento = $data["acciones_seguimiento"];
        $titulo_icono = flex(icon(_text_(_check_icon, 'fa-2x')), _titulo("Vamos a realizar un:"), '', 'mr-2');
        $lista_acciones_seguimiento[] = d(d(d($titulo_icono, 'underline'), 'col-xs-12'), 13);

        foreach ($acciones_seguimiento as $row) {

            $tarjeta = [];
            $tarjeta[] = d($row["accion"], 'mt-4 strong f11 col-xs-12  text-center');


            if ($row["mostrar_ayuda"] > 0 && str_len($row["ayuda_accion"], 1)) {

                $tarjeta[] = d(span("Este texto te podría ayudar!", 'border_black p-2'), "col-xs-12 mt-4 mb-4 text-center");
                $tarjeta[] = d(icon(_mas_opciones_bajo_icon), "col-xs-12 mt-4 text-center");
                $tarjeta[] = d(icon(_mas_opciones_bajo_icon), "col-xs-12 text-center");
                $tarjeta[] = d($row["ayuda_accion"], ["class" => 'mt-3 col-xs-12', 'id' => "texto-a-copiar"]);
            }


            $tarjeta[] = d(format_phone($tel_contacto), 'col-xs-12 mt-3 text-center underline');
            $tarjeta[] = d(format_link("Ya lo envié!", ["class" => "ya_envie text-center mt-5", "id" => $row["id"]]), 'col-sm-6 col-sm-offset-3');
            $tarjeta[] = d(cargando(), 'text-center mx-auto col-sm-6 col-sm-offset-3');


            $tarjeta_accion_seguimiento = _text("tarjeta_accion_seguimiento_", $row["id"]);
            $lista_acciones_seguimiento[] = d($tarjeta, _text_('row d-none tarjeta_opcion_seguimiento', $tarjeta_accion_seguimiento));
        }


        $form[] = form_open(
            "",
            [
                "class" => "form_comentarios_accion_seguimiento col-xs-12 d-none",
                "id" => "form_comentarios_accion_seguimiento",
                "method" => "post"
            ]
        );


        $form[] = d(textarea(['name' => "comentario", 'class' => "comentario_seguimiento"]), 'd-none');
        $form[] = d("Ups parece que falta esto", "mt-3 color_red d-none place_area_comentario");
        $usuario_busqueda = $data['usuario_busqueda'];
        $id_usuario = pr($usuario_busqueda, 'id_usuario');

        $form[] = hiddens(["name" => "id_usuario", "value" => $id_usuario]);
        $form[] = hiddens(["name" => "id_accion_seguimiento", "value" => 0, 'class' => "input_id_accion_seguimiento"]);
        $form[] = d(btn("Eviar comentarios!", ["class" => "enviar_comentarios text-center mt-5", "id" => $row["id"]]), 'col-sm-8 col-sm-offset-2 d-none');
        $form[] = form_close();
        $form[] = d(cargando(), 'text-center mx-auto');


        $form[] = form_open(
            "",
            [
                "class" => "form_comentarios_accion_seguimiento_notificado col-xs-12 d-none",
                "id" => "form_comentarios_accion_seguimiento_notificado",
                "method" => "post"
            ]
        );

        $form[] = flex(icon(_text_(_check_icon, 'fa-2x')), _titulo("¿Qué comentó el cliente?"), 'mb-5', 'mr-2');
        $form[] = d(textarea(['name' => "comentario", 'class' => "comentario_seguimiento"]));
        $form[] = d("Ups parece que falta esto", "mt-3 color_red d-none place_area_comentario");
        $usuario_busqueda = $data['usuario_busqueda'];
        $id_usuario = pr($usuario_busqueda, 'id_usuario');

        $form[] = hiddens(["name" => "id", "value" => "",  "class" => "id_accion_en_seguimiento"]);
        $form[] = d(btn("Eviar comentarios!", ["class" => "enviar_comentarios text-center mt-5", "id" => $row["id"]]), 'col-sm-8 col-sm-offset-2');
        $form[] = form_close();
        $form[] = d(cargando(), 'text-center mx-auto');


        $lista_acciones_seguimiento_comentarios = d($form, 13);
        $lista_opciones = d($lista_acciones_seguimiento, 'lista_acciones_seguimiento_opciones');
        $response = [$lista_acciones_seguimiento_comentarios, $lista_opciones];
        return gb_modal($response, "modal_accion_seguimiento_descubrimiento");
    }
    function modal_recordatorio_seguimiento($data)
    {

        $form[] = form_open(
            "",
            [
                "class" => "form_recordatorio_seguimiento col-xs-12",
                "id" => "form_recordatorio_seguimiento",
                "method" => "post"
            ]
        );

        $form[] = d(flex(icon(_text_(_check_icon, 'fa-2x')), _titulo("¿Cuando se tiene que hacer?", 2), 'mb-5', 'mr-2'), 'estructura_fechas');

        $form[] = d(input_enid(
            [
                "data-date-format" => "yyyy-mm-dd",
                "name" => 'fecha_evento',
                "class" => "fecha_evento",
                'id' => 'fecha_evento',
                "type" => 'date',
                "value" => date("Y-m-d"),
                "min" => date("Y-m-d"),
                "max" => add_date(date("Y-m-d"), 90),
            ]
        ), 'estructura_fechas');
        $form[] = d(format_link("Enviar", ["class" => "envio_fecha_evento text-center mt-5"]), 'col-sm-8 col-sm-offset-2 estructura_fechas');

        $form[] = d(flex(icon(_text_(_check_icon, 'fa-2x')), _titulo("¿Qué hay que hacer?", 2), 'mb-5', 'mr-2'), 'd-none estructura_hecho');
        $form[] = d(textarea(['name' => "comentario", 'class' => "comentario_seguimiento"]), 'd-none estructura_hecho');
        $form[] = d("Ups parece que falta esto", "mt-3 color_red d-none place_area_comentario");
        $usuario_busqueda = $data['usuario_busqueda'];
        $id_usuario = pr($usuario_busqueda, 'id_usuario');

        $form[] = hiddens(["name" => "id_accion_seguimiento", "value" => 3,  "class" => "id_accion_en_seguimiento"]);
        $form[] = hiddens(["name" => "id_usuario", "value" => $id_usuario]);
        $form[] = d(btn("Enviar comentarios!", ["class" => "enviar_comentarios text-center mt-5"]), 'col-sm-8 col-sm-offset-2 d-none estructura_hecho');
        $form[] = form_close();
        $form[] = d(cargando(), 'text-center mx-auto');

        return gb_modal($form, "modal_recordatorio_accion");
    }


    function deseos($data)
    {

        $response = [];
        $usuario_busqueda = $data["usuario_busqueda"];

        if (es_cliente($usuario_busqueda)) {

            $id_usuario = pr($usuario_busqueda, "id_usuario");
            $response[] = d(
                format_link(
                    'deseos',
                    [
                        'class' => 'deseos_cliente mt-3',
                        'id' => $id_usuario
                    ],
                    0
                )
            );
        }

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
                    ],
                    0
                ),
                'col-md-4 mt-4'
            );
        }


        $response[] = d($r, 13);
        $response[] = d($label_tipificacion, 13);
        $input = d(input_frm(
            12,
            'Dejar un comentario',
            [
                'class' => 'input_comentario',
                'id' => 'input_comentario'
            ]
        ), 'mt-5 row');

        $response[] = $input;


        $response[] = hiddens(["class" => "input_id_servicio", "value" => prm_def($data, "id_servicio")]);
        $enviar_puntuacion = btn(
            'Enviár',
            [
                'class' => 'enviar_formulario_boton col-md-3 ml-auto'
            ]
        );
        $response[] = d($enviar_puntuacion, 'row mt-5');

        return d($response, 'col-lg-10 col-md-offset-1 text-center');
    }
    function modal_recordatorio_seguimiento_evento($data)
    {
        
        $form[] = d(flex(icon(_text_(_check_icon, 'fa-2x')), _titulo("Ya realizaste esta acción?",2), 'mb-5', 'mr-2'));       
    
        $confirmacion = btn("si", ["class" => "confirmacion_evento text-center mt-5"]);
        $confirmacion_comentario = btn("si y anotar un comentario ", ["class" => "confirmacion_evento_comentario text-center mt-5"]);
        
        $form[] = hiddens(["class"=>"id_users_accion_seguimiento"]);
        $form[] = flex($confirmacion_comentario, $confirmacion,_between);
        $form[] = d(cargando(), 'text-center mx-auto envio_comentario_evento');

        return gb_modal($form, "modal_cambio_estado_evento");
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

            $response[] = label(
                "★",
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
