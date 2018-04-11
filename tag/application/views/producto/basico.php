<?php
    $list ="";  
    $flag =0;    
        
        $nombre_servicio =  $servicio["nombre_servicio"];             
        $id_servicio  =  $servicio["id_servicio"];        
        
        
        $flag_envio_gratis =  $servicio["flag_envio_gratis"];
        $text_extra =  is_servicio($servicio);        
        
        $url_img  = $url_request."imgs/index.php/enid/imagen_servicio/".$id_servicio;        
        $url_img_error  = $url_img;
        if ($servicio["in_session"] ==  1) {
            $url_img_error  = $url_request."img_tema/portafolio/producto.png";    
        }
        $metakeyword =  $servicio["metakeyword"];
        
        
        $color =  isset($servicio["color"]) ? $servicio["color"] : "";
        $flag_servicio =  $servicio["flag_servicio"];
        
    
        $precio =  $servicio["precio"];           
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

        $url_info_producto =  "../producto/?producto=".$id_servicio.$extra_url;
        $url_venta ="http://enidservice.com/inicio/producto/?producto=".$id_servicio.$extra_url;
    
                            
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
        
        
?>

<div class="contenedor-articulo" >
                            <div class="card">
                                <center>
                                    <div class="card-imagen">
                                        <a href="<?=$url_info_producto?>" >     
                                                <img 
                                                src="<?=$url_img?>"          
                                                alt="<?=$metakeyword?>" 
                                                title="Ver artículo"
                                                onerror="this.src='<?=$url_img_error?>'" 
                                                style="width: 82%;height: 80%;margin-top: 10px;"> 
                                        </a>
                                    </div>
                                </center>
                                <div class="card-block">            
                                    <div class="row" style="position:relative;">         
                                        <?php if($in_session ==  1):?>
                                            <?=valida_botton_editar_servicio(
                                                $servicio , 
                                                $id_usuario_registro_servicio);?>
                                        <?php endif; ?>                                    
                                        
                                        <table style="width: 100%;border-bottom: 1px dotted grey;font-size: .8em;height:20px;">
                                            <tr>
                                                <td>
                                                    <?=get_numero_colores($color,
                                                        $flag_servicio,
                                                        $url_info_producto)?>        
                                                </td>
                                                <td class="text-right">
                                                    <?=get_en_existencia(
                                                        $existencia,
                                                        $flag_servicio,
                                                        $in_session)?>        
                                                </td>
                                            
                                            </tr>
                                        </table>

                                        <?=get_text_nombre_servicio($nombre_servicio)?>

                                        <?=n_row_12()?>
                                            <div style="position:absolute;bottom:120px;">
                                                            <?=get_precio_producto(
                                                            $url_info_producto ,  
                                                            $precio,
                                                            $costo_envio,
                                                            $flag_servicio,
                                                            $id_ciclo_facturacion)?>
                                                                                                      
                                            </div>
                                        <?=end_row()?>
                                        <?php if($flag_servicio ==  0):?>
                                            <?=n_row_12()?>
                                                <div style="font-size: .8em;" class="strong">
                                                    <?=$costo_envio?>
                                                </div>    
                                            <?=end_row()?>
                                        <?php endif; ?>                                    
                                        <?=n_row_12()?>
                                            
                                            <?=muestra_vistas_servicio($in_session,$vista)?>
                                        <?=end_row()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                                             
            