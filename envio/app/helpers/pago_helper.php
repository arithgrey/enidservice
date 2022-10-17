<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_orden($data)
    {

        return d($data, "col-lg-8 col-lg-offset-2 contenedor_principal_enid");
    }

    function get_format_pago()
    {

        $str = _d(
            d(_titulo("ENVÍO DE PEDIDOS ENID SERVICE"), 'mb-2 mt-4'),
            _text(
                _titulo("Nos caracterizamos por 
                cobrar al momento de que recibas tus 
                artículos en tu domicilio y ofrecemos la oportunidad de que 
                recibas tu pedido el mismo día que lo solicitas siempre y cuando 
                tu orden cumpla con las siguientes condiciones", 5)
            ),
            _text(hr()),
            _text(
                d(
                    _text("1.-", strong("Estar ubicado en CDMX ")),
                    'mt-4'
                )
            ),
            _text(
                d(_text("2.-", strong("Agendar tu pedido en un horario de 8AM a 5PM")), 'mt-5')
            ),

            _text(

                d("El tiempo promedio de entrega una vez que realices tu pedido es de 1 hora con 30 minutos, este tiempo puede aumentar o bajar de acuerdo a 
                la distancia entre tu ubicación y nuetro centro de distribución, en cuanto uno de nuestros 
                repartidores 
                esté por salir a entregarte tu pedido te marcará e indicará el tiempo en que llegará, es importante que
                recibas la llamada para que tu entrega pueda ser efectuada")
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
            ),

            d(
                format_link(
                    "Costos de entrega",
                    [
                        "href" => path_enid("clientes"),
                        "target" => "_black",
                        "class" =>  "mt-3"
                    ]
                )
            )



        );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");



        return d($r, 6, 1);
    }
}
