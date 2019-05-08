<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_orden_compra')) {
        function get_format_orden_compra($usuario, $pago)
        {


            $beneficiario = append_data([

                get_campo($usuario, "nombre"),
                " ",
                get_campo($usuario, "apellido_paterno"),
                " ",
                get_campo($usuario, "apellido_materno")
            ]);


            $folio = $pago["q2"];
            $monto = $pago["q"];
            $concepto = "Saldo a cuenta Enid Service";

            $r[] = div(get_form_saldos($beneficiario, $folio, $monto, $concepto), 1);


            $contendor_oxoo = get_btw(

                img(
                    [
                        'src' => "http://enidservice.com/inicio/img_tema/portafolio/oxxo-logo.png",
                        'style' => "width:100px!important;"
                    ]
                ),

                div("ORDEN DE PAGO EN SUCURSALES OXXO"),
                "display_flex_enid"
            );


            $r[] = div($contendor_oxoo, ["style" => "background: #02223e;color: white;"]);
            $text_beneficiario = strtoupper(append_data([
                    $concepto,
                    "Beneficiario",
                    $beneficiario,
                    "Folio #",
                    $folio

                ])
            );

            $r[] = div($text_beneficiario, ["style" => "background: #d7d7ff;padding: 5px;"]);

            $r[] = get_monto_pago($monto);
            $r[] = get_instruccion_pago();
            return div(append_data($r), 6, 1);


		}
    }
    if (!function_exists('get_form_monto_pago')) {


        function get_form_monto_pago($info_pago)
        {

            $r[] = heading("MONTO A PAGAR");
            $r[] = heading("$" . $info_pago["q"] . "MXN");
            $r[] = div("OXXO Cobrará una comisión adicional al momento de realizar el pago");
            return append_data($r);
        }

    }
    if (!function_exists('get_form_saldos')) {
        function get_form_saldos($beneficiario, $folio, $monto, $concepto)
        {
            $numero_cuenta = "4152 3131 0230 5609";
            $r[] = '<form action="../pdf/orden_pago.php" method="POST">';
            $r[] = input_hidden([
                "name" => "beneficiario",
                "value" => $beneficiario

            ]);
            $r[] = input_hidden([
                "name" => "folio",
                "value" => $folio

            ]);
            $r[] = input_hidden([
                "name" => "monto",
                "value" => $monto

            ]);
            $r[] = input_hidden([
                "name" => "numero_cuenta",
                "value" => $numero_cuenta

            ]);
            $r[] = input_hidden([
                "name" => "concepto",
                "value" => $concepto

            ]);
            $r[] = div(
                guardar(
                    "IMPRIMIR",
                    [
                        "class" => " imprimir",
                        "style" => "background:#0a0e39!important;"
                    ]
                    ,
                    1
                    ,
                    1
                ),
                [
                    "class" => "col-lg-3 pull-right row"
                ]
                ,
                1
            );
            $r[] = br();
            $r[] = form_close();
            return append_data($r);


        }
    }

    if (!function_exists('get_instrucciones')) {
        function get_instrucciones()
        {


            $r [] = div(
                "INSTRUCCIONES",
                ["style" => "background: #000b39;color: white;padding: 5px;"],
                1);


            $r [] = div("1.-Acude a la tienda OXXO más cencana ");
            $r [] = div("2.- Indica en caja que quieres realizar un
                                                depósito en cuenta BBVA Bancomer ");
            $r [] = div("3.- Proporciona el número de cuenta señalado");
            $r [] = div("4.-Realiza el 
                        pago exacto correspondiente, que se indica en el monto a pagar");
            $r [] = div("5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso.");
            $r [] = div("En el podrás verificar que se haya realizado correctamente, conserva este comprobante.");

            $r [] = div("6.- Notifica tu pago desde tu área de cliente");
            $r [] = anchor_enid("http://enidservice.com/inicio/login/",
                [
                    "href" => "http://enidservice.com/inicio/login/"
                ]);
            $r [] = div("ó", 1);
            $r [] = div("Notifica tu pago  al área de ventas ventas@enidservice.com", 1);
            $r [] = div(
                img([
                        "src" => "../img_tema/enid_service_logo.jpg",
                    ]
                ),
                ["class" => "col-lg-6 "]
                , 1
            );

            return div(append_data($r));


        }
    }
    if (!function_exists('get_instruccion_pago')) {
        function get_instruccion_pago()
        {

            $numero_cuenta = "4152 3131 0230 5609";

            $r[] = img(
                [
                    "src" => "http://enidservice.com/inicio/img_tema/portafolio/logo-bbv.png",
                    "style" => "width:300px!important;"

                ]);

            $r[] = heading_enid($numero_cuenta, 4, ["style" => "color:blue;margin-bottom:30px;"]);
            $r[] = get_instrucciones();
            return addNRow(
                div(
                    append_data($r), "border padding_20 top_20"
                )
            );

        }
    }
    if (!function_exists('get_monto_pago')) {
        function get_monto_pago($monto)
        {

            $r[] = heading("MONTO A PAGAR");
            $r[] = heading("$" . $monto . "MXN", 2);
            $r[] = div("OXXO Cobrará una comisión adicional al momento de realizar el pago", 1);
            return div(append_data($r));

        }
    }

}
