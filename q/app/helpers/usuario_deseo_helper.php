<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function agregados($carros_compras)
    {

        $response[] = d(
            d("Vendedores con productos
             en el carrito de compras",
             'borde_end col-sm-12')
            ,
            "row mt-3 mb-3 black"
        );

        $ids_usuarios = array_column($carros_compras, "id_usuario");
        $vendedores = array_count_values($ids_usuarios);

        foreach ($vendedores as $id_usuario => $valor) {
           
            $link_imagen_usuario = 
                imagen_vendedor_en_carro_compra(
                    $id_usuario, $carros_compras);

            $usuario_productos_en_carro = flex(
                $link_imagen_usuario, 
                _text_("Artículos",$valor),
                'flex-column',
                '',
                'black'
            );

            $imgs = articulos_en_carro_usuario_imagenes($id_usuario, $carros_compras);
            $fechas = fecha_en_carros_compras($id_usuario, $carros_compras);
            $elementos = [
                d($usuario_productos_en_carro, 3),
                d($imgs , 6),
                d($fechas,3)
            ];

            $response[] = d($elementos,'row border-bottom text-center mt-2');
            
        }

        return append($response);
        
    }
    function fecha_en_carros_compras($id_usuario_busqueda, $carros_compras){
        $response  = [];
        foreach($carros_compras as $row){

            $id_usuario = $row["id_usuario"];
            
            if($id_usuario_busqueda == $id_usuario){

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
    function articulos_en_carro_usuario_imagenes($id_usuario_busqueda, $carros_compras){

        $response  = [];
        foreach($carros_compras as $row){

            $id_usuario = $row["id_usuario"];
            $url_img_servicio = $row["url_img_servicio"];
            
            if($id_usuario_busqueda == $id_usuario){

                $response[] = d(img(
                    [
                        "src" => $url_img_servicio,                    
                        'class' => 'mx-auto d-block mah_50',
                        "onerror" => "this.src='../img_tema/portafolio/producto.png'",
                    ]
                ),'col');

            }        
        }
        return d($response,13);

    }   
    function imagen_vendedor_en_carro_compra($id_usuario_busqueda, $carros_compras){

    
        $imagen_usuario = img(
            [
                "src" => "",                    
                'class' => 'mx-auto d-block mah_50',
                "onerror" => "this.src='../img_tema/user/user.png'",
            ]
        );


        foreach($carros_compras as $row){

            $id_usuario = $row["id_usuario"];
            
            if($id_usuario_busqueda == $id_usuario){
                
                $url_img_usuario = $row["url_img_usuario"];
                $imagen_usuario = img(
                    [
                        "src" => $url_img_usuario,                    
                        'class' => 'mx-auto d-block mah_50',
                        "onerror" => "this.src='../img_tema/user/user.png'",
                    ]
                );
    
               break;

            }        
        }
         return a_enid( 
            $imagen_usuario,                
            [
                "href" => path_enid("usuario_contacto", $id_usuario),
                "target" => "_black"
            ]
        );


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
                    "href" => $link_servicio
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

