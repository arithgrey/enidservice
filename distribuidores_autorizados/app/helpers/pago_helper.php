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
            a_enid("Identifícalo aquí",
            [
                "href"=> path_enid("facebook_descuento",0,1)
            ])), 'f14 black');
    
    
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
        _text_('De preferencia agenda tu pedido en nuestra cuenta oficial de',
        a_enid("Facebook",
        [
            "href"=> path_enid("facebook_descuento",0,1)
        ])), 'f14 black');


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
        $paso[]  = d('3', 'strong f2');
        $paso[]  = d(
            _text_('Recibe solo el pedido del número que te daremos al confirmar tu envío'), 'f14 black');

            
    $response[] = d($paso, 'col-xs-4 text-center mt-5');

    $contenido[] =  d($response, 13);

    
    $str = _d(
            d(_titulo(
                _text_(
                    span("No te dejes engañar!","f2"),                                        
                    icon('fa fa-check fa-2x')                    
                )
            ), 'mb-2 mt-4'),
            
            d('Toma si o si estas medidas de seguridad si compras con nosotros bajo el concepto de pago contra entrega:',
             'mt-2 f12 black borde_end_b'),
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
