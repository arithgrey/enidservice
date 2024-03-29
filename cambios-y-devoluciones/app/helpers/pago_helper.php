<?php

use BaconQrCode\Renderer\Path\Path;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");
    }

    function get_format_pago()
    {

        $str = _d(
            d(_titulo("Cambios y devoluciones"), 'mb-2 mt-5'),            
            d("Si no te satisface tu compra, ofrecemos garantía de devolución durante los primeros 30 días 
             y cambios hasta por 12 Meses",
             'f14 text-uppercase  mt-5 mb-5 p-3 black borde_end  shadow font-weight-bold p-2  d-block'),
            
            d(_titulo("Preguntas frecuentes"), 'mb-2 mt-5'),            
            _text(
                a_enid(
                    "¿CUÁNTO TARDARÁ EN LLEGAR MI PEDIDO?",
                    [
                        "href" => path_enid('forma_pago'),
                        "class" => 'mt-5 black strong underline hover_bg_black'
                    ]
                )
                    )
                    

                    ,
                    _text(
                        a_enid(
                            "¿CÓMO ES EL PROCESO DE DEVOLUCIÓN DE UN PEDIDO?",
                            [
                                "href" => path_enid('como-es-el-proceso-de-devolucion-de-un-pedido'),
                                "class" => 'mt-5 black strong underline hover_bg_black'
                            ]
                        )
                    )

                    ,
                    _text(
                        a_enid(
                            "¿CÓMO PUEDO DAR SEGUIMIENTO A LA ENTREGA DE MI PEDIDO?",
                            [
                                "href" => path_enid("rastrea-paquete"),
                                "class" => 'mt-5 black strong underline hover_bg_black'
                            ]
                        )
                    )

                );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");



        return d($r, 6, 1);
    }
}
