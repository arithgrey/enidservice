<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");
    }

    function get_format_pago()
    {

        $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke-width="1.5" 
        stroke="currentColor" 
        class="w-6 h-6 black">
        <path stroke-linecap="round" 
        stroke-linejoin="round" 
        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
      </svg>
      ');
        $paso[]  = d('1', 'strong f2');
        $paso[]  = d(
            _text_('Si viste el artículo en el Marketplace de Facebook verifica que sea alguien de nuestro equipo
             no importa que tenga las mismas imagenes, puede ser un estafador',
             span("OTRO ASPECTO IMPORTANTE A RESALTAR ES QUE SOMOS UN NEGOCIO DE EQUIPOS DEPORTIVOS, POR NINGUN MOTIVO OFRECEMOS 
             ALGÚN SERVICIO DE INFONAVIT O ALGO SIMILAR",'red_enid'),
            a_enid("Identifícalo aquí",
            [
                "href"=> path_enid("facebook_descuento",0,1)
            ])), 'f16 black');
    
    
    $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
    fill="none" 
    viewBox="0 0 24 24" 
    stroke-width="1.5" 
    stroke="currentColor" 
    class="w-6 h-6 black">
    <path stroke-linecap="round" 
    stroke-linejoin="round" 
    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
  </svg>
  ');
    $paso[]  = d('2', 'strong f2');
    $paso[]  = d(
        _text_('De preferencia haz tu compra en linea y si de plano no tienes la forma de hacer tu pedido en nuestra página web en el siguiente enlace',
        a_enid("Aquí haz tu pedido",
        [
            "href"=> path_enid("facebook_descuento",0,1)
        ])), 'f16 black');


        $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke-width="1.5" 
        stroke="currentColor" 
        class="w-6 h-6 black">
        <path stroke-linecap="round" 
        stroke-linejoin="round" 
        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
      </svg>
      ');
        $paso[]  = d('4', 'strong f2');
        
        $paso[]  = d(
            _text_('Recibe solo el pedido del número que te daremos al confirmar tu envío'), 'f16 black');

       
            $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke-width="1.5" 
        stroke="currentColor" 
        class="w-6 h-6 black">
        <path stroke-linecap="round" 
        stroke-linejoin="round" 
        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
      </svg>
      ');
        $paso[]  = d('5', 'strong f2');
        
        $paso[]  = d(
            _text_(a_enid('Lee más sobre nuestras medidas de seguridad aquí',["href"=> "https://www.facebook.com/enidservicemx/posts/pfbid02KaV9Riq74BKwBGXiQq8MECBEwrH66AXS4bkzUmSv3PXK3AggrLFBCftju54CSNLsl"])), 'f16 black');

       
        
            
            
    $response[] = d($paso, 'col-xs-12 text-center mt-5');

    $contenido[]  = d("LEE ESTAS MEDIDAS DE SEGURIDAD PARA SABER QUE SOMOS NOSOTROS Y NO ALGÚN ESTAFADOR","text-uppercase p-5 bg_yellow mt-5 f2 red_enid");
    
    $contenido[]  = d("PERFILES FALSOS, CUIDADO!","text-uppercase p-5 red_lista_negra mt-5 f3 white");

    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/daniela-gonzales-estafadora-1.jpeg"),"text-center red_lista_negra mt-5 f2 white");   //$contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-5.jpeg"),"text-center red_lista_negra mt-5 f2 white");
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-daniela-gonzales-estafadora-infonavit.jpeg"),"text-center red_lista_negra mt-5 f2 white");
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-3.jpeg"),"text-center red_lista_negra mt-5 f2 white");    
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-1.jpeg"),"text-center red_lista_negra mt-5 f2 white");
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-2.jpeg"),"text-center red_lista_negra mt-5 f2 white");
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/ratero.jpg"),"text-center red_lista_negra mt-5 f2 white");
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/ratera-daniela.jpg"),"text-center red_lista_negra mt-5 f2 white");

    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/ratera-daniela-1.jpg"),"text-center red_lista_negra mt-5 f2 white");
 
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/ratera-luis-galindo-1.jpg"),"text-center red_lista_negra mt-5 f2 white");   //$contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-5.jpeg"),"text-center red_lista_negra mt-5 f2 white");

    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/ratero-daniel-galindo-medrano-1.jpg"),"text-center red_lista_negra mt-5 f2 white");   //$contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-5.jpeg"),"text-center red_lista_negra mt-5 f2 white");
    $contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/daniela-gonzales-estafadora.jpeg"),"text-center red_lista_negra mt-5 f2 white");   //$contenido[]  = d(img("https://enidservices.com/medidas-de-seguridad/perfil-falso-5.jpeg"),"text-center red_lista_negra mt-5 f2 white");
    
    

    
    $contenido[] =  d($response, 13);

    
    $str = _d(
            d(_titulo(
                _text_(
                    span("No te dejes engañar!","f2"),                                        
                    icon('fa fa-check fa-2x')                    
                )
            ), 'mb-2 mt-4'),
            
            d('Toma si o si estas medidas de seguridad si compras con nosotros bajo el concepto de pago contra entrega, 
            estos perfiles de ninguna manera tienen algo que ver con Enid Service NO TE EXPONGAS, son estafadores y ya son 7 personas que nos reportan 
            ser victimas de estos delincuentes:',
             'mt-2 f15 black borde_end_b'),
            d(append($contenido))            
                       

        );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");
        


        return d($r,"col-md-6 col-md-offset-3 col-xs-12 mt-5");
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
