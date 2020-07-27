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

        $r[] = d(form_saldos($beneficiario, $folio, $monto, $concepto, $numero_cuenta), 13);

        $r[] = hr('mb-1', 0);
        $logo_oxxo = img(
            [
                'src' => path_enid('logo_oxxo', 0, 1),
                'class' => 'w-100'
            ]
        );

        $r[] = d(
            ajustar(
                $logo_oxxo,
                _titulo("ORDEN DE PAGO EN SUCURSALES OXXO", 0, 'text-right'),
                1
            )
            ,
            'mt-5'
        );


        $folio = _text("Folio #", " ", $folio);
        $str = _text(
            $concepto,
            " ",
            "Beneficiario",
            " ",
            $beneficiario,
            " ",
            $folio

        );

        $r[] = d(strtoupper($str), 'mt-1 mb-3 text-right');
        $r[] = hr([], 0);
        $r[] = monto_pago($monto);
        $r[] = instruccion_pago($numero_cuenta);
        return d($r, 6, 1);


    }

    function form_saldos($beneficiario, $folio, $monto, $concepto, $numero_cuenta)
    {

        $r[] = '<form class="col-lg-3 ml-auto" action="../pdf/orden_pago.php" method="POST">';
        $r[] = hiddens(
            [
                "name" => "beneficiario",
                "value" => $beneficiario

            ]
        );
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


        $r[] = btn("IMPRIMIR");
        $r[] = form_close();
        return append($r);


    }

    function instrucciones($numero_cuenta)
    {


        $r [] = _titulo("INSTRUCCIONES", 1, 'mb-5');

        $r [] = d("1.-Acude a tu tienda Oxxo más cencana ", 'mt-2 mb-2');

        $r[] = flex(
            "2.- Indica en caja que quieres realizar un depósito en cuenta",

            img(
                [
                    "src" => _text("http://enidservices.com/",_web,"/img_tema/bancos/4.png"),
                    "style" => "width:110px!important;",
                    'class' => 'ml-2'
                ]
            )
            ,
            'align-items-center'
        );


        $r [] = d(_text("3.- Proporciona el siguien número de cuenta ", strong($numero_cuenta, 'f12')), 'mt-2');


        $r [] = d("4.-Realiza el 
                        pago exacto correspondiente, que se indica en el monto a pagar", 'mt-3');
        $r [] = d("5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso.", 'mt-3');
        $r [] = d("En el podrás verificar que se haya realizado correctamente, conserva este comprobante.", 'mt-3');

        $login = path_enid('enid_login', 0, 1, 'mt-3');
        $r [] = d(
            _text(
                "6.- Notifica tu pago desde tu área de cliente",
                a_enid($login,
                    [
                        'href' => $login,
                        'class' => 'ml-3'
                    ], 0)
                ,
                ' ó '
            ), 'mt-3'
        );


        $r [] = d("Notifica tu pago  al área de ventas ventas@enidservices.com", 'mt-3');


        return d(append($r));


    }

    function instruccion_pago($numero_cuenta)
    {


        $r[] = instrucciones($numero_cuenta);
        return d($r);

    }

    function monto_pago($monto)
    {
        $logo = img(
            [
                "src" => path_enid("img_logo"),
            ]
        );
        $monto_pago = _d(
            h("MONTO A PAGAR", 2),
            h(money($monto), 3)
        );
        $r[] = ajustar(
            $monto_pago,
            $logo,
            9
        );

        $r[] = d_p("NOTA Oxxo Cobrará una comisión adicional al
         momento de realizar tu compra"
        );
        return d(append($r));

    }

//    function get_form_monto_pago($info_pago)
//    {
//
//        $r[] = h("MONTO A PAGAR");
//        $r[] = h("$" . $info_pago["q"] . "MXN");
//        $r[] = d("OXXO Cobrará una comisión adicional al momento de realizar el pago");
//        return append($r);
//    }

}
