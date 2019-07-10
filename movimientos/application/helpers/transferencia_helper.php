<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('render_metodos_disponibles')) {

        function render_metodos_disponibles($data)
        {


            $usuario = $data["usuario"];
            $banca = $data["banca"];
            $bancos = $data["bancos"];
            $error = $data["error"];
            $seleccion = $data["seleccion"];


            $nombre = primer_elemento($usuario, "nombre");
            $apellido_paterno = primer_elemento($usuario, "apellido_paterno");
            $apellido_materno = primer_elemento($usuario, "apellido_materno");
            $nombre_persona = $nombre . " " . $apellido_paterno . " " . $apellido_materno;
            $text_tipo_ingreso = ($banca == 0) ? "ASOCIAR CUENTA BANCARIA" : "ASOCIAR TARJETA DE DÉDITO O CRÉDITO";

            $x[] = heading($text_tipo_ingreso, 3);
            $x[] = div("Enid Service protege y garantiza la seguridad de la información de su cuenta bancaria. Nunca revelaremos su información financiera y, cada vez que inicie una transacción con esta cuenta bancaria, Enid Service se lo notificará por correo electrónico.");
            $x[] = form_asociar_cuenta($error, $nombre_persona, $bancos, $banca);

            $response = [];
            if ($seleccion < 1) {

                $response[] = div(append($x), ["class" => "col-lg-4 col-lg-offset-4", "style" => "background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;"]);
            } else {

                $response[] = div(get_format_asociar_cuenta_bancaria(), "col-lg-4 col-lg-offset-4 contenedor_asociar_cuenta");
            }

            return div(append($response), "contenedor_asociar_cuenta");
        }
    }

    if (!function_exists('form_asociar_cuenta')) {

        function form_asociar_cuenta($error, $nombre_persona, $bancos, $banca)
        {


            if ($error == 1):
                $r[] = div(
                    "SE PRESENTARON ERRORES AL ASOCIAR CUENTA, VERIFIQUE SU INFORMACIÓN ENVIADA",
                    ["style" => "background: #004bff; color: white;padding: 5px;"]);
            endif;
            $r[] = div(heading($nombre_persona, 4), ["style" => "border-bottom-style: solid;border-width: 1px;"]);
            $r[] = heading("1.- PAÍS", 4);
            $r[] = create_select(array(
                "text" => "México",
                "v" => 1
            ), "pais", "form-control", "pais", "text", "v");
            $r[] = heading("2.- SELECCIONA TU BANCO", 4);
            $r[] = create_select(
                $bancos,
                "banco",
                "banco_cuenta",
                "sel1",
                "nombre",
                "id_banco",
                1);

            if ($banca == 0):

                $r[] = heading("3.-NÚMERO CLABE(18 dígitos)", 4);
                $r[] = input([
                    "class" => "form-control numero_tarjeta",
                    "id" => "input-1",
                    "name" => "clabe",
                    "placeholder" => "Número clabe de tu banco",
                    "required" => true,
                    "maxlength" => "18",
                    "minlength" => "18"
                ]);

            else:
                $r[] = heading("4.- TIPO DE TARJETA ", 4);

                $opt = array(
                    "text" => "Débito",
                    "v" => 0
                );
                $opt = array(
                    "text" => "Crédito",
                    "v" => 1
                );;
                $r[] = create_select($opt, "tipo_tarjeta", "form-control", "tipo_tarjeta", "text", "v");
                $r[] = heading("5.- NÚMERO DE TARJETA " . icon("fa fa-credit-card-alt"), 4);
                $r[] = input([
                    "class" => "form-control numero_tarjeta",
                    "id" => "input-1",
                    "name" => "numero_tarjeta",
                    "placeholder" => "Número de tarjeta",
                    "required" => true,
                    "minlength" => "16",
                    "maxlength" => "16"
                ]);

            endif;
            $r[] = input_hidden(["name" => "tipo", "value" => $banca]);
            $r[] = guardar("ASOCIAR" . icon("fa fa-chevron-right"));
            $r[] = div(
                p(
                    "Al asociar tu cuenta, podrás transferir tu saldo de Enid Service a tu cuenta personal", "white"
                )
                ,
                ["style" => "margin-top: 35px;background: #213668;padding: 10px;"]
            );

            $response[] = form_open("", ["class" => "form_asociar_cuenta", "method" => "POST", "action" => "?action=4"]);
            $response[] = div(div(append($r), "page-header"));
            $response[] = form_close();
            return append($response);


        }
    }

    if (!function_exists('render_empresas')) {

        function render_empresas($data)
        {

            $saldo_disponible = $data["saldo_disponible"];
            $r[] = btw(
                get_format_saldo_disponible($saldo_disponible),
                div(get_submenu(), "card"),
                3

            );
            $r[] = div(place("place_movimientos"), 9);
            return append($r);
        }
    }

    if (!function_exists('render_cuentas_asociadas')) {

        function render_cuentas_asociadas($data)
        {

            $cuentas_bancarias = $data["cuentas_bancarias"];
            $tarjetas = $data["tarjetas"];

            $r[] = heading_enid("TUS CUENTAS " . br() . " CUENTAS BANCARIAS", 3);
            foreach ($cuentas_bancarias as $row):
                $r[] = div(
                    append(
                        [
                            $row["nombre"],
                            icon("fa fa-credit-card "),
                            div(get_resumen_cuenta($row["clabe"]))
                        ]
                    )
                    ,
                    "info_cuenta top_10"
                );

            endforeach;
            $r[] = guardar(
                "Agregar cuenta " . icon("fa fa-plus-circle ")
                ,
                [
                    "class" => "top_20"
                ]
                ,

                1
                ,
                1
                ,
                0
                ,
                "?q=transfer&action=1"
            );

            $r[] = heading_enid("TARJETAS DE CRÉDITO Y DÉBITO", 3);
            foreach ($tarjetas as $row):
                $r[] = div(append([
                    $row["nombre"],
                    icon("fa fa-credit-card "),
                    div(substr($row["numero_tarjeta"], 0, 4) . "********")

                ]), ["class" => "info_cuenta"]);
            endforeach;
            $r[] = guardar(
                "Agregar cuenta " . icon("fa fa-plus-circle ")
                ,
                [
                    "class" => "top_20"
                ]
                ,
                1
                ,
                1
                ,
                0
                ,
                "?q=transfer&action=1&tarjeta=1"
            );

            return append($r);

        }
    }

    if (!function_exists('get_format_asociar_cuenta_bancaria')) {

        function get_format_asociar_cuenta_bancaria()
        {

            $r[] = heading("ASOCIAR CUENTA BANCARIA Ó TARJETA DE CRÉDITO O DÉBITO", 3);
            $r[] = anchor_enid(
                div("Asociar  tarjeta de crédito o débito",

                    [
                        "class" => "asociar_cuenta_bancaria",
                        "style" => "border-style: solid;border-width: .9px;padding: 10px;margin-top: 50px;"
                    ]
                ),
                ["href" => "?q=transfer&action=1&tarjeta=1", "class" => "black"]);

            $r[] = anchor_enid(div("Asociar cuenta bancaria",
                [
                    "style" => "border-style: solid;border-width: .9px;padding: 10px;
	                            margin-top: 10px;color: white!important!important",
                    "class" => "a_enid_blue asociar_tarjeta"
                ]),
                [
                    "href" => "?q=transfer&action=1",
                    "class" => "white",
                    "style" => "color: white!important"
                ]);

            return append($r);

        }

    }
    if (!function_exists('get_format_cuentas_existentes')) {

        function get_format_cuentas_existentes($cuentas_gravadas)
        {
            return div(anchor_enid(agrega_cuentas_existencia($cuentas_gravadas),
                [
                    "href" => "?q=transfer&action=1&seleccion=1",
                    "class" => "white",
                    "style" => "color: white!important;background:#004faa;padding: 3px;"
                ]),
                [
                    "style" => "width: 80%;margin: 0 auto;margin-top: 20px;"
                ]);

        }

    }
    if (!function_exists('get_format_fondos')) {
        function get_format_fondos($saldo_disponible)
        {

            $response = div(
                div("AUN NO CUENTAS CON FONDOS EN TU CUENTA",
                    [
                        "style" => "border-radius:20px;background: black;padding:10px;color: white;"
                    ]),
                [
                    "style" => "width: 80%;margin: 0 auto;margin-top: 20px;"
                ]);


            if ($saldo_disponible > 100) {

                $response = div(div(text_icon("fa fa-chevron-right", "CONTINUAR "),
                    [
                        "class" => "btn_transfer",
                        "style" => "border-radius: 20px;background: black;padding: 10px;color: white;"
                    ]),
                    [
                        "style" => "width: 80%;margin: 0 auto;margin-top: 20px;"
                    ]);


            }
            return $response;


        }

    }
    if (!function_exists('get_format_saldo_disponible')) {
        function get_format_saldo_disponible($saldo_disponible)
        {

            $response = ul(
                [
                    div(icon('icon fa fa-money'), "icon"),
                    div("Saldo disponible"),
                    heading_enid("$" . number_format(get_data_saldo($saldo_disponible), 2) . "MXN", 2, "value white"),
                    div("Monto expresado en Pesos Mexicanos")
                ]
            );
            return div($response, "panel income db mbm");

        }
    }
    if (!function_exists('render_agregar_saldo_cuenta')) {
        function render_agregar_saldo_cuenta()
        {

            $r[] = heading_enid("AÑADE SALDO A TU CUENTA DE ENID SERVICE AL REALIZAR ", 3);
            $r[] = get_format_pago_efectivo();
            $r[] = get_format_solicitud_amigo();
            return div(append($r), 4, 1);

        }
    }
    if (!function_exists('render_agregar_saldo_oxoo')) {
        function render_agregar_saldo_oxoo($data)
        {
            $id_usuario = $data["id_usuario"];
            return btw(
                heading_enid("AÑADE SALDO A TU CUENTA DE ENID SERVICE AL REALIZAR DEPÓSITO DESDE CUALQUIER SUCURSAL OXXO", 3),
                get_form_pago_oxxo($id_usuario),
                4, 1

            );

        }
    }


    if (!function_exists('get_format_solicitud_amigo')) {
        function get_format_solicitud_amigo()
        {

            return anchor_enid(btw(

                div("SOLICITA SALDO A UN AMIGO",

                    "tipo_pago underline"

                    ,
                    1
                ),

                div(
                    "Pide a un amigo que te transfira saldo desde su cuenta",
                    [
                        "style" => "text-decoration: underline;",
                        "class" => "tipo_pago_descripcion"
                    ]
                    ,
                    1),

                "option_ingresar_saldo"

            ), [
                "href" => "?q=transfer&action=9"
            ]);

        }
    }
    if (!function_exists('get_format_pago_efectivo')) {

        function get_format_pago_efectivo()
        {

            return anchor_enid(btw(

                div("UN PAGO EN EFECTIVO EN OXXO ",
                    [
                        "class" => "tipo_pago",
                        "style" => "text-decoration: underline;color: black"
                    ],
                    1),

                div(
                    "Depositas 
						saldo a tu cuenta de Enid service desde  cualquier sucursal de oxxo ",
                    ["class" => "tipo_pago_descripcion"],
                    1),

                "option_ingresar_saldo tipo_pago"

            ), [
                    "href" => "?q=transfer&action=7"
                ]
            );


        }

    }
    if (!function_exists('get_form_pago_oxxo')) {
        function get_form_pago_oxxo($id_usuario)
        {

            $r[] = '<form method="GET" action="../orden_pago_oxxo">';
            $r[] = append([
                input_hidden(["name" => "q2", "value" => $id_usuario]),
                input_hidden(["name" => "concepto", "value" => "1"]),
                input_hidden(["name" => "q3", "value" => $id_usuario])
            ]);

            $r[] = btw(

                input([
                    "type" => "number",
                    "name" => "q",
                    "class" => "form-control input-sm input monto_a_ingresar",
                    "required" => true
                ])
                ,
                heading_enid("MXN", 2)
                ,
                "contenedor_form display_flex_enid"

            );
            $r[] = div("¿MONTO QUÉ DESEAS INGRESAR A TU SALDO ENID SERVICE?",
                [
                    "colspan" => "2",
                    "class" => "underline"
                ]
            );
            $r[] = br();
            $r[] = guardar("Generar órden");
            $r[] = form_close();
            return append($r);

        }

    }


    if (!function_exists('get_resumen_cuenta')) {
        function get_resumen_cuenta($text)
        {
            return substr($text, 0, 4) . "********";
        }
    }
    if (!function_exists('agrega_cuentas_existencia')) {
        function agrega_cuentas_existencia($flag_cuentas)
        {
            $text = ($flag_cuentas == 0) ? "Asociar nueva cuenta" : "Asociar otra cuenta";
            return $text;
        }
    }
    if (!function_exists('valida_siguiente_paso_cuenta_existente')) {
        function valida_siguiente_paso_cuenta_existente($flag_cuentas_registradas)
        {
            $text = ($flag_cuentas_registradas == 0) ? "readonly" : "";
            return $text;
        }

    }
    if (!function_exists('despliega_cuentas_registradas')) {
        function despliega_cuentas_registradas($cuentas)
        {
            $option = "";
            foreach ($cuentas as $row) {

                $id_cuenta_pago = $row["id_cuenta_pago"];
                $numero_tarjeta = $row["numero_tarjeta"];
                $nuevo_numero_tarjeta = substr($numero_tarjeta, 0, 4);
                $nombre = "Cuenta - " . $row["nombre"] . " " . $nuevo_numero_tarjeta . "************";
                $option .= add_option_select($nombre, $id_cuenta_pago);
            }
            return $option;
        }
    }
    if (!function_exists('add_option_select')) {
        function add_option_select($text, $value)
        {
            return "<option value='" . $value . "'>" . $text . "</option>";
        }
    }

    if (!function_exists('get_data_saldo')) {
        function get_data_saldo($saldo)
        {

            $text = (get_param_def($saldo, "saldo") > 0) ? $saldo["saldo"] : 0;
            return $text;
        }
    }

    if (!function_exists('get_submenu')) {
        function get_submenu()
        {

            $list = [
                li(anchor_enid("Añadir ó solicitar saldo", ["href" => "?q=transfer&action=6", "class" => "black"]), ["class" => "list-group-item"]),
                li(anchor_enid("Trasnferir fondos " . icon("fa fa-fighter-jet"), ["href" => "?q=transfer&action=2", "class" => "black"]), ["class" => "list-group-item"]),
                li(anchor_enid("Mis tarjetas y cuentas", ["href" => "?q=transfer&action=3", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"]),
                li(anchor_enid("Asociar cuenta bancaria", ["href" => "?q=transfer&action=1", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"]),
                li(anchor_enid("Asociar tarjeta de crédito o débito" . icon("fa fa-credit-card-alt"), ["href" => "?q=transfer&action=1&tarjeta=1", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"])

            ];

            return ul($list, "list-group list-group-flush");
        }
    }

}