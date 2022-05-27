<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");
    }

    function get_format_pago()
    {

        $str = _d(
            d(_titulo("FORMAS DE PAGO ENID SERVICE"), 'mb-2 mt-4'),
            _text(
                _titulo("Nos caracterizamos por 
                cobrar al momento de que recibas tus 
                artículos en tu domicilio y ofrecemos estas formas de pago", 5)
            ),
            _text(hr()),
            _text(
                d(
                    _text("1.-", strong("Efectivo ")),
                    'mt-4'
                )
            ),
            _text(
                d(_text("2.-", strong("Transferencia electrónica")), 'mt-5'),
                d('Validamos el pago a través de nuestra banca electrónica 
                al momento de la transferencia')
            ),
            _text(
                d(_text("3.-", strong("tarjeta de crédito o débito")), 'mt-5'),
                d("Podrás comprar con tu tarjeta bancaria con una comisión adicional del 3.5% del monto de tu pedido")
            ),
            hr(),
            d(
                format_link(
                    "Nuestros clientes",
                    [
                        "href" => path_enid("clientes"),
                        "target" => "_black"
                    ]
                )
            )

        );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");
        $r[] = img_pago();


        return d($r, 6, 1);
    }

    function format_tipos_entrega()
    {

        $x[] = _titulo("TIPOS DE ENTREGA", 3);
        $x[] = d(
            "El pago realizado en tiendas de autoservicio tendrá una comisión 
        adicional al monto de la compra por transacción fijada por el proveedor
         y no es imputable a Enid Service."
        );

        $bloque = array_map(
            function ($n) {
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

        $entregas = array_map(
            function ($n) {
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

        $response = array_map(
            $cb,
            [
                "../img_tema/bancos/targetas-de-credito.jpg",
                "../img_tema/bancos/paypal.png",
                "../img_tema/bancos/1.png",
                "../img_tema/bancos/3.png",
                "../img_tema/bancos/8.png",
            ]
        );
        return d($response, "text-center justify-content-center top_20 px-3");
    }
}
