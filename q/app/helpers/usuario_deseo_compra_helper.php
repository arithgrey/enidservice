<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function agregados($data)
    {

        $response[] = d(
            d("Personas SIN registro con productos en el carrito de compras",'borde_end col-sm-12')
            ,
            "row mt-3 mb-3"
        );
        foreach($data as $row){
            
            $id =  $row["id_usuario_deseo_compra"];
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
                    "href" => $link_servicio,
                    "target" => "_blank"
                ]
            );                
            
            $fecha_registro = flex(
                        $fecha_registro, 
                        _text_('Días trasncurridos', $dias), 
                        'flex-column',
                        '',
                        'strong f11');

                        $eliminar= icon(
                            _text_(_eliminar_icon,'cancela_deseo_compra_carro'),
                            ["id" => $id]
                        );
            $elementos = [          
                d($eliminar,1),
                d($fecha_registro,7),                
                d($link_imagen_servicio,4)
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
                    "href" => $link_servicio,
                    "target" => "_blank"
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

