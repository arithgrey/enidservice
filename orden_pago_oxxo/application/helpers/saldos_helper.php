<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_orden_compra')) {
        function format_orden_compra($usuario, $pago, $numero_cuenta)
        {


            $beneficiario = append([
                pr($usuario, "nombre"),
                " ",
                pr($usuario, "apellido_paterno"),
                " ",
                pr($usuario, "apellido_materno")
            ]);


            $folio = prm_def($pago, "q2", "");
            $monto = $pago["q"];
            $concepto = "Saldo a cuenta Enid Service";

            $r[] = d(get_form_saldos($beneficiario, $folio, $monto, $concepto, $numero_cuenta), 1);


            $contendor_oxoo = btw(
                img(
                    [
                        'src' => "http://enidservices.com/inicio/img_tema/portafolio/oxxo-logo.png",
                        'style' => "width:100px!important;"
                    ]
                ),

                d("ORDEN DE PAGO EN SUCURSALES OXXO"), "display_flex_enid"
            );


            $r[] = d($contendor_oxoo, ["style" => "background: #02223e;color: white;"]);
            $str_beneficiario = strtoupper(append([
                    $concepto,
                    "Beneficiario",
                    $beneficiario,
                    "Folio #",
                    $folio

                ])
            );

            $r[] = d($str_beneficiario, ["style" => "background: #d7d7ff;padding: 5px;"]);
            $r[] = monto_pago($monto);
            $r[] = get_instruccion_pago($numero_cuenta);
            return d(append($r), 6, 1);


        }
    }
    if (!function_exists('get_form_monto_pago')) {


        function get_form_monto_pago($info_pago)
        {

            $r[] = h("MONTO A PAGAR");
            $r[] = h("$" . $info_pago["q"] . "MXN");
            $r[] = d("OXXO Cobrará una comisión adicional al momento de realizar el pago");
            return append($r);
        }

    }
    if (!function_exists('get_form_saldos')) {
        function get_form_saldos($beneficiario, $folio, $monto, $concepto, $numero_cuenta)
        {

            $r[] = '<form action="../pdf/orden_pago.php" method="POST">';
            $r[] = hiddens([
                "name" => "beneficiario",
                "value" => $beneficiario

            ]);
            $r[] = hiddens([
                "name" => "folio",
                "value" => $folio

            ]);
            $r[] = hiddens([
                "name" => "monto",
                "value" => $monto

            ]);
            $r[] = hiddens([
                "name" => "numero_cuenta",
                "value" => $numero_cuenta

            ]);
            $r[] = hiddens([
                "name" => "concepto",
                "value" => $concepto

            ]);
            $r[] = d(
                btn(
                    "IMPRIMIR",
                    [
                        "class" => " imprimir top_50"
                    ]
                    ,
                    1
                    ,
                    1
                ),

                "col-lg-3 pull-right row"

                ,
                1
            );

            $r[] = form_close();
            return append($r);


        }
    }

    if (!function_exists('get_instrucciones')) {
        function get_instrucciones()
        {


            $r [] = d(
                "INSTRUCCIONES",
                [
                    "style" => "background: #000b39;color: white;padding: 5px;"
                ],
                1);


            $r [] = d("1.-Acude a la tienda OXXO más cencana ");
            $r [] = d("2.- Indica en caja que quieres realizar un
                                                depósito en cuenta BBVA Bancomer ");
            $r [] = d("3.- Proporciona el número de cuenta señalado");
            $r [] = d("4.-Realiza el 
                        pago exacto correspondiente, que se indica en el monto a pagar");
            $r [] = d("5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso.");
            $r [] = d("En el podrás verificar que se haya realizado correctamente, conserva este comprobante.");

            $r [] = d("6.- Notifica tu pago desde tu área de cliente");
            $r [] = a_enid("http://enidservices.com/inicio/login/",
                [
                    "href" => "http://enidservices.com/inicio/login/"
                ]);
            $r [] = d("ó", 1);
            $r [] = d("Notifica tu pago  al área de ventas ventas@enidservices.com", 1);
            $r [] = d(
                img([
                        "src" => path_enid("img_logo"),
                    ]
                ),
                "col-lg-6 "
                , 1
            );

            return d(append($r));


        }
    }
    if (!function_exists('get_instruccion_pago')) {
        function get_instruccion_pago($numero_cuenta)
        {


            $r[] = img(
                [
                    "src" => "http://enidservices.com/inicio/img_tema/portafolio/logo-bbv.png",
                    "style" => "width:300px!important;"

                ]
            );

            $r[] = h($numero_cuenta, 4, ["style" => "color:blue;margin-bottom:30px;"]);
            $r[] = get_instrucciones();
            return addNRow(
                d(
                    append($r), "border padding_20 top_20"
                )
            );

        }
    }
    if (!function_exists('monto_pago')) {
        function monto_pago($monto)
        {

            $r[] = h("MONTO A PAGAR");
            $r[] = h("$" . $monto . "MXN", 2);
            $r[] = d("OXXO Cobrará una comisión adicional al momento de realizar el pago", 1);
            return d(append($r));

        }
    }

}
