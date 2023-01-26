<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");
    }

    function get_format_pago()
    {

        $str = _d(
            d(_titulo("¿CÓMO ES EL PROCESO DE DEVOLUCIÓN DE UN PEDIDO?"), 'mb-2 mt-5'),
            _text(
                d(
                    "Recuerda que cuentas con 15 días a partir de la entrega de tu 
                    pedido para iniciar un proceso de devolución. 
                    A continuación encontrás los pasos para realizar un proceso de devolución o cambio en Enid Service:
 
                    ",
                    [
                        "class" => 'mt-5 black strong'
                    ]
                ),
                d(
                    "1) Tu pedido debe estar nuevo, con etiquetas/empaque original. No hay cambio de seguros para ajustar las mancuernas",
                    [
                        "class" => 'mt-5 black '
                    ]
                ),

                d(
                    "2)Identifica qué tipo de solicitud deseas realizar:",
                    [
                        "class" => 'mt-5 black '
                    ]
                ),
                d(
                    "- Devolución de producto para reembolso (Retracto de compra)",
                    [
                        "class" => 'black mt-3'
                    ]
                ),
                d(
                    "- Cambio",
                    [
                        "class" => 'black '
                    ]
                ),


                d(
                    "3) Selecciona la forma para devolver tu paquete de acuerdo a tus necesidades. 

                            ",
                    [
                        "class" => 'black mt-5'
                    ]
                ),

                d(
                    "- Pick up: nuestro socio logístico acudirá a tu domicilio para recoger el paquete(Tendrá un costo de 100 pesos) o ",
                    [
                        "class" => 'black mt-3'
                    ]
                ),
                d(
                    "- Drop off: podrás llevarlo directamente a la sucursal de nuestro socio logístico más cercana 
                                ",
                    [
                        "class" => 'black mt-1'
                    ]
                ),
                d(
                    "4) Una vez el socio logístico reciba tu devolución, será enviada a nuestro almacén para validar las condiciones del artículo(s), 
                    en caso den o cumplir con las condiciones te retornaremos tu artículo.",

                    [
                        "class" => 'black mt-5'
                    ]
                ),
                d(
                    "5) Si tu devolución es autorizada, recibirás una notificación de que tu devolución fue exitosamente procesada.",
                    
                    [
                        "class" => 'black mt-5'
                    ]
                ),
                d(
                    "- Si elegiste el reembolso de tu dinero, este será gestionado de acuerdo al método de pago utilizado en tu compra original.
                                ",
                    [
                        "class" => 'black mt-3'
                    ]
                ),
                d(
                    "- Si elegiste cambio, este será enviado a tu domicilio en un periodo de entre 1 y 2 días después de tu solicitud
                                ",
                    [
                        "class" => 'black mt-1'
                    ]
                ),




            )
        );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");



        return d($r, 6, 1);
    }
}
