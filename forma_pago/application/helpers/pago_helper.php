<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_pago')) {
        function get_format_pago()
        {

            $x[] = heading("FORMAS DE PAGO ENID SERVICE");
            $x[] = div("Podrás comprar con tu tarjeta bancaria (tarjeta de crédito o débito). ", 1);
            $x[] = div("Aceptamos pagos con tarjetas de crédito y débito directamente para Visa, MasterCard y American Express a través de PayPal con los mismos tipos de tarjetas.", 1);
            $x[] = div("Adicionalmente aceptamos pagos en tiendas de autoservicio (OXXO y 7Eleven) y transferencia bancaria en línea para los bancos BBVA Bancomer.", 1);
            $x[] = div("El pago realizado en tiendas de autoservicio tendrá una comisión adicional al monto de la compra por transacción fijada por el proveedor y no es imputable a Enid Service.", 1);
            $r[] = addNRow(append_data($x));
            $r[] = hr();
            $r[] = get_img_pago();
            return append_data($r);

        }
    }
    if (!function_exists('get_img_pago')) {

        function get_img_pago()
        {

            $r[] = div(
                img(
                    [
                        'class' => "img_pago",
                        'src' => "../img_tema/bancos/targetas-de-credito.jpg"
                    ]

                ));

            $r[] = div(
                img(
                    [
                        'class' => "img_pago",
                        'src' => "../img_tema/bancos/paypal.png"
                    ]
                ));
            $r[] = div(
                img(
                    [
                        'class' => "img_pago",
                        'src' => "../img_tema/bancos/1.png"
                    ]
                ));

            $r[] = div(
                img(
                    [
                        'class' => "img_pago",
                        'src' =>
                            "../img_tema/bancos/3.png"
                    ]
                ));

            $r[] = div(
                img(
                    [
                        'class' => "img_pago",
                        'src' =>
                            "../img_tema/bancos/8.png"
                    ]
                ));


            $r[] = div(
                img([
                        'class' => "img_pago",
                        'src' =>
                            "../img_tema/bancos/oxxo-logo.png"
                    ]
                ));

            return div(append_data($r), ["class" => "display_flex_enid"]);

        }
    }


}

