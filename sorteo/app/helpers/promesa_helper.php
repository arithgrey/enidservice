<?php

use App\View\Components\titulo;

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function construye_galeria_imagenes($data)
    {

        $imgs = $data["imgs"];
        $nombre = pr($data["servicio"], "nombre_servicio");
        $is_mobile = $data["is_mobile"];
        $imagenes = img_lateral($imgs, $nombre, $is_mobile);

        $clases = " align-self-center mx-auto col-lg-4 d-none d-lg-block d-xl-block 
            d-md-block d-xl-none aviso_comision pt-3 pb-3";
        $clases_imagenes =
            " tab-content col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 
            col-lg-8  align-self-center";

        $seccion_imagenes[] = btw(
            d($imagenes["preview"], $clases),
            d($imagenes["imagenes_contenido"], $clases_imagenes)

        );

        $seccion_imagenes[] = d($imagenes["preview_mb"], "d-none d-sm-block d-md-none d-flex mt-5 row azul_deporte");
        return d($seccion_imagenes, 13);
    }
    function render_plano($data, $id_servicio)
    {
        
        $numero_boletos = pr($data["boletos"], "boletos");
        
        $boletos = [];
        $boletos_pagos = 0;
        $boletos_por_pago = 0;
        $numero_ganador = pr($data["boletos"], "numero_ganador");

        for ($b = 1; $b <= $numero_boletos; $b++) {
    
            $boleto_compra = busqueda_boleto_pago($b, $data["boletos_comprados"]);        
            $disponible = $boleto_compra["disponibilidad"];
            if ($disponible < 1) {
                $boletos_por_pago++;
            } else {
                $boletos_pagos++;
            }
            $usuario_compra = $boleto_compra["usuario_compra"];
            $id_orden_compra = $boleto_compra["id_orden_compra"];
            $nombre_usuario_compra  = ($numero_ganador > 0  ) ? "" : $boleto_compra["nombre_usuario_compra"];

            $extra_tickt = ($disponible < 1) ? "":"white";
            $icono = icon(_text_('fa fa-ticket fa-3x', $extra_tickt));


            $extra_ganador = ($numero_ganador >  0) ? '':'agregar_deseos_sin_antecedente';
            $extra = ($disponible < 1) ?
                _text_("border border-secondary cursor_pointer numero_boleto",$extra_ganador)
                :
                "cursor_pointer blue_bg white borde_green numero_boleto usuario_compra_ticket";   




            $tick_numero = _text("ticket_n_", $b);

            $icono_nombre = flex($icono, $nombre_usuario_compra,'flex-column','','fp8');
            $ticket_boleto = flex(
                $b,
                $icono_nombre,
                _text_('p-2 text-center', $extra),
                _text_("p-2 ", $tick_numero),
                "",
                "d-flex  w-100",
                [
                    "id" => $id_servicio,
                    "numero_boleto" => $b,
                    "usuario_compra" => $usuario_compra,
                    "id_orden_compra" => $id_orden_compra
                ]
            );
            $curpo_boleto = d($ticket_boleto, 13);

            $boletos[] = d($curpo_boleto, 'col-xs-3 col-sm-3 mt-3');
        }


        
        $seccion_tickets[] =  d(d(d(
            textos_transmision($data), 'col-sm-12 display-8  p-2 black '), 12), 'row mb-5');

        $seccion_tickets[] =  d(d(d("Pulsa en los tickets para agregar al carrito tus boletos deseados", 'col-sm-12 display-8 borde_end p-2 black strong'), 12), 'row mb-5');
        
        $seccion_tickets[] =  d(d(flex("", "Disponibles", "align-items-center", "mr-4 borde_yellow border border-secondary p-4", "f12  black "), 12), 13);
        $seccion_tickets[] =  d(d(flex("", "Comprados", "align-items-center mt-3 ", "mr-4  blue_bg white borde_green p-4", "f12  black "), 12), 13);
        $seccion_tickets[] =  d(d(flex($boletos_pagos, "Vendidos hasta el momento", "align-items-center mt-3 borde_green p-1", "mr-4 strong f12", "  black "), 12), 13);
        $seccion_tickets[] =  d(d(flex($boletos_por_pago, "Disponibles", "align-items-center mt-3 borde_green p-1", "mr-4 strong f12", "  black "), 12), 13);

        $seccion_tickets[] =  d($boletos, 13);

        $seccion_imagenes = construye_galeria_imagenes($data);
        $ficha_servicio = ficha_servicio($data);
        $seccion_ficha_servicio[] = editar($data, $id_servicio);
        $seccion_ficha_servicio[] = editar_cantidades_sorteo($data, $id_servicio);
        $seccion_ficha_servicio[] =  $seccion_imagenes;
        $seccion_ficha_servicio[] =  $ficha_servicio;

        $response[] =  d(append($seccion_ficha_servicio), 4);
        $response[] =  d($seccion_tickets, 6);
        $response[] =  d(enviar_compra(), 2);
        $response[] = d(modal_usuario_venta($data), 12);

        $response[] = hiddens(["class" => "boleto_comprado", "value" => $data["boleto"]]);
        $response[] = hiddens(["class" => "numero_sorteo", "value" => $data["numero_sorteo"]]);
        $response[] = modal_cantidad_fechas($data);
        $response[] = modal_finalizacion_concurso($data);
        

        return d(d($response, 13), 10, 1);
    }
    function textos_transmision($data){

        $numero_ganador = pr($data["boletos"], "numero_ganador");
        $response = [];
        
        if($numero_ganador > 0){
            
            $boleto_compra = busqueda_boleto_pago($numero_ganador, $data["boletos_comprados"]);                                
            $nombre_usuario_compra = $boleto_compra["nombre_usuario_compra"];
            $str = _text_("El sorteó finalizo!", "número ganador", $numero_ganador, $nombre_usuario_compra);
            
            $response[] = d($str,'p-4 mb-5 bg_black borde_amarillo white f15');
        
        }

        $path = path_enid("enid_service_facebook", 0, 1);
        $link_facebook = a_enid(
            "Facebook",
            [
                "class" => "text-center borde_accion p-2 pb-2 pt-2 bg_black white borde_green cursor_pointer",
                "href" => $path
            ],
            0
        );


        $path = path_enid("youtube_vivo", 0, 1);
        $link_youtube = a_enid(
            "Youtube",
            [
                "class" => "text-center borde_accion p-2 pb-2 pt-2 bg_black white borde_green cursor_pointer",
                "href" => $path
            ],
            0
        );
        $response[] = _text_(
            "Las rifas son trasmitidas en",
            $link_facebook,
            "y en ",$link_youtube
        );

        return append($response);


    }
    function modal_cantidad_fechas($data)
    {

        $sorteo = $data["boletos"];
        $id_sorteo = pr($sorteo, "id");
        $fecha_registro = pr($sorteo, "fecha_registro");
        $fecha_termino = pr($sorteo, "fecha_termino");
        $boletos = pr($sorteo, "boletos");


        $form[] = d(_titulo('¿Inicio y termino del sorteo?'), 'text-center text-md-left');
        $formulario[] = form_open("", ["class" => "form_edicion_sorteo", "id" => "form_edicion_sorteo"]);


        $formulario[] = input_frm(
            'col-xs-6 mt-5',
            "Fecha inicio",
            [
                "name" => 'fecha_inicio',
                "class" => "input_busqueda_inicio mb-5",
                "id" => 'datetimepicker4',
                "value" => date_format(date_create($fecha_registro), 'Y-m-d'),
                "type" => "date",
            ]
        );

        $formulario[] = input_frm(
            'col-xs-6 mt-5',
            "Fecha término",
            [
                "name" => 'fecha_termino',
                "class" => "input_busqueda_termino mb-5",
                "id" => 'datetimepicker5',
                "value" => date_format(date_create($fecha_termino), 'Y-m-d'),
                "type" => "date",
            ]

        );

        $formulario[] = hiddens(["class" => "id_sorteo", "name" => "id", "value" => $id_sorteo]);
        $formulario[] = input_frm(
            'mt-5 col-md-12 col-xs-12 mb-5',
            "¿Boletos disponibles?",
            [
                "type" => "number",
                "required" => true,
                "class" => "boletos",
                "name" => "boletos",
                "id" => "boletos",
                "value" => $boletos
            ]
        );


        $formulario[] = btn('Registrar', ['class' => 'mt-5']);
        $formulario[] = form_close();

        $form[] = d($formulario);
        $modal = append($form);
        return gb_modal($modal, "modal_edicion_sorteo");
    }
    function modal_finalizacion_concurso($data)
    {

        $id_servicio = pr($data["boletos"], "id_servicio");
        $sorteo = $data["boletos"];
        $id_sorteo = pr($sorteo, "id");        

        $select = create_select(
            $data["boletos_comprados"], 
            "numero_ganador",
            "numero_ganador",
            "numero_ganador",
            "numero_boleto",
            "numero_boleto");

        $form[] = d(_titulo('Qué boleto fué el ganador?'), 'col-xs-12');
        $formulario[] = form_open("", ["class" => "form_sorteo_finalizacion"]);

        $formulario[] = d($select,12);
        
        $formulario[] = hiddens(["class" => "id_sorteo", "name" => "id", "value" => $id_sorteo]);
        $formulario[] = hiddens(["class" => "id_servicio", "name" => "id_servicio", "value" => $id_servicio]);
        

        $formulario[] = d(btn('Finalizar sorteo!', ['class' => 'mt-5']),'col-xs-12');
        $formulario[] = form_close();

        $form[] = d($formulario);
        $modal = append($form);
        return gb_modal($modal, "modal_finalizacion_sorteo");
    }


    function enviar_compra()
    {

        $response[] = d("", ["class" => "tickets_apartados"]);
        $response[] =  d(d(
            "Comprar tickets",
            [
                "class" => "border text-center pb-3 pt-3 p-2 col text-uppercase d-block"
            ]
        ), 'simular_compra');
        $response[] = d(format_link("Comprar tickets", ["href" => path_enid("lista_deseos")]), 'd-none enviar_orden');
        return append($response);
    }
    function busqueda_boleto_pago($numero_boleto, $boletos_pagos)
    {

        $response  = 0;
        $id_usuario = 0;
        $id_orden_compra = 0; 
        $nombre_usuario_compra = "";
        foreach ($boletos_pagos as $row) {

            $numero_boleto_pago = $row["numero_boleto"];

            if ($numero_boleto == $numero_boleto_pago) {
                $id_usuario = $row["id_usuario"];
                $id_orden_compra = $row["id_orden_compra"];
                $nombre_usuario_compra = format_nombre($row["usuario"]);

                $response++;
                break;
            }
        }

        return [
            "disponibilidad"  => $response,
             "usuario_compra" => $id_usuario, 
             "id_orden_compra" => $id_orden_compra,
             "nombre_usuario_compra" => $nombre_usuario_compra
            ];
    }
   

    function render($data, $param)
    {

        $form[] = form_open("", ["class" => "sorteo_form mt-5 row"]);
        $form[] = input_frm(
            'mt-5 col-md-12 col-xs-12 mb-5',
            "¿Boletos a la venta?",
            [
                "type" => "number",
                "required" => true,
                "class" => "boletos",
                "name" => "boletos",
                "id" => "boletos",
                "value" => 40
            ]
        );

        $inicio = date("Y-m-d");
        $fin = date("Y-m-d");

        $form[] = input_frm(
            'col-xs-6 mt-5',
            "Fecha inicio",
            [
                "name" => 'fecha_inicio',
                "class" => "input_busqueda_inicio",
                "id" => 'datetimepicker4',
                "value" => $inicio,
                "type" => "date",
            ]
        );

        $form[] = input_frm(
            'col-xs-6 mt-5',
            "Fecha término",
            [
                "name" => 'fecha_termino',
                "class" => "input_busqueda_termino",
                "id" => 'datetimepicker5',
                "value" => $fin,
                "type" => "date",
            ]

        );
        $form[] = hiddens(["name" => "id_servicio", "value" => $param["q"]]);

        $form[] = d(btn("Agregar meta", ["class" => "mt-5"]), 12);
        $form[] = form_close();

        $response[] = d(_titulo("Sobre la rifa", 3), 12);
        $response[] = d(hr());
        $response[] = append($form);

        return d($response, 8, 1);
    }

    function img_lateral($param, $nombre_servicio, $is_mobile)
    {

        $preview = [];
        $imgs_grandes = [];
        $preview_mb = [];
        $z = 0;

        foreach ($param as $row) {

            $url = get_url_servicio($row["nombre_imagen"], 1);
            $extra_class = "";
            $extra_class_contenido = '';

            if ($z < 1) {
                $extra_class = ' active ';
                $extra_class_contenido = ' in active ';
            }


            $preview[] =
                img(
                    [
                        'src' => $url,
                        'alt' => $nombre_servicio,
                        'class' => 'mt-2 border cursor_pointer bg_white ' . $extra_class,
                        'id' => $z,
                        'data-toggle' => 'tab',
                        'href' => "#imagen_tab_" . $z
                    ]
                );

            $preview_mb[] = img(
                [
                    'src' => $url,
                    'alt' => $nombre_servicio,
                    'class' => 'mt-2 border mh_50 mah_50 mr-1 mb-1' . $extra_class,
                    'id' => $z,
                    'data-toggle' => 'tab',
                    'href' => _text("#imagen_tab_", $z)
                ]

            );


            $ext = ($is_mobile < 1) ? "  " : "";

            $imgs_grandes[] =
                img(
                    [
                        'src' => $url,
                        "class" => " w-100 tab-pane fade zoom" . $ext . " " . $extra_class_contenido,
                        "id" => "imagen_tab_" . $z,

                    ]
                );

            $z++;
        }


        $principal = "";

        if (es_data($param)) {

            $principal = (count($param) > 1) ? $param[1]["nombre_imagen"] : $param[0]["nombre_imagen"];
        }


        $response = [
            "preview" => append($preview),
            "preview_mb" => append($preview_mb),
            "num_imagenes" => count($param),
            "imagenes_contenido" => append($imgs_grandes),
            "principal" => get_url_servicio($principal, 1)
        ];
        return $response;
    }
    function ficha_servicio($data)
    {
        $sorteo = $data["boletos"];

        $servicio = $data["servicio"];
        $imgs = $data["imgs"][0];
        $descripcion = pr($servicio, "descripcion");
        $nombre = pr($servicio, "nombre_servicio");
        $es_servicio = pr($servicio, "flag_servicio");
        $es_nuevo = pr($servicio, "flag_nuevo");
        $marca = pr($servicio, "marca");
        $dimension = pr($servicio, "dimension");
        $peso = pr($servicio, "peso");
        $capacidad = pr($servicio, "capacidad");
        $precio = pr($servicio, "precio");

        $z[] = d(_titulo($nombre, 0, "borde_end p-1"), "mb-4 row mt-3");
        $z[] = d(money($precio), 'f25 colo_precio_enid row');

        $fecha_termino = pr($sorteo, "fecha_termino");
        $textos_fechas = flex("Fecha del evento", format_fecha($fecha_termino), '', 'mr-3');
        $z[] = d($textos_fechas, 'f12 black row');


        $fecha = horario_enid();
        $hoy = $fecha->format('Y-m-d');
        $dias_restantes = date_difference($hoy, $fecha_termino);

        $textos_fechas_dias = _text_("Faltan", $dias_restantes, 'días para el evento');
        if ($hoy > $fecha_termino) {
            $textos_fechas_dias = _text_("El evento fué hace", $dias_restantes, 'días');
        }

        $z[] = d($textos_fechas_dias, 'f12 black borde_end_b row');




        $z[] = ubicacion_entrega($servicio);

        if (str_len($descripcion, 5)) {

            $z[] = d($descripcion, 'mt-4 mb-4 row');
        }

        $z[] = get_tipo_articulo($es_nuevo, $es_servicio);
        $z[] = validador_atributo($marca, 'Marca');
        $z[] = validador_atributo($dimension, 'Dimensiones');
        if ($peso > 0) {
            $z[] = validador_atributo($peso, 'Peso', 'KG');
        }

        if ($capacidad > 0) {
            $z[] = validador_atributo($capacidad, 'Capacidad', "KG");
        }

        $yt = pr($servicio, "url_vide_youtube");
        $i = pre_youtube($imgs, $yt);


        $contenido_descripcion = append($z);
        $imagen = $i["img"];

        $response[] = d($contenido_descripcion, 12);
        $response[] = d($imagen, 12);

        return d($response, 13);
    }
    function get_tipo_articulo($es_nuevo, $es_servicio)
    {

        return ($es_servicio == 0 && $es_nuevo == 0) ? d('ARTÍCULO USADO') : "";
    }
    function validador_atributo($atributo, $texto, $extra = '')
    {

        $response = '';
        if (str_len($atributo, 0)) {

            $response = d(_text_(strong($texto), $atributo, $extra));
        }
        return $response;
    }
    function pre_youtube($imgs, $youtube)
    {
        $f = 1;
        $response = img(
            [
                'src' => $imgs["principal"],
                "class" => "row"
            ]
        );

        if (str_len($youtube, 5)) {

            $response = iframe(
                [
                    "height" => (is_mobile() == 0) ? "500px" : "400px",
                    "src" => $youtube,
                    "frameborder" => '0',
                    "allow" => 'autoplay',
                    "class" => "w-100 row"
                ]
            );
            $f = 0;
        }
        return [
            "img" => $response,
            "es_imagen" => $f
        ];
    }
    function editar($data, $id_servicio)
    {

        $response = "";
        if (es_administrador($data)) {

            $editar = a_enid(
                text_icon('fa fa-pencil', "Editar información del producto"),
                [
                    "href" => path_enid("editar_producto", $id_servicio),
                    "class" => "black strong p-3 "
                ]
            );
            $texto_editar = d($editar, 13);
            $response = d($texto_editar, ' mr-5 col-lg-12 text-right border-bottom');
        }
        return $response;
    }
    function editar_cantidades_sorteo($data, $id_servicio)
    {

        $response = "";
        if (es_administrador($data)) {

            $editar = d(
                text_icon('fa fa-pencil', "Cantidades y fechas"),
                [
                    "class" => "black strong editar_sorteo p-3",
                    "id" => $id_servicio
                ]
            );

            $texto_editar = d($editar, 13);
            $contenido[] = d($texto_editar, ' mr-5 col-lg-12 text-right border-bottom');

            $numero_ganador = pr($data["boletos"], "numero_ganador");
            if($numero_ganador < 1){
                $contenido[] = d(d(d(format_link("Dar por terminado el concurso!",
                [
                    "class" => "termino_sorteo"
                ]), 'col-sm-12 display-8 borde_end p-2 black strong'), 12), 'row mb-5');
            }
            
            $response = append($contenido);

        }
        return $response;
    }

    function ubicacion_entrega($servicio)
    {

        $response  = [];
        $link_maps =  pr($servicio,  "link_maps");
        if (str_len($link_maps, 5)) {

            $response[] =  d("Ubicación donde será entregado el sorteo", 'borde_green p-1');
            $response[] = pr($servicio, "link_maps");
        }
        return d($response, 13);
    }
    function modal_usuario_venta($data)
    {
        
        $form[] = d(_titulo('Boleto comprado por:'), 'text-center text-md-left row');
        
        if(es_administrador($data)){
    
            $editar = a_enid(
                text_icon('fa fa-pencil', ""),
                [
                    "class" => "black strong edicion_datos_sorteo ml-auto",
                    
                ]
            );

            $form[] = d($editar, 13);    
        }
        $form[] = d(flex("Nombre", place("nombre_comprador"), _text_('borde_end_b p-2 f12 mt-5', _between), "strong"), 13);
        $form[] = d(flex("Teléfono", place("telefono_comprador"), _text_('borde_end_b p-2 f12 mt-5', _between), "strong"), 13);
        $form[] = d(flex("Número", place('place_numero_boleto bg_black white p-3 strong f13 borde_amarillo'), 'flex-column mx-auto mt-3 text-center', 'f15 strong text-center'), 13);
        
        $modal = d($form, 12);
        return gb_modal($modal, "modal_usuario_compra");
    }
}
