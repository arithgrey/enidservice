<?php 
    $flag_servicio =  entrega_data_campo($servicio , "flag_servicio");     
?>
<?=n_row_12()?>                        
    <div class="receipt-main">
        <table class="table">                            
            <tr>
                <td class="col-md-9">       
                </td>
                <td style="color: white!important" class=" col-md-3  white a_enid_blue">
                    <div>
                    <div class="text_costo">
                        <a style="color: white!important;font-size: 1.2em;">
                            <i  class="fa fa-pencil" style="margin-left: 10px;"></i>
                            PRECIO:  $ <?=$costo;?> MXN
                        </a>
                        
                    </div>                   
                    <div style="display: none;" class="input_costo">
                        <form class="form_costo">
                            <div>
                                <input type="number" name="costo" step="any" class="form-control input-sm"
                                    value="<?=$costo;?>" />
                                <span class="strong">
                                    PRECIO
                                </span>
                            </div>
                            <div>
                                <span class="place_registro_costo">                
                                </span>
                            </div>
                            <button class="btn input-sm">
                                Guardar 
                            </button>
                        </form>
                        </div>
                    </div>
                </td>
            </tr>
                                                            
            




            <tr>
                <td class="col-md-9">
                </td>
                <td class="col-md-3" style="background: #f7fafc;">
                    <div>
                        <span>
                            <strong>
                                COMISIÓN POR VENTA                             
                                <?=$comision?>MXN
                            </strong>
                        </span>
                    </div>                                                           
                </td>
            </tr>
            






            <tr>                
                    <?php if($flag_servicio == 0):?>                        
                        <td class="col-md-9">
                            <div class="contenedor_informacion_envio">                                
                                <div style="margin-top: 30px;">
                                    <div class="text_info_envio" style="font-size: 1.5em;">
                                        <?=$costo_envio["text_envio"]["ventas_configuracion"]?>
                                    </div>

                                    <div class="text_info_envio" style="margin-top: 15px;">
                                        <i class="fa fa-pencil"></i>
                                        <?=$costo_envio["text_envio"]["cliente"]?>
                                    </div>
                                </div>
                            </div>
                            <?=n_row_12()?>
                                <div class="input_envio" style="display: none;margin-top: 20px;">
                                    <div>                                        
                                        <div style="font-size: 1.5em;">
                                            ¿EL PRECIO INCLUYE ENVÍO?                                        
                                        </div>

                                        <select class="form-control input_envio_incluido" >
                                            <option value="0">
                                                No, que se cargue al cliente
                                            </option>
                                            <option value="1">
                                                Si - yo pago el envío
                                            </option>
                                        </select>
                                            <div>
                                                <button class="btn input-sm btn_guardar_envio">
                                                    Guardar 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            <?=end_row()?>
                        </td>
                    <?php endif; ?>
                                                                    
                    <?php if($flag_servicio == 0): ?>
                        <td class="col-md-3 " style="background: #f7fafc;">
                            <div>   
                                <strong>
                                    COSTO DE ENVÍO $<?=$costo_envio["costo_envio_vendedor"]?>MXN
                                </strong>                             
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>    
                <tr>
                    <td class="col-md-9">
                    </td>
                    <td class="col-md-3 " style="background: #012645;color: white;">
                        <center>
                            <div>
                                <span  style="font-size: 2em;">
                                    $<?=$utilidad;?>MXN
                                </span>
                            </div>
                            <div style="margin-top: 5px;font-size: 1.5em;" class="strong">
                                GANANCIA FINAL
                            </div>
                        </center>
                    </td>
                </tr>
            </table>
                </div>                    
            <?=end_row()?>

