<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function format_orden_compra($usuario, $pago, $numero_cuenta)
    {

        $beneficiario = _text(
            pr($usuario, "nombre"),
            " ",
            pr($usuario, "apellido_paterno"),
            " ",
            pr($usuario, "apellido_materno")
        );

        $folio = prm_def($pago, "q2", "");
        $monto = $pago["q"];
        $concepto = "Saldo a cuenta Enid Service";

        $r[] = d(form_saldos($beneficiario, $folio, $monto, $concepto, $numero_cuenta));

        $contendor_oxoo = btw(
            img(
                [
                    'src' => "http://enidservices.com/inicio/img_tema/portafolio/oxxo-logo.png",
                    'style' => "width:100px!important;"
                ]
            ),

            d("ORDEN DE PAGO EN SUCURSALES OXXO"),
            "display_flex_enid"
        );


        $r[] = d($contendor_oxoo, ["style" => "background: #02223e;color: white;"]);
        $str = _text(
            $concepto,
            "Beneficiario",
            $beneficiario,
            "Folio #",
            $folio

        );

        $r[] = d(strtoupper($str), ["style" => "background: #d7d7ff;padding: 5px;"]);
        $r[] = monto_pago($monto);
        $r[] = instruccion_pago($numero_cuenta);
        return d(append($r), 6, 1);


    }


//    function get_form_monto_pago($info_pago)
//    {
//
//        $r[] = h("MONTO A PAGAR");
//        $r[] = h("$" . $info_pago["q"] . "MXN");
//        $r[] = d("OXXO Cobrará una comisión adicional al momento de realizar el pago");
//        return append($r);
//    }


    function form_saldos($beneficiario, $folio, $monto, $concepto, $numero_cuenta)
    {

        $r[] = '<form action="../pdf/orden_pago.php" method="POST">';
        $r[] = hiddens(
            [
                "name" => "beneficiario",
                "value" => $beneficiario

            ]);
        $r[] = hiddens(
            [
                "name" => "folio",
                "value" => $folio

            ]
        );
        $r[] = hiddens(
            [
                "name" => "monto",
                "value" => $monto

            ]
        );
        $r[] = hiddens(
            [
                "name" => "numero_cuenta",
                "value" => $numero_cuenta

            ]
        );
        $r[] = hiddens(
            [
                "name" => "concepto",
                "value" => $concepto

            ]
        );
        $r[] = d(
            btn(
                "IMPRIMIR",
                [
                    "class" => " imprimir mt-5"
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

    function instrucciones()
    {


        $r [] = d(
            "INSTRUCCIONES",
            [
                "style" => "background: #000b39;color: white;padding: 5px;"
            ]
        );

        $r[] = _d(
            "1.-Acude a la tienda OXXO más cencana ",
            "2.- Indica en caja que quieres realizar un depósito en cuenta BBVA Bancomer ",
            "3.- Proporciona el número de cuenta señalado",
            "4.-Realiza el pago exacto correspondiente, que se indica en el monto a pagar",
            "5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso.",
            "En el podrás verificar que se haya realizado correctamente, conserva este comprobante.",
            "6.- Notifica tu pago desde tu área de cliente",

        );
        $r [] = a_enid(
            "http://enidservices.com/inicio/login/",
            [
                "href" => "http://enidservices.com/inicio/login/"
            ]
        );
        $r [] = d("ó");
        $r [] = d("Notifica tu pago  al área de ventas ventas@enidservices.com");
        $r [] = d(
            img(
                [
                    "src" => path_enid("img_logo"),
                ]
            ),
            "col-lg-6 "

        );

        return d(append($r));


    }

    function instruccion_pago($numero_cuenta)
    {

        $r[] = img(
            [
                "src" => "http://enidservices.com/inicio/img_tema/portafolio/logo-bbv.png",
                "style" => "width:300px!important;"
            ]
        );

        $r[] = h($numero_cuenta, 4, ["style" => "color:blue;margin-bottom:30px;"]);
        $r[] = instrucciones();
        return d(append($r), "border padding_20 top_20");

    }

    function monto_pago($monto)
    {

        $r[] = h("MONTO A PAGAR");
        $r[] = h(_text("$", $monto, "MXN"), 2);
        $r[] = d("OXXO Cobrará una comisión adicional al momento de realizar el pago");
        return d(append($r));

    }

}
