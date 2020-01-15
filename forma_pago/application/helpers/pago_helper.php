<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");

    }

    function get_format_pago()
    {

        $str = _d(
            heading("FORMAS DE PAGO ENID SERVICE", 3)
            , _text(
                "1.- Podrás comprar con tu tarjeta bancaria  ",
                strong("(tarjeta de crédito o débito).")
            )
            ,
            _text(
                "2.- Aceptamos pagos con tarjetas de crédito y débito directamente 
                para Visa, MasterCard y American Express a través de ",
                strong("PayPal"),
                " con los mismos tipos de tarjetas."
            )
            , _text(
                "3.- Adicionalmente aceptamos pagos en tiendas de ",
                strong("autoservicio (OXXO y 7Eleven)"),
                " y transferencia bancaria en línea para los bancos BBVA Bancomer."
            )
            ,
            "El pago realizado en tiendas de autoservicio tendrá una comisión adicional 
            al monto de la compra por transacción fijada por el proveedor 
            y no es imputable a Enid Service."
            , hr()
        );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_350");
        $r[] = img_pago();
        $r[] = format_tipos_entrega();
        return d($r, 6, 1);

    }

    function format_tipos_entrega()
    {

        $x[] = _titulo("TIPOS DE ENTREGA", 3);
        $x[] = d("El pago realizado en tiendas de autoservicio tendrá una comisión 
        adicional al monto de la compra por transacción fijada por el proveedor
         y no es imputable a Enid Service."
        );

        $bloque = array_map(function ($n) {
            return img(
                [
                    "src" => $n,
                    "class" => "col-lg-6"
                ]
            );

        },
            [
                "../img_tema/bancos/envios.png",
                "../img_tema/bancos/contra_entrega.png",
            ]
        );


        $x[] = d($bloque, "row top_30 bottom_30");

        $entregas = array_map(function ($n) {
            return img([
                "src" => $n,
                "class" => "col-lg-6"
            ]);

        },
            [
                "../img_tema/bancos/fedex.png",
                "../img_tema/bancos/dhl2.png"

            ]
        );


        $x[] = d($entregas, "col-lg-6 col-lg-offset-3 top_30 bottom_30");
        return d($x, "mt-3");

    }

    function img_pago()
    {

        $cb = function ($n) {
            return img([
                "src" => $n,
                "class" => "col-lg-3 top_50"
            ]);

        };

        $response = array_map($cb,
            [
                "../img_tema/bancos/targetas-de-credito.jpg",
                "../img_tema/bancos/paypal.png",
                "../img_tema/bancos/1.png",
                "../img_tema/bancos/3.png",
                "../img_tema/bancos/8.png",
                "../img_tema/bancos/oxxo-logo.png"
            ]
        );
        return d($response, "text-center justify-content-center top_20 px-3");

    }
}

