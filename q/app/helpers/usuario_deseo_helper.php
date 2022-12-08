<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function agregados($data)
    {

        $response[] = d(
            d("Personas con registro con productos en el carrito de compras",'borde_end col-sm-12')
            ,
            "row mt-3 mb-3 black"
        );
        foreach($data as $row){

            $id_usuario = $row["id_usuario"];
            $id_servicio = $row["id_servicio"];
            $articulos = $row["articulos"];
            $id = $row["id"];
            $id_recompensa = $row["id_recompensa"];
            $url_img_servicio = $row["url_img_servicio"];
            $url_img_usuario = $row["url_img_usuario"];
            $fecha_registro = $row["fecha_registro"];
            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $dias = date_difference($hoy, $fecha_registro);



            $imagen_servicio = img(
                [
                    "src" => $url_img_servicio,                    
                    'class' => 'mx-auto d-block mah_50',
                    "onerror" => "this.src='../img_tema/portafolio/producto.png'",
                ]
            );

            $link_servicio = path_enid("producto", $id_servicio);
            $link_imagen_servicio = a_enid(
                $imagen_servicio,
                [
                    "href" => $link_servicio,
                    "target" => "_blank"
                ]
            );

            $imagen_usuario = img(
                [
                    "src" => $url_img_usuario,                    
                    'class' => 'mx-auto d-block mah_50',
                    "onerror" => "this.src='../img_tema/user/user.png'",
                ]
            );

            $link_imagen_usuario = a_enid( 
                $imagen_usuario,                
                [
                    "href" => path_enid("usuario_contacto", $id_usuario),
                    "target" => "_black"
                ]
            );


            
            $numero_articulos=  _text_('Artículos', $articulos );
            $fecha_registro = flex(
                        $fecha_registro, 
                        _text_('Días trasncurridos', $dias), 
                        'flex-column',
                        '',
                        'strong f11');
            $elementos = [
                d($fecha_registro, 3),
                d($link_imagen_usuario, 3),
                d($numero_articulos,3),
                d($link_imagen_servicio,3)
            ];

            $response[] = d($elementos,'row border-bottom text-center mt-2');
        }
        return append($response);


    }
    function en_registro($data)
    {

        $response[] = d(
            d("Personas registradas por enviar información de entrega",12)
            ,
            "f12 row"
        );
        foreach($data as $row){

            $id_usuario = $row["id_usuario"];
            $id_servicio = $row["id_servicio"];
            $articulos = $row["articulos"];
            $id = $row["id"];
            $id_recompensa = $row["id_recompensa"];
            $url_img_servicio = $row["url_img_servicio"];
            $url_img_usuario = $row["url_img_usuario"];


            $fecha_registro = $row["fecha_registro"];
            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $dias = date_difference($hoy, $fecha_registro);



            $imagen_servicio = img(
                [
                    "src" => $url_img_servicio,                    
                    'class' => 'mx-auto d-block mah_50',
                    "onerror" => "this.src='../img_tema/portafolio/producto.png'",
                ]
            );

            $link_servicio = path_enid("producto", $id_servicio);
            $link_imagen_servicio = a_enid(
                $imagen_servicio,
                [
                    "href" => $link_servicio,
                    "target" => "_blank"
                ]
            );

            $imagen_usuario = img(
                [
                    "src" => $url_img_usuario,                    
                    'class' => 'mx-auto d-block mah_50',
                    "onerror" => "this.src='../img_tema/user/user.png'",
                ]
            );

            $link_imagen_usuario = a_enid( 
                $imagen_usuario,                
                [
                    "href" => path_enid("usuario_contacto", $id_usuario),
                    "target" => "_black"
                ]
            );


            
            $numero_articulos=  _text_('Artículos', $articulos );
            $elementos = [
                d(
                    flex(
                        $fecha_registro, 
                        _text_('Días trasncurridos', $dias), 
                        'flex-column',
                        '',
                        'strong f11')
                    , 3),
                d($link_imagen_usuario, 3),
                d($numero_articulos,3),
                d($link_imagen_servicio,3)

            ];

            $response[] = d($elementos,'row border-bottom text-center mt-2');
        }
        return append($response);


    }
}

