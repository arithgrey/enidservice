<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");
    }

    function get_format_pago()
    {

        $str = _d(
            d(_titulo("Ciclo de venta en Marketplace usando whatsApp bussines y página web"), 'mb-2 mt-4'),

            _text(hr()),
            _text(
                d(
                    _text("1.-", strong("Instala WHATSAPP BUSINESS EN TU CELULAR")),
                    'mt-4'
                )
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_1.jpeg")
                ),

            ),
            _text(
                d(_text("2.-", strong("Agrega artículos a tu catálogo de productos de whatsApp business")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_2.jpeg")
                ),
            ),
            hr()
            ,
            _text(
                d(_text("3.-", strong("Publica tu artículo en el Marketplace de Facebook")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_3.jpeg")
                ),
            ),
            hr()
            ,
            _text(
                d(_text("4.-", span("
                Envía de forma masiva las características y precio del artículo
                a los prospectos y pide en el mensaje que te indiquen sus Alcaldías y colonias
                para indicarles sus costo de entrega
                , 
                no cometas el error de enviar respuesta 1 a 1 de los clientes, 
                marketplace de Facebook ya cuenta con la opción 
                de enviar una misma respuesta a muchos 
                clientes
                ", "red_enid strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_4.jpeg")
                ),
            ),

            hr()
            ,
            _text(
                d(_text("5.-", span("Indica el costo de entrega
                 a las personas que proporcionaron su su alcaldía e invitalos a 
                 realizar su compra el mismo día", " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_5.jpeg")
                ),
            ),

            hr()
            ,
            _text(
                d(_text("6.-", span("Si el cliente está listo para hacer su pedido
                 solicita su ubicación compartida a través de whatsApp 
                 más su nombre y datos de referencia de su domicilio, estos datos
                 será usados para agendar el pedido en nuestra pagina web con la finalidad de que
                 el equipo de reparto pueda entregar", " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_6.jpeg")
                ),
            ),
            hr()
            ,
            _text(
                d(_text("7.-", span("Por último confirma el pedido e 
                indica que sus artículos serán entregados en un aprox de 1
                 hora con 30 a partir de ese último mensaje y que el equipo de 
                 reparto le hablará ya que esté de camino", " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_7.jpeg")
                ),
            ),

            hr()
            ,
            _text(
                d(_text("8.-", span("Agradece la compra y envía 
                tu catálogo, de esta forma el sabrá que tienes 
                más opciones y que somos los indicados para ello", 
                " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_8.jpeg")
                ),
            ),

            hr()
            ,
            _text(
                d(_text("9.-", span("Al pasar el tiempo te darás cuenta que hay muchas personas 
                que solicitan información y dejan de contestar, en este punto ocuparemos nuevamente
                 la opción de envió de mensajes masivos del marketplace de Facebook para la posible recuperación de clientes, 
                 ve a tu whatsApp y copia el link del catálogo de tus productos.
                ", 
                " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_10.jpeg")
                ),
            ),

            hr()
            ,
            _text(
                d(_text("10.-", span("Invita a las personas que no han dado respuesta 
                a tu mensaje a observar tu catálogo", 
                " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_11.jpeg")
                ),
            ),
            hr()
            ,
            _text(
                d(_text("11.-", span("Espera mensajes de compra de clientes que antes no vieron tu cotización! e inicia de nuevo el ciclo de venta", 
                " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_12.jpeg")
                ),
            ),
            hr()
            ,
            _text(
                d(_text("12.-", span("Listo concreta ventas ahora en whatsApp business", 
                " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_13.jpeg")
                ),
            ),            
            hr()
            ,
            _text(
                d(_text("13.-", span("Aquí les dejo el diagrama de flujo que representa el ciclo completo!", 
                " strong")), 'mt-5'),                
            ),
            _text(
                img(
                    _text("../img_tema/productos/vender_whatsApp_14.jpeg")
                ),
            ),

        );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");
        


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
