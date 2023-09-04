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
    $paso[]  = d('Elige tus artículos de tu interés', 'f11 black');

    $response[] = d($paso, 'col-xs-3 text-center mt-5');

    /**/
    $paso_2[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 black">
    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
  </svg>  
  ');
    $paso_2[]  = d('2', 'strong f2');
    $paso_2[]  = d('Nos dices donde te los llevamos', 'f11 black');

    $response[] = d($paso_2, 'col-xs-3 text-center mt-5');

    /*----------- */

    $paso_3[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 black">
     <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
   </svg>
   
   ');
    $paso_3[]  = d('3', 'strong f2');
    $paso_3[]  = d('Te marcamos ya que estemos de camino', 'f11 black');

    $response[] = d($paso_3, 'col-xs-3 text-center mt-5');

    /**/

    $paso_4[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" 
     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="black w-6 h-6">
     <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
   </svg>   
   ');
    $paso_4[]  = d('4', 'strong f2');
    $paso_4[]  = d('Compras al recibir tu pedido!', 'f11 black');

    $response[] = d($paso_4, 'col-xs-3 text-center mt-5');

    $contenido[] =  d($response, 13);

    $referencias =  format_link(
        _text_(icon('fa fa-star white'),"Mira nuestras referencias"),
        [
            "href" => path_enid("clientes")
            
        ],2
    );

    $referencias_ =  format_link(
        _text_(icon('fa fa-star white'),"Mira nuestras referencias"),
        [
            "href" => path_enid("clientes")
            
        ],2
    );
    $referencias_en_facebook =  format_link(
        _text_(icon('fa fa-star white'),"Checa referencias en Facebook"),
        [
            "href" => "https://www.facebook.com/100063746634538/posts/pfbid018XMMgQ2vM35s7GK5YM3P2HctCmjZcyHRKRnPccV1MbPEjhkcnczft1W4qEMTGwnl/?mibextid=cr9u03"
            
        ],2
    );

    $referencias = flex_md($referencias, $referencias_en_facebook, _between_md,'','mt-4');

    $str = _d(
            d(_titulo(
                _text_(
                    span("Paga al recibir tus artículos y recíbelos el mismo día! en CDMX y algunas partes del estado de México","f2"),                                        
                    icon('fa fa-check fa-2x')                    
                )
            ), 'mb-2 mt-4'),
            
            d('Así funciona:', 'mt-2 f12 black borde_end_b'),
            d(append($contenido))
            
            ,
            
            _text(
                d("Formas de pago ", 'text-uppercase black mt-5 f2 black strong')
            ),            
            _text(
                d(
                    _text("1.-", span("Efectivo","black f12")),
                    'mt-4'
                )
            ),
            _text(
                d(_text("2.-", span("Transferencia electrónica","black f12")), 'mt-2')                
            ),
            _text(
                d(_text("3.-", span("Tarjeta de crédito o débito","black f12")), 'mt-2')
            ),            
            d(
                $referencias ,'mt-5 '
            )            

            ,
            d("Esta modalidad es EXCLUSIVA para entregas en CDMX y SOLO estas zonas adicionales:", "f2 black strong top_100 text-uppercase"),
            d(h("- Nezahualcóyotl",2, "f12 black mt-5")),
            d(h("- Chimalhuacán",2, "f12 black mt-2")),
            d(h("- Ecatepec solo del metro Villa de Aragón a Ciudad Azteca ",2, "f12 black mt-2")),
            d(h("- Tultitlán de Mariano Escobedo ",2, "f12 black mt-2")),
            d(h("- Cuautitlán de Romero Rubio ",2, "f12 black mt-2")),
            d(h("- Cuautitlán ",2, "f12 black mt-2")),
            d(h("- Tultepec ",2, "f12 black mt-2")),            
            hr("top_100 borde_black"),
            
            d(_titulo(
                _text_(                    
                    span("No hacemos pago contra entrega en los estados pero ...","f2"),                                                            
                )
            ), 'mb-2 mt-5')
            ,_text(
                d("Pierde  el miedo!! Te las podemos enviar","f18 text-center font-weight-bold text-uppercase mt-5 red_enid"),                                        
                d("Si estamos aquí es para ayudarte a pasar al siguiente nivel.", 'black mt-3 text-center f12 black'),
                d(
                    $referencias_ ,'mt-5 text-center'
                )            ,
                d(
                    $referencias_en_facebook ,"mt-3 text-center"
                )            
            )
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
