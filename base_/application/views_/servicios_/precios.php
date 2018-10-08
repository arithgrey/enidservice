<?php 
    
    $text_costo_envio           =   "COSTO DE ENVÍO $". $costo_envio["costo_envio_vendedor"]."MXN";
    $icon_envio                 =   icon('fa fa fa-pencil');
    $text_costo_envio_config    =   $icon_envio. $costo_envio["text_envio"]["ventas_configuracion"];      
    $costo_envio_cliente        =   $costo_envio["text_envio"]["cliente"];      
    $text_comision_venta        =   "COMISIÓN POR VENTA" . $comision ."MXN";    
    $text_envios_mayoreo        =   "¿TAMBIÉN VENDES ESTE PRODUCTO A PRECIOS DE MAYOREO?";   
    
    $btn_ventas_mayoreo 
        = anchor_enid( "SI", 
            [
            "id"       => '1',
            "class"     => 'button_enid_eleccion venta_mayoreo '.
            $activo_ventas_mayoreo
            ] ,
            1);

    $btn_ventas_no_mayoreo 
        =  anchor_enid("NO" , 
            [
            "id"    =>  '0' ,
            "class" =>  
            'button_enid_eleccion venta_mayoreo '.$baja_ventas_mayoreo
            ], 
            1 );

    
    $i_precio_unidad        = icon('fa fa-pencil');     
    $text_precio_unidad     =  $i_precio_unidad. "PRECIO POR UNIDAD: $". $precio . "MXN";
    $input_precio_unidad    = input([   
                "type"      =>    "number" , 
                "name"      =>    "precio" , 
                "step"      =>    "any" , 
                "class"     =>    "form-control col-lg-6" , 
                "value"     =>    $precio 
            ] , 1);

    $place_precio_unidad    =  div("" , ["class"=>"place_registro_costo"] , 1); 


?>

<div class='seccion_precio_por_unidad contenedor_inf_servicios'>    
    <?=heading_enid("PRECIO POR UNIDAD", 
        4 ,
        ['class' => ''],
        1)?>

    <?=anchor_enid( 
        $text_precio_unidad, 
        ["class"    =>  "a_precio_unidad text_costo informacion_precio_unidad"],
        1);?>

    <?=form_open('', ['class'=> 'form_costo input_costo contenedor_costo'])?>
        <?=heading_enid("PRECIO POR UNIDAD",4 , [] , 1)?>        
        <table class="row">
            <tr>
                <?=get_td(div($input_precio_unidad . $place_precio_unidad  , [] ) ,  
                [ 'class' => 'col-lg-9'])?>
                <?=get_td(guardar("GUARDAR" , [] ) , [ 'class' => 'col-lg-3'])?>
            </tr>
        </table>
    <?=form_close()?>
    

    
    <?php if($flag_servicio == 0  ): ?>        
    <div class="contenedor_informacion_envio seccion_informacion_envio">            
        <?=heading_enid("COSTO DE ENVÍO", 
            4 ,
            ['class'=>'costo_envio_text'],
            1)?>

        <?=div(
            $text_costo_envio_config ,
            ["class"=>"text_info_envio"] 
            , 
            1 
        );?>        
        <?=div(
            $costo_envio_cliente, 
            ["class" => "text_info_envio text_info_envio_editable"]
        )?>
    </div>
    <div class="input_envio config_precio_envio">            
        <?=heading_enid("¿EL PRECIO INCLUYE ENVÍO?" , 4, [] , 1 )?>            
        <div class="row">
            <div class="col-lg-9">
                <select class="input_envio_incluido form-control" >
                    <option value="0">NO, QUE SE CARGUE AL CLIENTE
                    </option>
                    <option value="1">SI - YO PAGO EL ENVIO
                    </option>
                </select>            
            </div>    
            <?=guardar('GUARDAR' , ["class"=>"btn_guardar_envio col-lg-3"])?>
        </div>
    </div>
    <?php endif; ?>

</div>        
    <div class="contenedor_inf_servicios contenedor_inf_servicios_precios_finales">        
        <?=heading_enid($text_comision_venta , 4 , [], 1)?>
        <?=heading_enid("GANANCIA FINAL ". $utilidad ."MXN" , 1 ,[] , 1)?>
    </div>                    
    <hr>
    <?php if($flag_servicio == 0 ):?>
        <div class="contenedor_inf_servicios seccion_ventas_mayoreo">
            <?=heading_enid($text_envios_mayoreo ,4 , [],1)?>
            <table class="seccion_ventas_mayoreo_table">
                <tr>
                   <?=get_td($btn_ventas_mayoreo , 
                    ['class' => 'btn-ventas-mayoreo col-lg-6'])?> 
                   <?=get_td($btn_ventas_no_mayoreo ,
                   ['class' => 'btn-ventas-mayoreo col-lg-6'])?>
                </tr>
            </table>            
        </div>
    <?php  endif;?>