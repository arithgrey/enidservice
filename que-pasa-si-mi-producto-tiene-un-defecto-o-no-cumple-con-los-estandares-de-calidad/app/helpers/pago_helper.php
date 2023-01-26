<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");
    }

    function get_format_pago()
    {

        $str = _d(
            d(_titulo("¿QUÉ PASA SI MI PRODUCTO TIENE UN DEFECTO O NO CUMPLE CON LOS ESTÁNDARES DE CALIDAD?"), 'mb-2 mt-5'),            
            _text(
                d(
                    "Para Enid Service la calidad es lo primero. Comprobamos exhaustivamente todos nuestros productos en condiciones 
                    reales para asegurarnos de que están en óptimas condiciones para soportar los usos para los que han sido diseñados. 
                    Sin embargo, a veces resulta inevitable que se entregue un producto defectuoso. 
                    ",
                    [                 
                        "class" => 'mt-5 black '
                    ]
                    ),
                    d(
                        "Por ello, si tu producto no cumple con los estándares de calidad y sufre algun daño durante su uso NORMAL: 
                        
                        ",
                        [                 
                            "class" => 'mt-5 black '
                        ]
                        ),

                        d(
                            "1) Tienes un plazo de hasta 90 días para comunicarte con nuestro Servicio de Atención a Clientes",
                            [                 
                                "class" => 'mt-5 black '
                            ]
                            ),
                        d(
                            "2) Si al momento de tu solicitud:",
                            [                 
                                "class" => 'black '
                            ]
                            ),

                        d(
                            "2.1 Contamos con el inventario para reemplazar tu producto, te haremos llegar uno nuevo.",
                            [                 
                                "class" => 'black mt-2'
                            ]
                        ),
                        d(
                            "2.2 Si no contamos con el inventario disponible, tardaremos de 2 a 3 días 
                            en  hacerte llegar uno nuevo",
                            [                 
                                "class" => 'black '
                            ]
                        )
                
                ));

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");



        return d($r, 6, 1);
    }
}
