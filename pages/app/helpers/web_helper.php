<?php 

    function test_web($url ,  $codigo, $es_url_valida)
    {

        $http_status = 
        [
            200 => 'Es 200 puede responder sin problemas', 
            400 => 'Error 400 Bad Request literalmente Petición o Solicitud Incorrecta',
            401 => 'error de inicio de sesión',
            403 => '403 Indica que el servidor ha recibido y 
            ha entendido la petición, pero rechaza enviar una respuesta',
            404 => 'Indica que el recurso no está disponible en el servidor',
            405 => 'El método requerido es conocido por el servidor, 
            pero no es soportado por la fuente objetivo',
            500 => 'Error Interno del Servidor',
            503 => 'El servidor no está listo para manejar la solicitud'
        ];

        
        $link = a_enid($url, 
            [
                'href' =>$url , 
                'target' => '_blank',
                'class' => 'black'
            ]
        );

        $response[]= d($link, 'display-6', 12);                     
        $response[]= d(_text_('Es url valida' , $es_url_valida), 12);                     
        $response[]= d(_text_('Código' , $codigo), 12);            
        $response[]= d(_text_('Detalle' , $http_status[$codigo]), 12);            

    
        $class = ($codigo > 200) ? 
        'col-lg-12 red_enid border-bottom ' : 'border-bottom col-lg-12 ';
        return d(d($response, $class),6,1);

    }
