<?php if (!defined('BASEPATH')) {
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

        $servicio = $data["servicio"];
        $inf_ext = $data["info_solicitud_extra"];
        $es_carro_compras = $inf_ext["es_carro_compras"];
        $producto_carro_compra = $inf_ext["producto_carro_compra"];

        $costo_envio = $data["costo_envio"];
        $is_mobile = $data["is_mobile"];
        $q2 = $data["q2"];
        $in_session = $data["in_session"];
        $es_cliente = ($data['id_perfil'] == 20) ? 1 : 0;
        $es_cliente = ($in_session) ? $es_cliente : 1;

        $producto = desglose_servicio($servicio, $inf_ext);
        $precio = pr($servicio, "precio");
        $monto_total = floatval($precio) * floatval($inf_ext["num_ciclos"]);
        $flag_servicio = pr($servicio, "flag_servicio");
        $costo_envio_cliente = ($flag_servicio < 1 && !$es_carro_compras) ? $costo_envio["costo_envio_cliente"] : 0;

        $ext = $inf_ext;
        $ext["q2"] = $q2;
        $talla = (array_key_exists("talla", $inf_ext)) ? $inf_ext["talla"] : 0;

        $r[] = place("info_articulo", ["id" => 'info_articulo']);
        $total_con_costo_envio = ($monto_total + $costo_envio_cliente);


        $z[] = format_resumen(
            $producto["resumen_producto"],
            $producto["resumen_servicio_info"],
            $monto_total,
            $costo_envio_cliente,
            $total_con_costo_envio,
            $in_session,
            $es_cliente
        );

        $z[] = str_title($in_session, $is_mobile);
        $z[] = form_open("",
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
        $z[] = frm_primer_registro($in_session, $ext, $es_cliente);
        $z[] = hiddens(
            [
                "value" => $data["email"],
                "class" => 'email_s'
            ]
        );
        $r[] = d(d(d($z, "contenedo_compra_info"), "contenedor_compra"),
            "col-lg-8 col-lg-offset-2 top_100 bottom_100");

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


    function frm_primer_registro($in_session, $param, $es_cliente)
    {

        $es_cliente_class = ($es_cliente) ? '' : 'd-none';
        $r = [];
        if ($in_session < 1 || !$es_cliente) {

            $producto_carro_compra = $param["producto_carro_compra"];
            $titulo = ($es_cliente) ? "¿Quién recibe?" : 'Datos del cliente';
            $r[] = d(_titulo($titulo), 'mb-5');
            $z[] = input_frm(
                "col-lg-6 mt-5", "NOMBRE",
                [
                    "name" => "nombre",
                    "id" => "nombre",
                    "placeholder" => "Ej. Jonathan",
                    "class" => "nombre",
                    "type" => "text",
                    "required" => "true",
                    'onkeyup' => "this.value = this.value.toUpperCase();"
                ],
                _text_nombre
            );

            $z[] = input_frm("col-lg-6 mt-5", "TELÉFONO",
                [
                    "id" => "telefono",
                    "class" => "telefono",
                    "type" => "tel",
                    "maxlength" => 10,
                    "minlength" => 8,
                    "name" => "telefono",
                    "required" => "true",
                    "placeholder" => "555296...",

                ], _text_telefono
            );

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

            $z[] = append($inputs);
            if (!$in_session) {

                $z[] = d('Crea una cuenta para realizar tu compra', 'mt-5 text-uppercase black text- col-sm-12 h4');
            }


            $config_email = [
                "name" => "email",
                "placeholder" => "ej. jonathan@enidservices.com",
                "class" => "email",
                "id" => "email",
                "type" => "email",
                "required" => "true",
                "onkeypress" => "minusculas(this);",
            ];
            if (!$es_cliente) {

                $config_email['value'] = _text(sha1(mt_rand()), '@', 'enidservices.com');
            }

            $z[] = input_frm(
                _text_("col-lg-6 mt-5", $es_cliente_class),
                "CORREO",
                $config_email, _text_correo
            );

            $config_password =
                [
                    "id" => "password_registro",
                    "class" => "input-sm password",
                    "type" => "password",
                    "required" => "true",
                    "placeholder" => "***",
                ];
            if (!$es_cliente) {
                $config_password['value'] = sha1(mt_rand());
            }
            $z[] = input_frm(_text_("col-lg-6 mt-5", $es_cliente_class), "PASSWORD",
                $config_password, _text_pass);


            $r[] = d($z, 13);
            $r[] = d("", 9);
            $r[] = d(btn("CONTINUAR", ['class' => 'submit_enid'], 0), "col-lg-3 mt-5 p-0 mb-5");
            $r[] = text_acceder_cuenta($param, $es_cliente);
            $r[] = form_close();

        }

        $response[] = d($r, "primer_compra");
        $response[] = registrado();
        return append($response);
    }


    function registrado()
    {
        return d(
            add_text("tu usuario ya existe",
                format_link("inicia sessión",
                    [
                        'class' => "mt-5 ml-3  text-uppercase",
                        "href" => path_enid("login"),
                        'rm_class' => "d-block"

                    ]
                )
            ),

            'text-uppercase usuario_existente d-none strong text-center col-lg-12 h4');

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

            $x[] = form_open("",
                [
                    "class" => "form_nuevo row"
                ]
            );
            $x[] = input_frm("col-lg-6 mt-5",
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

            $x[] = input_frm("col-lg-6 mt-5", "Email",
                [
                    "name" => "email",
                    "placeholder" => "Ej. jonathan@enidservices.com",
                    "class" => "email",
                    "type" => "email",
                    "required" => "true",
                    "id" => "correo",
                ], _text_correo
            );

            $x[] = input_frm("col-lg-6 mt-5", "Password",
                [
                    "name" => "password",
                    "placeholder" => "***",
                    "class" => "password",
                    "type" => "password",
                    "required" => true,
                    "id" => "password",
                ]
            );


            $x[] = input_frm("col-lg-6 mt-5", "Teléfono",
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


            $x[] = input_frm("col-lg-6 mt-5", "Fecha de interés",
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
            $x[] = d("¿Deseas agregar algún comentario?",
                "col-lg-12 strong underline top_50 agregar_commentario cursor_pointer");


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

            $r[] = form_open("",
                [
                    "class" => "form_cotizacion_enid_service"
                ]
            );
            $r[] = append($hiddens);
            $r[] = contaiter(h("PRESUPUESTO", 3, "strong"), 1);
            $texto_descriptivo_cotizacion = h(
                add_text("SOBRE: ", $servicio["nombre_servicio"]), 4);
            $r[] = contaiter($texto_descriptivo_cotizacion, "mb-3");

            $r[] = contaiter(input_frm("col-lg-12 p-0", "Fecha de interés",
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_servicio',
                    "class" => "fecha_servicio",
                    "type" => 'date',
                    "value" => date("Y-m-d"),
                    "min" => date("Y-m-d"),
                    "max" => add_date(date("Y-m-d"), 35),
                    "id" => "fecha_interes",
                ]), "mt-5");

            $r[] = contaiter(d("¿Deseas agregar algún comentario?",
                "strong text_agregar_comentario cursor_pointer"), 'mt-5');
            $r[] = contaiter(textarea(
                [
                    "name" => "descripcion",
                    "class" => "d-none descripcion_comentario",
                ]), 1);
            $r[] = contaiter(
                btn(
                    "ENVIAR",
                    [
                        "class" => "top_30 ",
                        "name" => "comentarios",
                    ], 0
                )
            );

            $r[] = form_close();

        }
        $r[] = format_load();

        return append($r);


    }


    function format_resumen(
        $resumen,
        $resumen_servicio_info,
        $monto_total,
        $costo_envio_cliente,
        $monto_total_con_envio,
        $in_session,
        $es_cliente
    )
    {

        $r = [];
        if ($in_session > 0 && $es_cliente) {
            $r[] = $resumen;
            $r[] = hiddens(
                [
                    "name" => "resumen_producto",
                    "class" => "resumen_producto",
                    "value" => $resumen_servicio_info,
                ]
            );
            $x[] = h("MONTO " . money($monto_total), 5, "strong");
            $x[] = h("ENVÍO " . money($costo_envio_cliente), 5, "strong");
            $x[] = h("TOTAL " . money($monto_total_con_envio), 3,
                "text_total underline letter-spacing-15");
            $r[] = d($x, "text-right mt-5");

            $r[] = d(btn("ORDENAR COMPRA",
                [
                    "class" => 'btn_procesar_pedido_cliente',
                ]
            ), 'col-sm-4 row pull-right');
            $r[] = place('place_proceso_compra mt-5');
        }


        return d($r, "compra_resumen");

    }


    function frm_miembro_enid_service_hidden(
        $q2,
        $plan,
        $num_ciclos,
        $ciclo_facturacion,
        $talla,
        $es_cliente,
        $es_carro_compras,
        $producto_carro_compra)
    {


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
                append($inputs)
                ,
                hiddens(
                    [
                        "name" => "es_carro_compras",
                        "value" => $es_carro_compras,
                        "class" => "es_carro_compras"
                    ]
                ),

                hiddens(
                    [
                        "name" => "descripcion",
                        "value" => "",
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

        $r[] = ajustar(_titulo("ARTÍCULO"), d($nombre_servicio, "text-right"), 4,
            "top_50");
        $r[] = h($text . duracion($id_ciclo_facturacion, $duracion,
                $inf_ext["is_servicio"]), 5, "top_10 text-right strong");


        return [
            "resumen_producto" => append($r),
            "monto_total" => $precio,
            "resumen_servicio_info" => $nombre_servicio,
        ];

    }
    function text_acceder_cuenta($param, $es_cliente)
    {

        $response = [];
        if ($es_cliente) {

            $ext =
                [
                    "id_servicio" => $param["is_servicio"],
                    "ciclo_facturacion" => $param["ciclo_facturacion"],
                    "q2" => $param["q2"],
                    "class" => "text-right link_acceso cursor_pointer
                      strong link_acceso cursor_pointer text_total text-uppercase letter-spacing-5 mb-5 ",
                ];


            $text[] = h("¿Tienes una cuenta? ", 5, $ext);

            $response[] = d($text, 12);
        }
        return append($response);

    }
}
