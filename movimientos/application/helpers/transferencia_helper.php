<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('render_metodos_disponibles')) {

        function render_metodos_disponibles($data)
        {

            $usuario = $data["usuario"];
            $banca = $data["banca"];
            $nombre = pr($usuario, "nombre") . " " . pr($usuario, "apellido_paterno") . " " . pr($usuario, "apellido_materno");

            $x[] = h(($banca == 0) ? "ASOCIAR CUENTA BANCARIA" : "ASOCIAR TARJETA DE DÉDITO O CRÉDITO", 3);
            $x[] = d("Enid Service protege y garantiza la seguridad de la información de su cuenta bancaria. Nunca revelaremos su información financiera y, cada vez que inicie una transacción con esta cuenta bancaria, Enid Service se lo notificará por correo electrónico.");
            $x[] = form_asociar_cuenta($data["error"], $nombre, $data["bancos"], $banca);

            $response = [];
            if ($data["seleccion"] < 1) {

                $response[] = d(append($x), ["class" => "col-lg-4 col-lg-offset-4", "style" => "background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;"]);
            } else {

                $response[] = d(asociar_cuenta_bancaria(), "col-lg-4 col-lg-offset-4 contenedor_asociar_cuenta");
            }

            return d(append($response), "contenedor_asociar_cuenta");
        }
    }

    if (!function_exists('form_asociar_cuenta')) {

        function form_asociar_cuenta($error, $nombre_persona, $bancos, $banca)
        {


            if ($error == 1):
                $r[] = d(
                    "SE PRESENTARON ERRORES AL ASOCIAR CUENTA, VERIFIQUE SU INFORMACIÓN ENVIADA",
                    [
                        "style" => "background: #004bff; color: white;padding: 5px;"
                    ]
                );
            endif;
            $r[] = d(heading($nombre_persona, 4), ["style" => "border-bottom-style: solid;border-width: 1px;"]);
            $r[] = h("1.- PAÍS", 4);
            $r[] = create_select(array(
                "text" => "México",
                "v" => 1
            ), "pais", "form-control", "pais", "text", "v");
            $r[] = h("2.- SELECCIONA TU BANCO", 4);
            $r[] = create_select(
                $bancos,
                "banco",
                "banco_cuenta",
                "sel1",
                "nombre",
                "id_banco",
                1);

            if ($banca == 0):

                $r[] = h("3.-NÚMERO CLABE(18 dígitos)", 4);
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
                $r[] = h("4.- TIPO DE TARJETA ", 4);

                $opt[] = array(
                    "text" => "Débito",
                    "v" => 0
                );
                $opt[] = array(
                    "text" => "Crédito",
                    "v" => 1
                );
                $r[] = create_select($opt, "tipo_tarjeta", "form-control", "tipo_tarjeta", "text", "v");
                $r[] = h("5.- NÚMERO DE TARJETA " . icon("fa fa-credit-card-alt"), 4);
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
            $r[] = hiddens(["name" => "tipo", "value" => $banca]);
            $r[] = btn("ASOCIAR" . icon("fa fa-chevron-right"));
            $r[] = d(
                p(
                    "Al asociar tu cuenta, podrás transferir tu saldo de Enid Service a tu cuenta personal", "white"
                )
                ,
                ["style" => "margin-top: 35px;background: #213668;padding: 10px;"]
            );

            $response[] = form_open("", ["class" => "form_asociar_cuenta", "method" => "POST", "action" => "?action=4"]);
            $response[] = d(d(append($r), "page-header"));
            $response[] = form_close();
            return append($response);


        }
    }

    if (!function_exists('render_empresas')) {

        function render_empresas($data)
        {


            $r[] = btw(
                format_saldo_disponible($data["saldo_disponible"]),
                d(submenu(), "card"),
                3

            );
            $r[] = d(place("place_movimientos"), 9);
            return append($r);
        }
    }

    if (!function_exists('render_cuentas_asociadas')) {

        function render_cuentas_asociadas($data)
        {

            $r[] = h("TUS CUENTAS " . br() . " CUENTAS BANCARIAS", 3);
            foreach ($data["cuentas_bancarias"] as $row):
                $r[] = d(
                    append(
                        [
                            $row["nombre"],
                            icon("fa fa-credit-card "),
                            d(resumen_cuenta($row["clabe"]))
                        ]
                    )
                    ,
                    "info_cuenta top_10"
                );

            endforeach;
            $r[] = btn(
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

            $r[] = h("TARJETAS DE CRÉDITO Y DÉBITO", 3);
            foreach ($data["tarjetas"] as $row):
                $r[] = d(append([
                    $row["nombre"],
                    icon("fa fa-credit-card "),
                    d(substr($row["numero_tarjeta"], 0, 4) . "********")

                ]), ["class" => "info_cuenta"]);
            endforeach;
            $r[] = btn(
                text_icon( "fa fa-plus-circle ", "Agregar cuenta "  )

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

    if (!function_exists('asociar_cuenta_bancaria')) {

        function asociar_cuenta_bancaria()
        {

            $r[] = h("ASOCIAR CUENTA BANCARIA Ó TARJETA DE CRÉDITO O DÉBITO", 3);
            $r[] = a_enid(
                d("Asociar  tarjeta de crédito o débito",

                    [
                        "class" => "asociar_cuenta_bancaria",
                        "style" => "border-style: solid;border-width: .9px;padding: 10px;margin-top: 50px;"
                    ]
                ),
                [
                    "href" => "?q=transfer&action=1&tarjeta=1",
                    "class" => "black"
                ]
            );

            $r[] = a_enid(d("Asociar cuenta bancaria",
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
            return d(a_enid(agrega_cuentas_existencia($cuentas_gravadas),
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

            $response = d(
                d("AUN NO CUENTAS CON FONDOS EN TU CUENTA",
                    [
                        "style" => "border-radius:20px;background: black;padding:10px;color: white;"
                    ]
                ),
                [
                    "style" => "width: 80%;margin: 0 auto;margin-top: 20px;"
                ]);


            if ($saldo_disponible > 100) {

                $response = d(d(text_icon("fa fa-chevron-right", "CONTINUAR "),
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
    if (!function_exists('format_saldo_disponible')) {
        function format_saldo_disponible($saldo_disponible)
        {

            $response = ul(
                [
                    d(icon('icon fa fa-money'), "icon"),
                    d("Saldo disponible"),
                    h("$" . number_format(get_data_saldo($saldo_disponible), 2) . "MXN", 2, "value white"),
                    d("Monto expresado en Pesos Mexicanos")
                ]
            );
            return d($response, "panel income db mbm");

        }
    }
    if (!function_exists('render_agregar_saldo_cuenta')) {
        function render_agregar_saldo_cuenta()
        {

            $r[] = h("AÑADE SALDO A TU CUENTA DE ENID SERVICE AL REALIZAR ", 3);
            $r[] = get_format_pago_efectivo();
            $r[] = format_solicitud_amigo();
            return d(append($r), 4, 1);

        }
    }
    if (!function_exists('render_agregar_saldo_oxoo')) {
        function render_agregar_saldo_oxoo($data)
        {
            $id_usuario = $data["id_usuario"];
            return btw(
                h("AÑADE SALDO A TU CUENTA DE ENID SERVICE AL REALIZAR DEPÓSITO DESDE CUALQUIER SUCURSAL OXXO", 3),
                form_pago_oxxo($id_usuario),
                4, 1

            );

        }
    }


    if (!function_exists('format_solicitud_amigo')) {
        function format_solicitud_amigo()
        {

            return a_enid(
                btw(

                d("SOLICITA SALDO A UN AMIGO",

                    "tipo_pago underline"

                    ,
                    1
                ),

                d(
                    "Pide a un amigo que te transfira saldo desde su cuenta",
                    [
                        "style" => "text-decoration: underline;",
                        "class" => "tipo_pago_descripcion"
                    ]
                    ,
                    1),

                "option_ingresar_saldo"

            ),
                "?q=transfer&action=9"
            )
                ;

        }
    }
    if (!function_exists('get_format_pago_efectivo')) {

        function get_format_pago_efectivo()
        {

            return a_enid(
                btw(

                d("UN PAGO EN EFECTIVO EN OXXO ",
                    [
                        "class" => "tipo_pago",
                        "style" => "text-decoration: underline;color: black"
                    ],
                    1),

                d(
                    "Depositas 
						saldo a tu cuenta de Enid service desde  cualquier sucursal de oxxo ",
                    ["class" => "tipo_pago_descripcion"],
                    1),

                "option_ingresar_saldo tipo_pago"

            ), "?q=transfer&action=7"
            );


        }

    }
    if (!function_exists('form_pago_oxxo')) {
        function form_pago_oxxo($id_usuario)
        {

            $r[] = '<form method="GET" action="../orden_pago_oxxo">';
            $r[] = append([
                hiddens(["name" => "q2", "value" => $id_usuario]),
                hiddens(["name" => "concepto", "value" => "1"]),
                hiddens(["name" => "q3", "value" => $id_usuario])
            ]);

            $r[] = btw(
                input(
                    [
                    "type" => "number",
                    "name" => "q",
                    "class" => "form-control input-sm input monto_a_ingresar",
                    "required" => true
                ]
                )
                ,
                h("MXN", 2)
                ,
                "contenedor_form display_flex_enid"

            );
            $r[] = d("¿MONTO QUÉ DESEAS INGRESAR A TU SALDO ENID SERVICE?",
                [
                    "colspan" => "2",
                    "class" => "underline"
                ]
            );
            $r[] = btn("Generar órden");
            $r[] = form_close();
            return append($r);

        }

    }


    if (!function_exists('resumen_cuenta')) {
        function resumen_cuenta($text)
        {
            return substr($text, 0, 4) . "********";
        }
    }
    if (!function_exists('agrega_cuentas_existencia')) {
        function agrega_cuentas_existencia($flag_cuentas)
        {
            return ($flag_cuentas == 0) ? "Asociar nueva cuenta" : "Asociar otra cuenta";

        }
    }
    if (!function_exists('valida_siguiente_paso_cuenta_existente')) {
        function valida_siguiente_paso_cuenta_existente($flag_cuentas_registradas)
        {

            return ($flag_cuentas_registradas == 0) ? "readonly" : "";

        }

    }
    if (!function_exists('despliega_cuentas_registradas')) {
        function despliega_cuentas_registradas($cuentas)
        {
            $option = "";
            foreach ($cuentas as $row) {

                $nombre = "Cuenta - " . $row["nombre"] . " " . substr($row["numero_tarjeta"], 0, 4) . "************";
                $option .= add_option_select($nombre, $row["id_cuenta_pago"]);
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

            return (prm_def($saldo, "saldo") > 0) ? $saldo["saldo"] : 0;

        }
    }

    if (!function_exists('submenu')) {
        function submenu()
        {

            $list = [
                li(a_enid("Añadir ó solicitar saldo", ["href" => "?q=transfer&action=6", "class" => "black"]), ["class" => "list-group-item"]),
                li(a_enid("Trasnferir fondos " . icon("fa fa-fighter-jet"), ["href" => "?q=transfer&action=2", "class" => "black"]), ["class" => "list-group-item"]),
                li(a_enid("Mis tarjetas y cuentas", ["href" => "?q=transfer&action=3", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"]),
                li(a_enid("Asociar cuenta bancaria", ["href" => "?q=transfer&action=1", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"]),
                li(a_enid("Asociar tarjeta de crédito o débito" . icon("fa fa-credit-card-alt"), ["href" => "?q=transfer&action=1&tarjeta=1", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"])

            ];

            return ul($list, "list-group list-group-flush");
        }
    }

}