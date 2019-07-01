<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    if (!function_exists('get_format_orden')) {

        function get_format_orden($data)
        {

            return  div($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid" );

        }
    }

    if (!function_exists('get_format_pago')) {
        function get_format_pago()
        {

            $x[] = div(heading("FORMAS DE PAGO ENID SERVICE",3),1);
            $x[] = div("1.- Podrás comprar con tu tarjeta bancaria  ".strong("(tarjeta de crédito o débito)."), 1);
            $x[] = div("2.- Aceptamos pagos con tarjetas de crédito y débito directamente para Visa, MasterCard y American Express a través de ".strong("PayPal")." con los mismos tipos de tarjetas.", 1);
            $x[] = div("3.- Adicionalmente aceptamos pagos en tiendas de ".strong("autoservicio (OXXO y 7Eleven)")." y transferencia bancaria en línea para los bancos BBVA Bancomer.", 1);
            $x[] = div("El pago realizado en tiendas de autoservicio tendrá una comisión adicional al monto de la compra por transacción fijada por el proveedor y no es imputable a Enid Service.", 1);
            $x[] = div(hr(),1);
            $r[] = div(append($x)," d-flex flex-column justify-content-between mh_350");
            $r[] = get_img_pago();
            $r[] = get_format_tipos_entrega();

            return div(div(append($r), 6, 1),"top_30",1);

        }
    }
    if (!function_exists('get_format_tipos_entrega')) {

        function get_format_tipos_entrega()
        {

            $x[] = div(heading("TIPOS DE ENTREGA",3),1);
            $x[] = div("El pago realizado en tiendas de autoservicio tendrá una comisión adicional al monto de la compra por transacción fijada por el proveedor y no es imputable a Enid Service.", 1);

            $r =  [
                "../img_tema/bancos/fedex.png",
                "../img_tema/bancos/dhl2.png"

            ];

            $envios =  [
                "../img_tema/bancos/envios.png",
                "../img_tema/bancos/contra_entrega.png",

            ];

            for ($a = 0; $a < count($envios); $a ++ ){

                $bloque[] = img(
                    [
                        "src" => $envios[$a],
                        "class" => "col-lg-6"
                    ]
                );
            }

            $x[] =  div(append($bloque),"row top_30 bottom_30");


            for ($a = 0; $a < count($r); $a ++ ){

                $bloque_entregas[] = img(
                    [
                        "src" => $r[$a],
                        "class" => "col-lg-6 top_50"
                    ]
                );
            }
            $x[] =  div(append($bloque_entregas),"col-lg-6 col-lg-offset-3 top_30 bottom_30");

            return div(append($x),"top_10");


        }
    }


    if (!function_exists('get_img_pago')) {

        function get_img_pago()
        {

            $r = [
                "../img_tema/bancos/targetas-de-credito.jpg",
                "../img_tema/bancos/paypal.png",
                "../img_tema/bancos/1.png",
                "../img_tema/bancos/3.png",
                "../img_tema/bancos/8.png",
                "../img_tema/bancos/oxxo-logo.png"
            ];

            $response =  [];

            for ($a  = 0; $a < count($r); $a ++ ){

                $response[] =  img([
                    "src"   => $r[$a],
                    "class" => "col-lg-3 top_50"
                ]);
            }

            return div(div(append($response), "text-center justify-content-center   top_20 px-3"),1);

        }
    }


}

