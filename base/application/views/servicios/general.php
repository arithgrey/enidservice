    <?=n_row_12()?>                        
        <div class="text_nombre_servicio">
            <span style="font-size: 2.5em;margin-bottom: 10px;">
                <?=get_text_tipo_servicio(entrega_data_campo( $servicio, "flag_servicio" ))?>/
                <?=entrega_data_campo( $servicio, "nombre_servicio");?>
            </span>            
            <i class="fa fa-pencil text_nombre_servicio" style="margin-left: 10px;">
            </i>
        </div>
        <div style="display: none;" class="input_nombre_servicio_facturacion">
            <form class="form_servicio_nombre_info">
                <div>                            
                    <input type="hidden" name="q" value="nombre_servicio">
                    <input type="text" name="q2" 
                    value="<?=entrega_data_campo($servicio,'nombre_servicio')?>" required>
                </div>    
                <div>
                    <button class="btn input-sm">
                        Guardar 
                    </button>
                </div>
            </form>
        </div>
        <hr>
    <?=end_row()?>
