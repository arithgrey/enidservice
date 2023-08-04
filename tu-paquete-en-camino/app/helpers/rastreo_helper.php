<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function busqueda_pedido($param)
    {

        $textos[] = d(h( "Recibimos", 4, "strong f4 text-uppercase"));
        $textos[] = d(h(_text_( "tu pedido!"), 4, "strong f4 text-uppercase ml-5"));
        
        $response[] = d($textos, 'col-sm-12 mt-5');
        
        $response[] = d(d(
            d(
                _text_(
                    
                    "Estás a nada de pasar al siguiente nivel, 
                    de 1 a 2 días hábilies llegará tu kit!"
                )

            )
        ), "col-xs-12 f13 black strong");
        
        $response[] = d(d(
            d(
                _text_(
                    
                    "Ya solo toca usarlo!"
                )

            )
        ), "col-xs-12 f13 black mt-3 ");

        $response[] = d(img("https://enidservices.com/imgs/04.jpg"),'mt-3');


        return d(d($response, 13), 6, 1);
    }
}
