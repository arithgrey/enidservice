<?php 
    $flag_servicio =  entrega_data_campo($servicio , "flag_servicio");     
?>

<?=n_row_12()?>                        
    <div class='contenedor_inf_servicios'>                            
                    <?=n_row_12();?> 
                        <div class='col-lg-6'>
                            <div class="row">                                
                                <div class='col-lg-12'>
                                    <div class="row">
                                            <?=n_row_12()?>               
                                                <div class="text_costo">
                                                    <a class="a_precio_unidad">         
                                                        <div>
                                                            PRECIO POR UNIDAD:                
                                                        </div>
                                                        <div>
                                                            $ <?=$precio;?> MXN
                                                        </div>
                                                        <i  class="fa fa-pencil">
                                                        </i>
                                                    </a>
                                                </div>                   
                                            <?=end_row()?>
                                            <?=n_row_12()?>               
                                                <div style="display: none;" class="input_costo">
                                                    <form class="form_costo">
                                                        <div>
                                                            <input type="number" name="precio" step="any" class="form-control input-sm"
                                                                value="<?=$precio;?>" />
                                                            <span class="strong">
                                                                PRECIO
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="place_registro_costo">                
                                                            </span>
                                                        </div>
                                                        <button class="btn_precio_servicio">
                                                            Guardar 
                                                        </button>
                                                    </form>
                                                </div>        
                                            <?=end_row()?>  
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class='col-lg-6'>
                            <div class="row">                                
                                <div class='col-lg-12'>
                                    <div class="row">
                                        <?php if($flag_servicio == 0  ): ?>
                                            <?=n_row_12()?>                        
                                                <div class="informacion_costo informacion_costo_envio">
                                                        COSTO DE ENVÍO 
                                                        $<?=$costo_envio["costo_envio_vendedor"]?>MXN                                
                                                </div>                        
                                            <?=end_row()?>
                                        <?php endif; ?>
                                        <?php if($flag_servicio == 0 ):?>
                                            <?=n_row_12()?>
                                                <div class="contenedor_informacion_envio">

                                                    <div class="text_info_envio">
                                                        <?=strtoupper($costo_envio["text_envio"]["ventas_configuracion"])?>
                                                    </div>

                                                    <div class="text_info_envio text_info_envio_editable">
                                                        <i class="fa fa-pencil"></i>
                                                        <?=$costo_envio["text_envio"]["cliente"]?>
                                                    </div>                                    
                                                </div>
                                            <?=end_row()?>
                                            <?=n_row_12()?>
                                                <div class="input_envio" 
                                                    style="display: none;margin-top: 20px;">
                                                    <div>                                        
                                                        <div style="font-size: 1.5em;">
                                                            ¿EL PRECIO INCLUYE ENVÍO?                                        
                                                        </div>

                                                        <select class="form-control input_envio_incluido" >
                                                            <option value="0">
                                                                No, QUE SE CARGUE AL CLIENTE
                                                            </option>
                                                            <option value="1">
                                                                Si - YO PAGO EL ENVIO
                                                            </option>
                                                        </select>
                                                            <div>
                                                                <button class="btn input-sm btn_guardar_envio">
                                                                    GUARDAR
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?=end_row()?>
                                        
                                        <?php endif; ?>
                                                                                    
                                       
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    <?=end_row();?>                    
    </div>
<?=end_row()?>

<?=n_row_12()?>                        
    <div class="contenedor_inf_servicios contenedor_inf_servicios_precios_finales">
                <?=n_row_12()?>
                    <div class="info_comision_venta_total">
                        COMISIÓN POR VENTA                             
                        <?=$comision?>MXN                                                    
                    </div>                
                <?=end_row()?>
                <?=n_row_12()?>
                    <div class="info_ganancia">
                        
                            <div>
                                <span  style="font-size: 2em;">
                                    <?=$utilidad;?>MXN
                                </span>
                            </div>
                            <div style="margin-top: 5px;font-size: 1.5em;" class="strong">
                                    GANANCIA FINAL
                            </div>
                        
                    </div>
                <?=end_row()?>
    </div>                    
<?=end_row()?>

