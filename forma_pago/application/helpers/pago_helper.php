<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


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

