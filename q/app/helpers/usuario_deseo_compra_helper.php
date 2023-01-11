<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function agregados($carros_compras)
    {

        $response[] = d(
            d("Personas SIN registro con productos en el carrito de compras",'borde_end col-sm-12')
            ,
            "row mt-3 mb-3"
        );


        $ips_usuarios = array_column($carros_compras, "ip");
        $prospectos = array_count_values($ips_usuarios);

        foreach ($prospectos as $ip_usuario => $valor) {
           
            $imgs = articulos_en_carro_usuario_imagenes($ip_usuario, $carros_compras);
            $fechas = fecha_en_carros_compras($ip_usuario, $carros_compras);
            $eliminar= icon(
                _text_(_eliminar_icon,'cancela_deseo_compra_carro_ip'),
                ["id" => $ip_usuario]
            );
            $elementos = [          
                d($eliminar,1),
                d($imgs,7),                
                d($fechas,4)
            ];

            $response[] = d($elementos,'row border-bottom text-center mt-2');

        }
        return append($response);


    }
    function fecha_en_carros_compras($ip_usuario_busqueda, $carros_compras){
        $response  = [];
        foreach($carros_compras as $row){

            $ip_usuario = $row["ip"];
            
            if($ip_usuario_busqueda == $ip_usuario){

                $fecha_registro = $row["fecha_registro"];
                $fecha = horario_enid();
                $hoy = $fecha->format('Y-m-d');
                $dias = date_difference($hoy, $fecha_registro);



            $response[] = flex(
                $fecha_registro, 
                _text_('Días trasncurridos', $dias), 
                _text_(_between, "fp9")
                );
            }        
        }
        return d($response,13);
    }
    function articulos_en_carro_usuario_imagenes($ip_usuario_busqueda, $carros_compras){

        $response  = [];
        foreach($carros_compras as $row){

            $ip_usuario = $row["ip"];           
            if($ip_usuario_busqueda == $ip_usuario){
                $url_img_servicio = $row["url_img_servicio"];        
                $path_servicio = path_enid("producto", $row["id_servicio"]);

                $response[] = a_enid(img(
                    [
                        "src" => $url_img_servicio,                    
                        'class' => 'mx-auto d-block mah_50',
                        "onerror" => "this.src='../img_tema/portafolio/producto.png'",
                    ]
                ),
                [
                    "class" => 'col-xs-2', 
                    "href" => $path_servicio                    
                ]);

            }        
        }
        return d($response,13);

    }   
    function en_registro($data)
    {

        $response[] = d(
            d("Personas registradas por enviar información de entrega",12)
            ,
            "f12 row"
        );
        foreach($data as $row){
            
            $id_servicio = $row["id_servicio"];
            $articulos = $row["articulos"];            
            $id_recompensa = $row["id_recompensa"];
            $url_img_servicio = $row["url_img_servicio"];
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
                    "href" => $link_servicio                    
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
                d($fecha_registro,4),
                d($numero_articulos,4),
                d($link_imagen_servicio,4)
            ];

            $response[] = d($elementos,'row border-bottom text-center mt-2');
        }
        return append($response);


    }
}

