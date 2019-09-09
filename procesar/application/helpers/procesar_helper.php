<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_procesar_contacto')) {
        function render_procesar_contacto($data)
        {

            $in_session = $data["in_session"];
            $r[] = place("info_articulo", ["id" => 'info_articulo']);
            $z[] = d(str_title($in_session, $data["is_mobile"], 1), "top_100");
            $z[] = d(frm_contacto_servicio($in_session, $data["servicio"]), "bottom_100 top_50");
            $z[] = place("place_registro_afiliado");
            $r[] = d(d(append($z), "contenedo_compra_info"), "contenedor_compra");
            return addNRow(d(d(append($r), 6, 1), "bottom_100"));

        }
    }
    if (!function_exists('render_procesar')) {
        function render_procesar($data)
        {


            $servicio = $data["servicio"];
            $inf_ext = $data["info_solicitud_extra"];
            $costo_envio = $data["costo_envio"];
            $is_mobile = $data["is_mobile"];
            $q2 = $data["q2"];
            $in_session = $data["in_session"];
            $producto = desglose_servicio($servicio, $inf_ext);
            $monto_total = floatval(pr($servicio, "precio")) * floatval($inf_ext["num_ciclos"]);
            $costo_envio_cliente = 0;
            $text_envio = "";
            if (pr($servicio, "flag_servicio") < 1) {
                $costo_envio_cliente = $costo_envio["costo_envio_cliente"];
                $text_envio = $costo_envio["text_envio"]["cliente"];
            }

            $ext = $inf_ext;
            $talla = (array_key_exists("talla", $inf_ext)) ? $inf_ext["talla"] : 0;
            $r[] = n_row_12();
            $r[] = place("info_articulo", ["id" => 'info_articulo']);
            $z[] = format_resumen(
                $producto["resumen_producto"],
                $producto["resumen_servicio_info"],
                $monto_total,
                $costo_envio_cliente,
                ($monto_total + $costo_envio_cliente),
                $in_session
            );

            $z[] = str_title($in_session, $is_mobile);
            $z[] = form_open("", ["class" => "form-miembro-enid-service", "id" => "form-miembro-enid-service"]);
            $z[] = frm_miembro_enid_service_hidden(
                $q2,
                $ext["id_servicio"],
                $ext["num_ciclos"],
                $ext["ciclo_facturacion"],
                $talla,
                $data["carro_compras"],
                $data["id_carro_compras"]
            );
            $z[] = frm_primer_registro($in_session, $is_mobile, $ext);
            $z[] = place("place_registro_afiliado");

            $z[] = input_hidden(["value" => $data["email"], "class" => 'email_s']);
            $r[] = d(d(d(append($z), "contenedo_compra_info"), "contenedor_compra"), "col-lg-6 col-lg-offset-3 top_100");
            $r[] = end_row();
            return append($r);

        }

    }


    if (!function_exists('str_title')) {
        function str_title($in_session, $is_mobile, $es_servicio = 0)
        {
            //$text = ($in_session == 0 && $is_mobile == 0) ? h("DATOS DE COMPRA", 3) : "";
            $text = "";
            if ($es_servicio > 0) {
                $text = ($in_session == 0 && $is_mobile == 0) ?
                    h("¿QUIEN ERES?", 3, "top_30 bottom_30") : "";
            }

            return $text;
        }

    }

    if (!function_exists('frm_primer_registro')) {


        function frm_primer_registro($in_session, $is_mobile, $info_ext)
        {
            $r = [];
            if ($in_session < 1) {
                $r[]= h("DATOS DE COMPRA",3,"bottom_50  top_100 text_total");
                $a = ajustar(
                    d("Nombre", "strong")
                    ,
                    d(
                        input(
                            [
                                "name" => "nombre",
                                "placeholder" => "Nombre",
                                "class" => " input-sm  nombre",
                                "type" => "text",
                                "required" => "true"
                            ]
                        )
                    )
                    ,
                    3
                );

                $b = ajustar(

                            d("Correo", "strong")
                            ,
input(
                                    [
                                        "name" => "email",
                                        "placeholder" => "email",
                                        "class" => " input-sm  email",
                                        "type" => "email",
                                        "required" => "true",
                                        "onkeypress" => "minusculas(this);"
                                    ]

                                )
,3
                );


                $r[] = ajustar($a,$b,6);
                $r[] = place('place_correo_incorrecto');

                $a = ajustar(
                     d("password", "strong"),
                    input(
                        [
                            "id" => "password",
                            "class" => " input-sm password",
                            "type" => "password",
                            "required" => "true"
                        ])
                    ,4

                );


                $b =  ajustar(
                    d(text_icon('fa fa-phone', "Tel. "), "strong letter-spacing-5"),
                    input(
                        [
                            "id" => "telefono",
                            "class" => "telefono form-control",
                            "type" => "tel",
                            "pattern" => "^[0-9-+s()]*$",
                            "maxlength" => 13,
                            "minlength" => 8,
                            "name" => "telefono",
                            "required" => "true"
                        ]
                    ),4
                );

                $r[] =  ajustar($a, $b, 6);
                $r[] = ajustar("", btn("CONTINUAR",["class"=> "top_30"]),8);
                $r[] = d(
                    a_enid("TU USUARIO YA SE ENCUENTRA REGISTRADO",
                        [
                            'class' => "white",
                            "href" => path_enid("login")

                        ]),

                    "usuario_existente display_none  black_enid_background padding_1 white top_20 enid_hide"
                    ,
                    1);

                $r[] = text_acceder_cuenta($info_ext);
                $r[] = place("place_config_usuario");
                $r[] = form_close();
                $r[] = br(5);
            }

            return d(append($r), "pr_compra display_none top_100");
        }
    }

    if (!function_exists('frm_contacto_servicio')) {


        function frm_contacto_servicio($in_session, $servicio)
        {

            $servicio = $servicio[0];

            $r = [];
            if ($in_session < 1) {

                $r[] = form_open("", ["class" => "form-cotizacion-enid-service"]);


                $x[] =
                    d(
                        ajustar(
                            "Nombre ",
                            input(
                                [
                                    "name" => "nombre",
                                    "placeholder" => "Nombre",
                                    "class" => " input-sm  nombre",
                                    "type" => "text",
                                    "required" => "true"
                                ]
                            )


                        ));


                $x[] =
                    d(
                        ajustar(
                            "Email",
                            add_text(

                                d(
                                    input(
                                        [
                                            "name" => "email",
                                            "placeholder" => "email",
                                            "class" => " input-sm  email",
                                            "type" => "email",
                                            "required" => "true",
                                            "onkeypress" => "minusculas(this);"
                                        ]

                                    )
                                )
                                ,
                                d(
                                    place('place_correo_incorrecto')
                                )
                            )

                        ), "top_30");


                $x[] =
                    d(
                        ajustar(
                            text_icon('fa fa-unlock-alt', "Una contraseña"),
                            input(
                                [
                                    "id" => "password",
                                    "class" => " input-sm password",
                                    "type" => "password",
                                    "required" => "true",
                                    "placeholder" => "contraseña"
                                ]
                            )

                        )
                        ,
                        "top_30"
                    );


                $x[] = place("place_password_afiliado");


                $x[] =
                    d(
                        ajustar(
                            text_icon('fa fa-phone', "Teléfono "),
                            input([
                                "id" => "telefono",
                                "class" => "telefono form-control",
                                "type" => "tel",
                                "pattern" => "^[0-9-+s()]*$",
                                "maxlength" => 13,
                                "minlength" => 8,
                                "name" => "telefono",
                                "required" => "true",
                                "placeholder" => "55"

                            ])
                        )
                        ,
                        "top_30"
                    );


                $x[] =
                    d(
                        ajustar(
                            text_icon('fa-calendar', "En que fecha te interesa"),
                            input([
                                "data-date-format" => "yyyy-mm-dd",
                                "name" => 'fecha_servicio',
                                "class" => "form-control input-sm fecha_servicio",
                                "type" => 'date',
                                "value" => date("Y-m-d"),
                                "min" => date("Y-m-d"),
                                "max" => add_date(date("Y-m-d"), 35)
                            ])
                        )
                        ,
                        "top_30"
                    );


                $r[] = append($x);

                $r[] = input_hidden([
                    "id" => "id_servicio",
                    "class" => "id_servicio servicio form-control",
                    "name" => "id_servicio",
                    "value" => $servicio["id_servicio"]
                ]);
                $r[] = input_hidden([
                    "class" => "id_ciclo_facturacion",
                    "name" => "ciclo_facturacion",
                    "value" => $servicio["id_ciclo_facturacion"]
                ]);


                $r[] = d(textarea(
                    [
                        "name" => "comentarios",
                        "class" => "comentario"

                    ]), "top_30");

                $r[] = place("place_telefono");
                $r[] = btn("COTIZAR", ["class" => "top_30"]);
                $r[] = d(
                    a_enid("TU USUARIO YA SE ENCUENTRA REGISTRADO",
                        [
                            'class' => "white",
                            "href" => path_enid("login")

                        ]
                    ),
                    "usuario_existente display_none  black_enid_background padding_1 white top_20 enid_hide"
                    ,
                    1);
                $r[] = place("place_config_usuario");
                $r[] = form_close();

            } else {

                $r[] = form_open("", ["class" => "form_cotizacion_enid_service"]);
                $r[] = h("SOLICITAR COTIZACIÓN", 3, "top_80 text-center");
                $r[] = d(p(span("ME GUSTARÍA OPTENER UNA COTIZACIÓN SOBRE: ", "underline") . $servicio["nombre_servicio"]));

                $r[] =
                    d(
                        ajustar(
                            text_icon('fa-calendar', "En que fecha te interesa"),
                            input([
                                "data-date-format" => "yyyy-mm-dd",
                                "name" => 'fecha_servicio',
                                "class" => "form-control input-sm fecha_servicio",
                                "type" => 'date',
                                "value" => date("Y-m-d"),
                                "min" => date("Y-m-d"),
                                "max" => add_date(date("Y-m-d"), 35)
                            ])
                        )
                        ,
                        "top_30"
                    );


                $r[] = d(p(span("¿TIENES ALGUNA PREGUNTA ADICIONAL?")), "top_30");
                $r[] = textarea(["name" => "descripcion"]);

                $r[] = input_hidden(
                    [
                        "id" => "id_servicio",
                        "class" => "id_servicio  servicio form-control",
                        "name" => "id_servicio",
                        "value" => $servicio["id_servicio"]
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "num_ciclos",
                        "name" => "num_ciclos",
                        "value" => 1
                    ]);

                $r[] = input_hidden(
                    [
                        "class" => "id_ciclo_facturacion",
                        "name" => "ciclo_facturacion",
                        "value" => $servicio["id_ciclo_facturacion"]
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "talla",
                        "name" => "talla",
                        "value" => ""
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "tipo_entrega",
                        "name" => "tipo_entrega",
                        "value" => 2
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "id_carro_compras",
                        "name" => "id_carro_compras",
                        "value" => 0
                    ]);
                $r[] = input_hidden(
                    [
                        "class" => "carro_compras",
                        "name" => "carro_compras",
                        "value" => ""
                    ]);



                $r[] = btn("SOLICITAR COTIZACIÓN", ["class" => "top_30", "name" => "comentarios"], 1, 1, 1);
                $r[] = place("place_config_usuario");
                $r[] = form_close();

            }

            return append($r);


        }
    }

    if (!function_exists('format_resumen')) {

        function format_resumen($resumen,  $resumen_servicio_info, $monto_total, $costo_envio_cliente, $monto_total_con_envio, $in_session)
        {
            $r[] = h(
                text_icon("fa fa-shopping-bag", 'ORDEN')

                ,
                3,
                ' letter-spacing-5  bottom_30 text_total'
            );

            $r[] = $resumen;
            $r[] = input_hidden([
                "name" => "resumen_producto",
                "class" => "resumen_producto",
                "value" => $resumen_servicio_info
            ]);
            $x[] = h("MONTO " . $monto_total . "MXN", 5,"strong");
            $x[] = h("ENVÍO " . $costo_envio_cliente . "MXN", 5,"strong");
            $x[] = h("TOTAL " . $monto_total_con_envio . "MXN", 3, "text_total underline letter-spacing-15");
            $r[] = d(append($x), "text-right top_20");


            if ($in_session > 0) {
                $r[] = btn("ORDENAR COMPRA", ["class" => 'btn_procesar_pedido_cliente'], 1, 1);
                $r[] = place('place_proceso_compra');
            }

            if ($in_session < 1) {
                $r[] = d(d("", 6) . d(btn("CONTINUAR", ["class" => "continuar_pedido mt-3"]), 6), "row top_30");
            }
            $r[] = br(30);
            return d(append($r),"compra_resumen");

        }

    }
    if (!function_exists('frm_miembro_enid_service_hidden')) {

        function frm_miembro_enid_service_hidden($q2, $plan, $num_ciclos, $ciclo_facturacion, $talla, $carro_compras, $id_carro_compras)
        {


            return append([

                input_hidden([
                    "name" => "descripcion",
                    "value" => ""
                ]),
                input_hidden([
                    "name" => "usuario_referencia",
                    "value" => $q2,
                    "class" => 'q2'
                ]),
                input_hidden([
                    "name" => "plan",
                    "class" => "plan",
                    "value" => $plan
                ]),
                input_hidden([
                    "name" => "num_ciclos",
                    "class" => "num_ciclos",
                    "value" => $num_ciclos
                ]),
                input_hidden([
                    "name" => "ciclo_facturacion",
                    "class" => "ciclo_facturacion",
                    "value" => $ciclo_facturacion
                ]),
                input_hidden([
                    "name" => "talla",
                    "class" => "talla",
                    "value" => $talla
                ])
                ,
                input_hidden([
                    "name" => "carro_compras",
                    "class" => "carro_compras",
                    "value" => $carro_compras
                ])
                ,
                input_hidden([
                    "name" => "id_carro_compras",
                    "class" => "id_carro_compras",
                    "value" => $id_carro_compras
                ])


            ]);


        }
    }
    if (!function_exists('duracion')) {
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

    }
    if (!function_exists('desglose_servicio')) {
        function desglose_servicio($servicio, $inf_ext)
        {


            $duracion = $inf_ext["num_ciclos"];
            $nombre_servicio = pr($servicio, "nombre_servicio");
            $id_ciclo_facturacion = pr($servicio, "id_ciclo_facturacion");
            $precio = pr($servicio, "precio");
            $text = ($inf_ext["is_servicio"] == 1) ? "DURACIÓN" : "PIEZAS";

            $r[] = ajustar(d("ARTÍCULO", "f14") , d( $nombre_servicio, "text-right"), 4,"top_50");
            $r[] = h($text .   duracion($id_ciclo_facturacion, $duracion, $inf_ext["is_servicio"]) , 5 , "top_10 text-right strong");



            $response = [
                "resumen_producto" => append($r),
                "monto_total" => $precio,
                "resumen_servicio_info" => $nombre_servicio
            ];
            return $response;
        }
    }
    if (!function_exists('text_acceder_cuenta')) {
        function text_acceder_cuenta($param)
        {

            $ext =
                [
                    "plan" => $param["plan"],
                    "extension_dominio" => "",
                    "ciclo_facturacion" => $param["ciclo_facturacion"],
                    "is_servicio" => $param["is_servicio"],
                    "q2" => $param["q2"],
                    "num_ciclos" => $param["num_ciclos"],
                    "class" => "text-right link_acceso cursor_pointer  underline link_acceso cursor_pointer text_total  text-uppercase letter-spacing-5   mb-5 "
                ];


            $text[] = br(5);
            $text[] = h("¿Tienes una cuenta? ", 5 , $ext);

            return append($text);
        }
    }
}