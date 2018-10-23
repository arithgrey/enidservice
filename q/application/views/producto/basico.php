<?php
        
    
    $extra_color        =   "";
    $list               =   "";  
    $flag               =   0;            
    $nombre_servicio    =   $servicio["nombre_servicio"];             
    $id_servicio        =   $servicio["id_servicio"];        
    $flag_envio_gratis  =   $servicio["flag_envio_gratis"];
    $text_extra         =   is_servicio($servicio);        
    $url_img            =   $url_request."imgs/index.php/enid/imagen_servicio/".$id_servicio;                
    $metakeyword        =   $servicio["metakeyword"];        
    $color              =   array_key_exists("color", $servicio) ? $servicio["color"] : "";
    $flag_servicio      =   $servicio["flag_servicio"];        
    $precio             =   $servicio["precio"];           
    $costo_envio ="";
    if($flag_servicio == 0){
        $costo_envio =  $servicio["costo_envio"]["text_envio"]["cliente_solo_text"];                 
    } 
    $id_ciclo_facturacion =  $servicio["id_ciclo_facturacion"];
        
    $extra_url =  "";
    if($servicio["in_session"] == 1){
            
        $id_usuario = get_info_variable($servicio , "id_usuario" );
        $id_usuario =  ($id_usuario ==  0 ) ? "": $id_usuario;            
        $extra_url =  "&q2=".$id_usuario;                            
        $id_usuario_registro_servicio =  $id_usuario;            
    }

    $url_info_producto  =  "../producto/?producto=".$id_servicio.$extra_url;
    $url_venta          =  get_url_venta($id_servicio.$extra_url); 
    
    
    $extra_flag_1 ="";
    $extra_flag_2 ="";
    $extra ="";
    $flag =0;
    if($flag == 4){            
            $extra_flag_1 ="<div class='row'>";
            $extra_flag_2 ="</div><hr>";
            $flag =0;
        }
        $flag ++;

        $existencia =0;
        $vista =0;
        $in_session =  $servicio["in_session"];
        if($in_session ==  1){
            $existencia =  $servicio["existencia"];     
            $vista =  $servicio["vista"];
        }
        
        $atributos_imagen = 
            [
                'src'   => $url_img, 
                'title' => 'Ver artículo', 
                'class' => 'imagen_producto',
                'alt'   => $metakeyword,
                'onerror' => "this.onerror=null;this.src='".$url_img."';"
            ];
        $img =  img($atributos_imagen);                          
        
?>
<div class='info_producto'>
    <?=div(
    get_precio_producto($url_info_producto,$precio,$costo_envio,$flag_servicio, $id_ciclo_facturacion) ,
    ["style"=>"position:absolute;top:180px;margin-left:5px;z-index: 100"],
    1)?>
    
    <?=div(anchor_enid($img ,  ["href"=> $url_info_producto ]),
    ["class"    =>  'contenedor_principal_imagen_producto'],
    1)?>
            
    <div class='contenedor_principal_informacion_producto card-block' >
        <div style="position:relative;">                             
            <?php if($in_session ==  1):?>
                <?=div(
                valida_botton_editar_servicio($servicio,
                    $id_usuario_registro_servicio) , 
                    [] ,
                    1)?>
            <?php endif; ?>
            <?=n_row_12()?>
            <table class='resumen_colores_producto'>
                <tr>
                    <?=get_td(get_numero_colores($color, 
                                $flag_servicio,
                                $url_info_producto , 
                                $extra_color))?>

                    <?=get_td(get_en_existencia($existencia,$flag_servicio,$in_session))?>
                </tr>
            </table>
            <?=end_row()?>
            
            <?=div(div(
            get_text_nombre_servicio($nombre_servicio), 
            ["style"=>"margin-left: 5px;text-align: left!important;"]),
            [] ,
            1
            )?>
            <?=div(muestra_vistas_servicio($in_session,$vista) , [] , 1)?>
            
        </div>
    </div>
    <?php if($flag_servicio ==  0):?>
        <?=div(
        $costo_envio ,
        ["class"=>'informacion_costo_envio'] ,
        1)?>        
    <?php endif; ?>                                    
</div>                                        