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
            d(_titulo("FAQ que nadie te dió 🫡😎 (no para frágiles)", 0), 'mb-2 mt-5'),
            d(
                " SI ERES SENSIBLE Y LAS QUIERES, SOLO ACTUA Y HAZ TU PEDIDO, no leas esto",
                'f14 text-uppercase  mt-5 mb-5 p-3 black borde_end  shadow font-weight-bold p-2  d-block'
            ),


            _text(
                    d(
                    "1.- ¿Carísimas?",
                    [
                        "class" => 'mt-5 black strong  hover_bg_black f12'
                    ]
                    ),
                    d("Na! más bien tienes mente pobre, más caras tus 🍻 chelas que te metes cada semana 😜",'f12 mt-2 black'),
                    d(hr()),
                    
                ),

            _text(
                d(
                "2.- Lo que escribimos:",
                [
                    "class" => 'mt-5 black strong  hover_bg_black f12'
                ]
                ),
                d("✅ Si no te agradan las compras en línea, en CDMX tenemos la capacidad de entregarte y que pagues al recibir tu equipo en tu domicilio",'f12 mt-2 black'),
                d(
                    "Lo que en verdad te queremos decir:",
                    [
                        "class" => 'mt-5 black strong  hover_bg_black f12'
                    ]
                    ),
                d("Haz tu pedido en línea. Ya es 2023 y sigues con tus pensamientos vieja escuela 👴🏽. En la Ciudad de México no hay bronca, 
                es nuestra propuesta de valor que te las entreguemos en tus manitas 👐🏻 y pagues al recibirlas. Pero en otro estado te las enviamos 🚚. Ni modo que fueras tan especial para visitarte 🪿.",'f12 mt-2 black')
                ,
                d(hr()),
                
        ),  
        _text(
            d(
            "3.- Esas pesas son muy feas...",
            [
                "class" => 'mt-5 black strong  hover_bg_black f12'
            ]
            ),
            d("Bueno pero... ¿no las vas a besar verdad? o ¿si? 😱 ",'f12 mt-2 black'),
            d(hr()),
            
        ),
        _text(
            d(
            "4.- ¿Tienen referencias?",
            [
                "class" => 'mt-5 black strong  hover_bg_black f12'
            ]
            ),
            d("Obvio 😎 ¿y tu? 😱😢 ",'f12 mt-2 black'),
            d(hr()),
            
        ),
        _text(
            d(
            "5.- ¿De que estan hechas?",
            [
                "class" => 'mt-5 black strong  hover_bg_black f12'
            ]
            ),
            d("De oro 💰 para el cliente lo que pida 🫡 estamos a tus órdenes",'f12 mt-2 black'),
            d(hr()),
            
        ),
        _text(
            d(
            "6.- ¿Todo Facebook tiene anunciadas esas pesas?",
            [
                "class" => 'mt-5 black strong  hover_bg_black f12'
            ]
            ),
            d(
                _text_(
                    "Seee ... hay mucho falto de creatividad robando 🐁🐀 las imágenes, mejor pídelas",
            a_enid("aquí",["href"=>"http://m.me/enidservicemx","class"=>"black strong"],0),'ó' , 
            a_enid("aquí",["href"=>"https://instagram.com/enid_service?igshid=OGQ5ZDc2ODk2ZA%3D%3D&utm_source=qr","class"=>"strong black"],0)
        ),'f12 mt-2 black'),
            d(hr()),
            
        ),
        _text(
            d(
            "¿No le gustaron nuestras FAQ a su señoría? 🤴🫅",
            [
                "class" => 'mt-5 black strong  hover_bg_black f12'
            ]
            ),
            d(
                _text_(
                    "Disculpe por no usar la hipocresía que se emplea cada que le venden funkibasuras 😎, puede retirarse👋",
            
        ),'f12 mt-2 black'),
            d(hr()),
            
        ),

           

        );

        $r[] = d($str, " d-flex flex-column justify-content-between mh_300");



        return d($r, 6, 1);
    }
}
