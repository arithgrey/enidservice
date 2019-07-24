<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_procesar_contacto')) {
        function render_procesar_contacto($data)
        {

            $in_session = $data["in_session"];
            $is_mobile = $data["is_mobile"];
            $servicio = $data["servicio"];

            $r[] = place("info_articulo", ["id" => 'info_articulo']);
            $z[] = validate_text_title($in_session, $is_mobile, 1);
            $z[] = get_form_contacto_servicio($in_session, $servicio);
            $z[] = place("place_registro_afiliado");
            $r[] = d(d(append($z), "contenedo_compra_info"), "contenedor_compra");

            return addNRow(d(append($r), 6, 1));

        }
    }
    if (!function_exists('render_procesar')) {
        function render_procesar($data)
        {


            $servicio = $data["servicio"];
            $info_solicitud_extra = $data["info_solicitud_extra"];
            $costo_envio = $data["costo_envio"];
            $is_mobile = $data["is_mobile"];
            $carro_compras = $data["carro_compras"];
            $id_carro_compras = $data["id_carro_compras"];
            $email = $data["email"];
            $q2 = $data["q2"];
            $in_session = $data["in_session"];

            $producto = create_resumen_servicio($servicio, $info_solicitud_extra);
            $ciclos_solicitados = $info_solicitud_extra["num_ciclos"];
            $resumen_producto = $producto["resumen_producto"];
            $resumen_servicio_info = $producto["resumen_servicio_info"];
            $monto_total = floatval(pr($servicio, "precio")) * floatval($ciclos_solicitados);
            $costo_envio_cliente = 0;
            $text_envio = "";
            if (pr($servicio, "flag_servicio") < 1) {
                $costo_envio_cliente = $costo_envio["costo_envio_cliente"];
                $text_envio = $costo_envio["text_envio"]["cliente"];
            }
            $monto_total_con_envio = $monto_total + $costo_envio_cliente;

            $info_ext = $info_solicitud_extra;
            $plan = $info_ext["plan"];
            $num_ciclos = $info_ext["num_ciclos"];
            $ciclo_facturacion = $info_ext["ciclo_facturacion"];
            $talla = (array_key_exists("talla", $info_solicitud_extra)) ? $info_solicitud_extra["talla"] : 0;


            $r[] = n_row_12();
            $r[] = place("info_articulo", ["id" => 'info_articulo']);
            $z[] = get_format_resumen(
                $resumen_producto,
                $text_envio,
                $resumen_servicio_info,
                $monto_total,
                $costo_envio_cliente,
                $monto_total_con_envio,
                $in_session
            );
            $z[] = validate_text_title($in_session, $is_mobile);
            $z[] = form_open("", ["class" => "form-miembro-enid-service", "id" => "form-miembro-enid-service"]);
            $z[] = get_form_miembro_enid_service_hidden($q2, $plan, $num_ciclos, $ciclo_facturacion, $talla, $carro_compras, $id_carro_compras);
            $z[] = get_format_form_primer_registro($in_session, $is_mobile, $info_ext);
            $z[] = place("place_registro_afiliado");
            $z[] = hr();
            $z[] = input_hidden(["value" => $email, "class" => 'email_s']);
            $r[] = d(d(d(append($z), "contenedo_compra_info"), "contenedor_compra"), 6, 1);
            $r[] = end_row();
            return append($r);

        }

    }


    if (!function_exists('validate_text_title')) {
        function validate_text_title($in_session, $is_mobile, $es_servicio = 0)
        {
            $text = ($in_session == 0 && $is_mobile == 0) ? h("¿CON QUIEN NOS COMUNICAMOS?", 3) : "";
            if ($es_servicio > 0) {
                $text = ($in_session == 0 && $is_mobile == 0) ?
                    h("¿QUIEN ERES?", 4, "top_30 bottom_30") : "";
            }

            return $text;
        }

    }

    if (!function_exists('get_format_form_primer_registro')) {


        function get_format_form_primer_registro($in_session, $is_mobile, $info_ext)
        {


            $r = [];
            if ($in_session < 1) {

                $x[] = btw(
                    d("Nombre *")
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
                    6
                );

                $x[] = d(
                    append(
                        [

                            d("Correo Electrónico  *")
                            ,
                            d(
                                input(
                                    [
                                        "name" => "email",
                                        "placeholder" => "email",
                                        "class" => " input-sm  email",
                                        "type" => "email",
                                        "required" => "true",
                                        "onkeypress" => "minusculas(this);"
                                    ]))
                            ,
                            place('place_correo_incorrecto')

                        ]
                    ), 6
                );


                $r[] = d(append($x), 13);
                $r[] = d(text_icon('fa fa-unlock-alt', "Escribe una contraseña"));
                $r[] = input(
                    [
                        "id" => "password",
                        "class" => " input-sm password",
                        "type" => "password",
                        "required" => "true"
                    ]);

                $r[] = place("place_password_afiliado");
                $r[] = d(text_icon('fa fa-phone', "Teléfono *"));
                $r[] = input(
                    [
                        "id" => "telefono",
                        "class" => "telefono form-control",
                        "type" => "tel",
                        "pattern" => "^[0-9-+s()]*$",
                        "maxlength" => 13,
                        "minlength" => 8,
                        "name" => "telefono",
                        "required" => "true"
                    ]);
                $r[] = place("place_telefono");
                $r[] = btn("CREA UNA CUENTA");
                $r[] = d(
                    a_enid("TU USUARIO YA SE ENCUENTRA REGISTRADO",
                        [
                            'class' => "white",
                            "href" => path_enid("login")

                        ]),

                    "usuario_existente display_none  black_enid_background padding_1 white top_20 enid_hide"
                    ,
                    1);

                $r[] = get_text_acceder_cuenta($is_mobile, $info_ext);
                $r[] = "</div >";
                $r[] = "</div >";
                $r[] = place("place_config_usuario");
                $r[] = form_close();
            }

            return append($r);
        }
    }

    if (!function_exists('get_form_contacto_servicio')) {


        function get_form_contacto_servicio($in_session, $servicio)
        {

            $servicio = $servicio[0];

            $r = [];
            if ($in_session < 1) {

                $x[] = form_open("", ["class" => "form-cotizacion-enid-service"]);


                $x[] = d(
                    ajustar(
                        "Nombre *",
                        input(
                            [
                                "name" => "nombre",
                                "placeholder" => "Nombre",
                                "class" => " input-sm  nombre",
                                "type" => "text",
                                "required" => "true"
                            ]
                        )
                    ),6
                );

                $x[] = d(
                    ajustar(
                        "email*",
                        add_text(
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
                            ,
                            place('place_correo_incorrecto')

                        )
                    )
                    , 6
                );


                $r[] = d(append($x), 13);
                $r[] = d(icon('fa fa-unlock-alt') . "Escribe una contraseña", "top_20");
                $r[] = input([
                    "id" => "password",
                    "class" => " input-sm password",
                    "type" => "password",
                    "required" => "true"
                ]);
                $r[] = place("place_password_afiliado");
                $r[] = d(icon('fa fa-phone') . "Teléfono *", "top_20");
                $r[] = input([
                    "id" => "telefono",
                    "class" => "telefono form-control",
                    "type" => "tel",
                    "pattern" => "^[0-9-+s()]*$",
                    "maxlength" => 13,
                    "minlength" => 8,
                    "name" => "telefono",
                    "required" => "true"
                ]);
                $r[] = input_hidden([
                    "id" => "id_servicio",
                    "class" => "id_servicio form-control",
                    "name" => "id_servicio",
                    "value" => $servicio["id_servicio"]
                ]);
                $r[] = input_hidden([
                    "class" => "id_ciclo_facturacion",
                    "name" => "ciclo_facturacion",
                    "value" => $servicio["id_ciclo_facturacion"]
                ]);


                $r[] = d(textarea(["name" => "comentarios", "class" => "comentario"]), "top_30");
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

                $r[] = "</div >";
                $r[] = "</div >";
                $r[] = place("place_config_usuario");
                $r[] = form_close();

            } else {

                $r[] = form_open("", ["class" => "form_cotizacion_enid_service"]);
                $r[] = h("SOLICITAR COTIZACIÓN", 3, "top_80 text-center");
                $r[] = d(p(span("ME GUSTARÍA OPTENER UNA COTIZACIÓN SOBRE: ", "underline") . $servicio["nombre_servicio"]));
                $r[] = d(p(span("¿TIENES ALGUNA PREGUNTA ADICIONAL?")), "top_30");
                $r[] = textarea(["name" => "descripcion"]);
                $r[] = input_hidden(
                    [
                        "id" => "id_servicio",
                        "class" => "id_servicio form-control",
                        "name" => "plan",
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

                $r[] = input_hidden(
                    [
                        "class" => "servicio",
                        "name" => "servicio",
                        "value" => $servicio["id_servicio"]
                    ]);

                $r[] = btn("SOLICITAR COTIZACIÓN", ["class" => "top_30", "name" => "comentarios"], 1, 1, 1);
                $r[] = place("place_config_usuario");
                $r[] = form_close();

            }

            return append($r);


        }
    }

    if (!function_exists('get_format_resumen')) {

        function get_format_resumen($resumen_producto, $text_envio, $resumen_servicio_info, $monto_total, $costo_envio_cliente, $monto_total_con_envio, $in_session)
        {
            $r[] = d(
                h(
                    text_icon("fa fa-shopping-bag", 'RESUMEN DE TU PEDIDO')
                    ,
                    2,
                    ' letter-spacing-5'

                ), 1);

            $r[] = d($resumen_producto, "mt-3", 1);
            $r[] = d($text_envio, "mt-3", 1);
            $r[] = input_hidden([
                "name" => "resumen_producto",
                "class" => "resumen_producto",
                "value" => $resumen_servicio_info
            ]);

            $x[] = h("MONTO $" . $monto_total . "MXN", 4);
            $x[] = h("CARGOS DE ENVÍO $" . $costo_envio_cliente . "MXN", 4);
            $x[] = h("TOTAL $" . $monto_total_con_envio . "MXN", 3);
            $x[] = d("Precios expresados en Pesos Mexicanos.", "bottom_10");
            $r[] = d(append($x), "text-right top_20");
            if ($in_session > 0) {

                $r[] = btn("ORDENAR COMPRA", ["class" => 'btn_procesar_pedido_cliente'], 1, 1);
                $r[] = place('place_proceso_compra');

            }
            $r[] = hr();
            return append($r);
        }

    }
    if (!function_exists('get_form_miembro_enid_service_hidden')) {

        function get_form_miembro_enid_service_hidden($q2, $plan, $num_ciclos, $ciclo_facturacion, $talla, $carro_compras, $id_carro_compras)
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
    if (!function_exists('get_text_duracion')) {
        function get_text_duracion($id_ciclo_facturacion, $num_ciclos, $is_servicio)
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
    if (!function_exists('create_resumen_servicio')) {
        function create_resumen_servicio($servicio, $info_solicitud_extra)
        {


            $resumen_servicio = "";
            $duracion = $info_solicitud_extra["num_ciclos"];
            $info_servicio = "";
            $id_ciclo_facturacion = "";
            $precio = 0;

            foreach ($servicio as $row) {

                $nombre_servicio = $row["nombre_servicio"];
                $info_servicio = $nombre_servicio;
                $resumen_servicio = $nombre_servicio;
                $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
                $precio = $row["precio"];
            }

            $is_servicio = 0;
            $text_label = "PIEZAS";
            if ($info_solicitud_extra["is_servicio"] == 1) {
                $text_label = "DURACIÓN";
                $is_servicio = 1;
            }
            $text_ciclos_contratados = get_text_duracion($id_ciclo_facturacion, $duracion, $is_servicio);
            $base = 'col-lg-4 tex-center';


            $r[] = d(d("PRODUCTO") . $resumen_servicio, $base);
            $r[] = d($text_label . " " . $text_ciclos_contratados, $base);
            $r[] = d(d("PRECIO") . $precio, 'col-lg-4');


            $response = [
                "resumen_producto" => append($r),
                "monto_total" => $precio,
                "resumen_servicio_info" => $info_servicio
            ];
            return $response;
        }
    }
    if (!function_exists('get_text_acceder_cuenta')) {
        function get_text_acceder_cuenta($is_mobile, $param)
        {

            $extra =
                [
                    "plan" => $param["plan"],
                    "extension_dominio" => "",
                    "ciclo_facturacion" => $param["ciclo_facturacion"],
                    "is_servicio" => $param["is_servicio"],
                    "q2" => $param["q2"],
                    "num_ciclos" => $param["num_ciclos"],
                    "class" => "link_acceso cursor_pointer    white  padding_10 link_acceso cursor_pointer text-center col-lg-4 col-lg-offset-4 text-center text-uppercase letter-spacing-10  top_30 mb-5 white bg_black"
                ];


            $text[] = h("¿Ya tienes una cuenta? ", 3, " text_usuario_registrado_pregunta text-center text-uppercase letter-spacing-10");
            $text[] = d("ACCEDE AHORA!", $extra, 1);
            return append($text);
        }
    }
}