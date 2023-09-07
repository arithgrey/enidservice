<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function busqueda_pedido($param)
    {

        $textos[] = d(h( "Recibimos", 4, "strong f4 text-uppercase"));
        $textos[] = d(h(_text_( "tu evento!"), 4, "strong f4 text-uppercase ml-5"));
        
        $response[] = d($textos, 'col-sm-12 mt-5');
        
        $response[] = d(d(
            d(
                _text_(                    
                    "Tu decoración quedó agendada!"
                )

            )
        ), "col-xs-12 f13 black strong");
        
        $response[] = d(d(
            d(
                _text_(
                    
                    "En un lapso no mayor a 1 hora recibirás una llamada teléfonica 
                    para pedirte más detalles de tu evento, también puedes comunicarte al (55) 7612- 7281 si tienes alguna duda"
                )

            )
        ), "col-xs-12 f11 black mt-3 ");

        $response[] = d(img("https://enidservices.com/imgs/decoraciones_globos_globolandia.png"),'mt-3');


        return d(d($response, 13), 6, 1);
    }
}
