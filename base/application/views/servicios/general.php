    <?=n_row_12()?>                        
        <div class="text_nombre_servicio">
            <span style="font-size: 1.3em;" class="strong">
                <?=$tipo_promocion;?>
            </span>            
            <span>
                <?=entrega_data_campo( $servicio, "nombre_servicio");?>
            </span>
            <i class="fa fa-pencil text_nombre_servicio" style="margin-left: 10px;">
            </i>
        </div>
        <div style="display: none;" class="input_nombre_servicio_facturacion">
            <form class="form_servicio_nombre_info">
                <span style="font-size: 1.3em;" class="strong">
                    <?=$tipo_promocion;?>
                </span>            
                <div>                            
                    <input type="hidden" name="q" value="nombre_servicio">
                    <input 
                    type="text" 
                    name="q2" 
                    class="nuevo_producto_nombre"
                    onkeyup="transforma_mayusculas(this)"
                    value="<?=entrega_data_campo($servicio,'nombre_servicio')?>" 
                    required>
                </div>    
                <div>
                    <button class="btn input-sm">
                        Guardar 
                    </button>
                </div>
            </form>
        </div>        
    <?=end_row()?>
