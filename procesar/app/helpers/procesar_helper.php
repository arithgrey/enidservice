<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render_procesar_contacto($data)
    {

        $in_session = $data["in_session"];
        $z[] = str_title($in_session, $data["is_mobile"], 1);
        $z[] = frm_contacto_servicio($in_session, $data["servicio"]);

        return d($z, 8, 1);
    }

    function render_procesar($data)
    {

        $inf_ext = $data["info_solicitud_extra"];
        $es_carro_compras = $inf_ext["es_carro_compras"];
        $producto_carro_compra = $inf_ext["producto_carro_compra"];
        $is_mobile = $data["is_mobile"];
        $q2 = $data["q2"];
        $in_session = $data["in_session"];
        $es_cliente = ($data['id_perfil'] == 20) ? 1 : 0;
        $es_cliente = ($in_session) ? $es_cliente : 1;

        $ext = $inf_ext;
        $ext["q2"] = $q2;
        $talla = (array_key_exists("talla", $inf_ext)) ? $inf_ext["talla"] : 0;
        $r[] = place("info_articulo", ["id" => 'info_articulo']);

        $z[] = str_title($in_session, $is_mobile);
        $z[] = form_open(
            "",
            [
                "class" => "form_nuevo",
                "id" => "form-miembro-enid-service",
            ]
        );

        $z[] = frm_miembro_enid_service_hidden(
            $q2,
            $ext["id_servicio"],
            $ext["num_ciclos"],
            $ext["ciclo_facturacion"],
            $talla,
            $es_cliente,
            $es_carro_compras,
            $producto_carro_compra
        );
        $z[] = formulario_primer_registro($in_session, $ext, $es_cliente, $data);
        $z[] = hiddens(
            [
                "value" => $data["email"],
                "class" => 'email_s'
            ]
        );

        $contenedor = d($z, "contenedo_compra_info");
        $contendor_compra = d($contenedor, "contenedor_compra");
        $r[] = d($contendor_compra, "col-lg-8 col-lg-offset-2");

        return append($r);
    }

    function str_title($in_session, $is_mobile, $es_servicio = 0)
    {

        $text = "";
        if ($es_servicio > 0) {
            $text = ($in_session == 0 && $is_mobile == 0) ?
                h("SOLICITA TU PRESUPUESTO", 3, " strong") : "";
        }

        return $text;
    }


    function formulario_primer_registro($in_session, $param, $es_cliente, $data)
    {

        $es_cliente_class = ($es_cliente) ? '' : 'd-none';
        $r = [];
        if ($in_session < 1 || !$es_cliente) {

            $producto_carro_compra = $param["producto_carro_compra"];
            $recompensas = $param["recompensas"];
            $titulo = "INFORMACIÓN DE CONTACTO";
            $r[] = d(flex(_titulo($titulo)), 'mb-5');

            if (!$in_session) {


                $clase = 'mt-3 black p-2';
                $r[] = d(
                    _text_(
                        icon('fa fa-truck'),
                        'Solo usaremos estos datos para ayudarnos a entregar tu pedido'
                    ),
                    $clase
                );
            }


            $input = input_enid(
                [
                    "name" => "nombre",
                    "id" => "nombre",
                    "class" => _text_("nombre", _format_input),
                    "type" => "text",
                    "required" => "true",
                    "placeholder" => "¿Cual es tu nombre?",
                    'onkeyup' => "this.value = this.value.toUpperCase();"
                ],
                _text_nombre
            );

            $z[] =  d($input, "col-lg-6 mt-5 ");


            $input_telefono = input_enid(
                [
                    "id" => "telefono",
                    "class" => _text_("telefono", _format_input),
                    "type" => "tel",
                    "maxlength" => 10,
                    "minlength" => 8,
                    "name" => "telefono",
                    "required" => "true",
                    "placeholder" => "Número telefónico (10) digitos"
                ],_text_telefono
            );

            $z[] = d($input_telefono, "col-lg-6 mt-5");

            $extra_sorteo  = ($param["es_sorteo"] > 0 || $in_session < 1) ? 'd-none' : '';
            $z[] = d(input_frm(
                'mt-5',
                'Fecha de entrega',
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_contra_entrega',
                    "class" => "fecha_contra_entrega",
                    'id' => 'fecha_contra_entrega',
                    "type" => 'date',
                    "value" => date("Y-m-d"),
                    "min" => add_date(date("Y-m-d"), -15),
                    "max" => add_date(date("Y-m-d"), 30),
                ]
            ), _text_("col-lg-4", $extra_sorteo));


            $extra = ($in_session) ? 'col-lg-12 mt-5 ' : 'd-none col-lg-3 mt-5';

            $input_numero_cliente = input([
                "type" => "checkbox",
                "class" => "checkbox_enid check_numero_cliente",
            ]);


            $z[] = d(flex(
                "¿Registro con número de cliente?",
                $input_numero_cliente,
                "mt-5 text-uppercase black strong",
                "mr-3"
            ), _text_($extra, $extra_sorteo));



            $es_cliente_ext = ($es_cliente) ? 'd-none' : '';

            $z[] = d(_text_(
                span("¿No sabes el número de cliente?", 'black ml-3 border_black'),
                span('encuentralo aquí', 'strong busqueda_cliente_frecuente cursor_pointer')
            ), _text_('mt-3 col-lg-12', $es_cliente_ext));


            $z[] = input_frm(
                "col-lg-12 mt-5 d-none adicionales_adimistrador_numero_cliente",
                "#cliente",
                [
                    "id" => "input_numero_cliente",
                    "class" => "input_numero_cliente",
                    "type" => "float",
                    "name" => "numero_cliente",
                    "value" => 0,
                    "placeholder" => "¿Cual es el número de cliente?",

                ]
            );

            $input = input([
                "type" => "checkbox",
                "class" => "checkbox_enid check_prospecto",
            ]);

            $z[] = d(flex(
                "¿Registro con Facebook?",
                $input,
                "mt-5 text-uppercase black strong",
                "mr-3"
            ), _text_($extra, $extra_sorteo, 'label_registro_facebook'));

            $z[] = input_frm(
                "col-lg-9 mt-5 d-none seccion_input_facebook",
                "FACEBOOK",
                [
                    "id" => "facebook",
                    "class" => "facebook",
                    "type" => "url",
                    "name" => "facebook",
                    "placeholder" => "Aquí va el link del perfil del cliente",

                ]
            );


            $z[] = input_frm(
                "col-lg-12 mt-5 d-none adicionales_adimistrador",
                "URL conversación",
                [
                    "id" => "url_facebook_conversacion",
                    "class" => "url_facebook_conversacion",
                    "type" => "url",
                    "name" => "url_facebook_conversacion",
                    "placeholder" => "Aquí va el link de la conversación acordada",

                ]
            );

            $input = input([
                "type" => "checkbox",
                "class" => "checkbox_enid check_indico_ubicacion",
            ]);

            $extra = 'col-lg-12 mt-1 adicionales_adimistrador d-none';

            $z[] = d(flex(
                $input,
                "Indicó Ubicación",
                "mt-3 text-uppercase black strong",
                "mr-3"
            ), $extra);


            $input = input([
                "type" => "checkbox",
                "class" => "checkbox_enid check_vio_catalogo_web",
            ]);

            $z[] = d(flex(
                $input,
                "Vió catálogo web",
                "mt-3 text-uppercase black strong",
                "mr-3"
            ), $extra);


            $z[] = d("Comentarios", 'mt-5 col-lg-12 black text-uppercase  adicionales_adimistrador d-none');
            $z[] = d(textarea(
                [
                    "name" => "comentario_compra",
                    "class" => "comentario_compra",

                ]
            ), 'd-none mt-5 col-lg-12 adicionales_adimistrador');

            $inputs = [];


            $inputs[] = hiddens(
                [
                    "name" => "cobro_secundario",
                    "value" => $param["cobro_secundario"],
                    "class" => "cobro_secundario"
                ]
            );

            $inputs[] = hiddens(
                [
                    "name" => "adicionales",
                    "value" => es_administrador($data),
                    "class" => "adicionales"
                ]
            );

            $inputs[] = hiddens(
                [
                    "name" => "adicionales_cliente_frecuente",
                    "value" => es_administrador($data),
                    "class" => "adicionales_cliente_frecuente"
                ]
            );



            $inputs[] = hiddens(
                [
                    "name" => "es_prospecto",
                    "value" => 0,
                    "class" => "es_prospecto"
                ]
            );


            $inputs[] = hiddens(
                [
                    "name" => "lead_ubicacion",
                    "value" => 0,
                    "class" => "lead_ubicacion"
                ]
            );

            $inputs[] = hiddens(
                [
                    "name" => "lead_catalogo",
                    "value" => 0,
                    "class" => "lead_catalogo"
                ]
            );



            for ($a = 0; $a < count($producto_carro_compra); $a++) {

                $inputs[] = hiddens(
                    [
                        "name" => "producto_carro_compra[]",
                        "value" => $producto_carro_compra[$a],
                        "class" => "producto_carro_compra"
                    ]
                );
            }

            $z[] = append($inputs);

            $inputs = [];

            for ($a = 0; $a < count($recompensas); $a++) {

                $inputs[] = hiddens(
                    [
                        "name" => "recompensas[]",
                        "value" => $recompensas[$a],
                        "class" => "recompensas"
                    ]
                );
            }

            $z[] = append($inputs);



            $config_email = [
                "name" => "email",
                "placeholder" => "Pon aquí tu email",
                "class" => "email",
                "id" => "email",
                "type" => "email",
                "required" => "true",
                "onkeypress" => "minusculas(this);",
            ];
            

            $inicio = substr(sha1(mt_rand()), 1, 20);
            $fin = substr(sha1(mt_rand()), 1, 20);
            $config_email['value'] = _text($inicio, '@', $fin, '.com');
            
            $z[] = input_frm(
                _text_("col-lg-6 mt-5 top_100", "d-none"),
                "CORREO",
                $config_email,
                _text_correo
            );

            $config_password =
                [
                    "id" => "password_registro",
                    "class" => "input-sm password",
                    "type" => "hidden",
                    "required" => "true",
                    "placeholder" => "***",
                ];

            $config_password['value'] = sha1(mt_rand());

            $z[] = input_frm(
                _text_("col-lg-6 mt-5 d-none", $es_cliente_class),
                "PASSWORD",
                $config_password,
                _text_pass
            );


            $r[] = d($z, 13);
            $r[] = d("", 9);
            $r[] = d(btn("CONTINUAR", ['class' => 'submit_enid borde_green'], 0), "col-lg-3 mt-5 p-0 mb-5 accion_continuar_envio_pedido");
            $r[] = form_close();
        }

        $response[] = d($r, "primer_compra");
        $response[] = registrado();
        $response[] = modal_busqueda_cliente_frecuente();


        $seccion_compra[] = d(avance_compra(), "mb-5 mt-lg-5 col-xs-12");
        $seccion_compra[] = d($response, 8);
        $seccion_compra[] = d(llegada($data), 4);
        return d($seccion_compra, 13);
    }
    function avance_compra()
    {

        $clase_paso = "black white bg_black round mr-3 rounded-circle  pr-3 pl-3 pt-1 pb-2";
        $clase_paso_faltante = "black white bg_gray round mr-3 rounded-circle  pr-3 pl-3 pt-1 pb-2";

        $enid_service_titulo[] = d(
            "Enid service",
            "black strong black display-6 text-uppercase"
        );

        $paso[] = flex(
            "1",
            "CARRITO",
            "",
            $clase_paso,
            "mt-2 strong fp9"
        );

        $paso[] = flex(
            "2",
            "ENTREGA",
            "ml-4",
            $clase_paso,
            "mt-2 strong fp9"
        );

        $paso[] = flex(
            "3",
            "ENVIADO",
            "ml-4",
            $clase_paso_faltante,
            "mt-2 font-weight-bold color-secondary fp9"
        );



        $response[] = d($enid_service_titulo, "row mb-4");
        $response[] = d($paso, 'mb-3 row');

        $response[] = d("", "border-bottom border-secondary mb-5 row ");
        return d($response, 12);
    }
    function llegada($data)
    {

        if(!es_decoracion_tematica($data)){

            $response[] = _titulo(_text_("LLEGADA?", span("?", 'border p-2 bg-light')), 2);
            $contenidos[] = d("Tardaremos 2 hora con 30 si agendas tu pedido ya!", "black");
            $contenidos[] = d("Envío gratis", "strong mt-2");
            $response[] = d($contenidos, "borde_black p-3 mt-5");
            
        }
        
        $response[] = d(_titulo(_text_("OPCIONES DE PAGO", span("?", 'border p-2 bg-light')), 2), "mt-5");

        $formas_pago[] = d("Al recibir tu pedido podrás pagar con:", 'strong black');
        $formas_pago[] = d("Efectivo");
        $formas_pago[] = d("Transferencia");
        $formas_pago[] = d("Tarjeta de débito ó cŕedito");

        $response[] = d($formas_pago, "borde_black p-3 mt-5");

        return append($response);
    }

    function modal_busqueda_cliente_frecuente()
    {
        $contenido[] = d(_titulo('¿Número telefónico o email del cliente?', 4), 'borde_end_b ');

        $input_busqueda = input(['class' => "input_busqueda_cliente", "name" => "q", "onpaste" => "paste_search();"]);

        $form[] = form_open("", ["class" => "form_busqueda_cliente"]);
        $form[] = flex('Búsqueda:', $input_busqueda, _text_(_between, 'mt-5'));
        $form[] = form_close();
        $form[] = place("place_usuarios_coincidentes");
        $contenido[] = d($form, 'mt-2 f12 black');

        return gb_modal($contenido, 'modal_busqueda_cliente_frecuente');
    }


    function registrado()
    {
        return d(
            add_text(
                "tu usuario ya existe",
                format_link(
                    "inicia sessión",
                    [
                        'class' => "mt-5 ml-3  text-uppercase",
                        "href" => path_enid("login"),
                        'rm_class' => "d-block"

                    ]
                )
            ),

            'text-uppercase usuario_existente d-none strong text-center col-lg-12 h4'
        );
    }


    function frm_contacto_servicio($in_session, $servicio)
    {

        $servicio = $servicio[0];

        $hiddens[] = hiddens(
            [
                "id" => "id_servicio",
                "class" => "id_servicio  servicio",
                "name" => "id_servicio",
                "value" => $servicio["id_servicio"],
            ]
        );
        $hiddens[] = hiddens(
            [
                "class" => "id_ciclo_facturacion",
                "name" => "ciclo_facturacion",
                "value" => $servicio["id_ciclo_facturacion"],
            ]
        );
        $hiddens[] = hiddens(
            [
                "class" => "num_ciclos",
                "name" => "num_ciclos",
                "value" => 1,
            ]
        );

        $hiddens[] = hiddens(
            [
                "class" => "talla",
                "name" => "talla",
                "value" => "",
            ]
        );
        $hiddens[] = hiddens(
            [
                "class" => "tipo_entrega",
                "name" => "tipo_entrega",
                "value" => 2,
            ]
        );
        $hiddens[] = hiddens(
            [
                "class" => "id_carro_compras",
                "name" => "id_carro_compras",
                "value" => 0,
            ]
        );
        $hiddens[] = hiddens(
            [
                "class" => "carro_compras",
                "name" => "carro_compras",
                "value" => "",
            ]
        );


        if ($in_session < 1) {

            $x[] = form_open(
                "",
                [
                    "class" => "form_nuevo row"
                ]
            );
            $x[] = input_frm(
                "col-lg-6 mt-5",
                "Nombre",
                [
                    "id" => "nombre",
                    "name" => "nombre",
                    "type" => "text",
                    "placeholder" => "Quien solicita",
                    "class" => "nombre",
                    "minlength" => 3,
                    "required" => true,
                ]

            );

            $x[] = input_frm(
                "col-lg-6 mt-5",
                "Email",
                [
                    "name" => "email",
                    "placeholder" => "Ej. jonathan@enidservices.com",
                    "class" => "email",
                    "type" => "email",
                    "required" => "true",
                    "id" => "correo",
                ],
                _text_correo
            );

            $x[] = input_frm(
                "col-lg-6 mt-5",
                "Password",
                [
                    "name" => "password",
                    "placeholder" => "***",
                    "class" => "password",
                    "type" => "password",
                    "required" => true,
                    "id" => "password",
                ]
            );


            $x[] = input_frm(
                "col-lg-6 mt-5",
                "Teléfono",
                [
                    "name" => "telefono",
                    "placeholder" => "555296...",
                    "class" => "telefono",
                    "type" => "tel",
                    "required" => true,
                    "id" => "telefono",
                    "maxlength" => 10,
                    "minlength" => 8,
                ]
            );


            $x[] = input_frm(
                "col-lg-6 mt-5",
                "Fecha de interés",
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_servicio',
                    "class" => "fecha_servicio",
                    "type" => 'date',
                    "value" => date("Y-m-d"),
                    "min" => date("Y-m-d"),
                    "max" => add_date(date("Y-m-d"), 35),
                    "id" => "fecha_servicio",
                ]
            );


            $x[] = d("", 6);
            $x[] = d(
                "¿Deseas agregar algún comentario?",
                "col-lg-12 strong underline top_50 agregar_commentario cursor_pointer"
            );


            $r[] = append($x);
            $r[] = d(textarea(
                [
                    "name" => "comentarios",
                    "class" => "comentario",

                ]
            ), "col-lg-12 mt-3 d-none text_comentarios");


            $r[] = d("", 9);
            $r[] = d(btn("COTIZAR"), "col-lg-3 mt-5");
            $r[] = registrado();
            $r[] = place("place_config_usuario");
            $r[] = append($hiddens);
            $r[] = form_close();
        } else {

            $r[] = form_open(
                "",
                [
                    "class" => "form_cotizacion_enid_service"
                ]
            );
            $r[] = append($hiddens);
            $r[] = contaiter(h("PRESUPUESTO", 3, "strong"), 1);
            $texto_descriptivo_cotizacion = h(
                add_text("SOBRE: ", $servicio["nombre_servicio"]),
                4
            );
            $r[] = contaiter($texto_descriptivo_cotizacion, "mb-3");

            $r[] = contaiter(input_frm(
                "col-lg-12 p-0",
                "Fecha de interés",
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_servicio',
                    "class" => "fecha_servicio",
                    "type" => 'date',
                    "value" => date("Y-m-d"),
                    "min" => date("Y-m-d"),
                    "max" => add_date(date("Y-m-d"), 35),
                    "id" => "fecha_interes",
                ]
            ), "mt-5");

            $r[] = contaiter(d(
                "¿Deseas agregar algún comentario?",
                "strong text_agregar_comentario cursor_pointer"
            ), 'mt-5');
            $r[] = contaiter(textarea(
                [
                    "name" => "descripcion",
                    "class" => "d-none descripcion_comentario",
                ]
            ), 1);
            $r[] = contaiter(
                btn(
                    "ENVIAR",
                    [
                        "class" => "top_30 ",
                        "name" => "comentarios",
                    ],
                    0
                )
            );

            $r[] = form_close();
        }
        $r[] = format_load();

        return append($r);
    }

    function frm_miembro_enid_service_hidden(
        $q2,
        $plan,
        $num_ciclos,
        $ciclo_facturacion,
        $talla,
        $es_cliente,
        $es_carro_compras,
        $producto_carro_compra
    ) {


        $inputs = [];

        for ($a = 0; $a < count($producto_carro_compra); $a++) {

            $inputs[] = hiddens(
                [
                    "name" => "producto_carro_compra[]",
                    "value" => $producto_carro_compra[$a],
                    "class" => "producto_carro_compra"
                ]
            );
        }

        return append(
            [
                append($inputs),
                hiddens(
                    [
                        "name" => "es_carro_compras",
                        "value" => $es_carro_compras,
                        "class" => "es_carro_compras"
                    ]
                ),
                hiddens(
                    [
                        "name" => "usuario_referencia",
                        "value" => $q2,
                        "class" => 'q2',
                    ]
                ),
                hiddens(
                    [
                        "name" => "id_servicio",
                        "class" => "id_servicio",
                        "value" => $plan,
                    ]
                ),

                hiddens(
                    [
                        "name" => "num_ciclos",
                        "class" => "num_ciclos",
                        "value" => $num_ciclos,
                    ]
                ),
                hiddens(
                    [
                        "name" => "ciclo_facturacion",
                        "class" => "id_ciclo_facturacion",
                        "value" => $ciclo_facturacion,
                    ]
                ),
                hiddens(
                    [
                        "name" => "talla",
                        "class" => "talla",
                        "value" => $talla,
                    ]
                ),
                hiddens(
                    [
                        "class" => "fecha_servicio",
                        "name" => 'fecha_servicio',
                        "value" => date("Y-m-d"),
                    ]
                ),
                hiddens(
                    [
                        "name" => "es_cliente",
                        "class" => "es_cliente",
                        "value" => $es_cliente,
                    ]
                ),

            ]
        );
    }


    function duracion($id_ciclo_facturacion, $num_ciclos, $is_servicio)
    {

        $text = "";
        switch ($id_ciclo_facturacion) {
            case 1:

                $periodo = ($num_ciclos > 1) ? "Años" : "Año";
                $text = $num_ciclos . $periodo;
                break;

            case 2:

                $periodo = ($num_ciclos > 1) ? "Meses" : "Mes";
                $text = $num_ciclos . $periodo;

                break;

            case 5:
                $text = $num_ciclos . " ";
                if ($num_ciclos > 1) {
                    $text = $num_ciclos . "  ";
                }
                break;

            default:
                break;
        }

        return $text;
    }


    function desglose_servicio($servicio, $inf_ext)
    {

        $duracion = $inf_ext["num_ciclos"];
        $nombre_servicio = pr($servicio, "nombre_servicio");
        $id_ciclo_facturacion = pr($servicio, "id_ciclo_facturacion");
        $precio = pr($servicio, "precio");
        $text = ($inf_ext["is_servicio"] == 1) ? "DURACIÓN" : "PIEZAS";

        $r[] = ajustar(
            _titulo("ARTÍCULO"),
            d($nombre_servicio, "text-right"),
            4,
            "top_50"
        );
        $r[] = h($text . duracion(
            $id_ciclo_facturacion,
            $duracion,
            $inf_ext["is_servicio"]
        ), 5, "top_10 text-right strong");


        return [
            "resumen_producto" => append($r),
            "monto_total" => $precio,
            "resumen_servicio_info" => $nombre_servicio,
        ];
    }
    
}
