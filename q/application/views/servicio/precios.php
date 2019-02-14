<?php 
    
    $text_costo_envio           =   "COSTO DE ENVÍO $". $costo_envio["costo_envio_vendedor"]."MXN";
    $icon_envio                 =   icon('fa fa fa-pencil');
    $text_costo_envio_config    =   $icon_envio. $costo_envio["text_envio"]["ventas_configuracion"];      
    $costo_envio_cliente        =   $costo_envio["text_envio"]["cliente"];      
    $text_comision_venta        =   "COMISIÓN POR VENTA" . $comision ."MXN";    
    $text_envios_mayoreo        =   "¿TAMBIÉN VENDES ESTE PRODUCTO A PRECIOS DE MAYOREO?";       

    $i_precio_unidad            =   icon('fa fa-pencil');
    $text_precio_unidad         =   $i_precio_unidad. "PRECIO POR UNIDAD: $". $precio . "MXN";





?>

<div class='seccion_precio_por_unidad contenedor_inf_servicios'>    

    <?=get_form_costo_unidad($precio ,$text_precio_unidad)?>

    
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
        <?=heading_enid("¿EL PRECIO INCLUYE ENVÍO?" , 4 )?>
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

    <?=get_btw(heading_enid($text_comision_venta , 4 ) ,  heading_enid("GANANCIA FINAL ". $utilidad ."MXN" ) , "contenedor_inf_servicios contenedor_inf_servicios_precios_finales")?>
    <?=hr()?>
    <?php if($flag_servicio == 0 ):?>
        <div class="contenedor_inf_servicios seccion_ventas_mayoreo top_50">
            <?=heading_enid($text_envios_mayoreo ,4 )?>
            <?=get_seccion_ventas_mayoreo($venta_mayoreo)?>
        </div>
        <div class="contenedor_pago_ml top_50">
            <?=heading_enid("¿CUENTAS CON ALGÚN ENLACE DE PAGO EN MERCADO LIBRE?" ,4 )?>
            <?=input([   
                "type"      =>    "url" , 
                "name"      =>    "url_mercado_libre" ,                 
                "class"     =>    "form-control url_mercado_libre" , 
                "value"     =>    $url_ml
            ] , 
            1);            
            ?>
            <?=guardar("GUARDAR", ["class" => "btn_url_ml "])?>
        </div>

    <?php  endif;?>