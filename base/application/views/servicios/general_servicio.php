<?=n_row_12()?>
    <div class="strong black">        
                <?=n_row_12()?>                        
                        <div class="text_nombre_servicio">
                            <span style="font-size: 2em;">
                                <?=get_text_tipo_servicio($flag_servicio)?>/<?=$nombre_servicio;?>
                            </span>
                            <i class="fa fa-pencil text_nombre_servicio" style="margin-left: 10px;">
                            </i>
                        </div>
                        <div style="display: none;" class="input_nombre_servicio_facturacion">
                            <form class="form_servicio_nombre_info">
                                <div>                            
                                    <input type="hidden" name="q" value="nombre_servicio">
                                    <input type="text" name="q2" value="<?=$nombre_servicio;?>" required>
                                </div>    
                                <div>
                                    <button class="btn input-sm">
                                        Guardar 
                                    </button>
                                </div>
                            </form>
                        </div>
                <?=end_row()?>
        
    </div>    
<?=end_row()?>