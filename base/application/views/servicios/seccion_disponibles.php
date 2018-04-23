

        <div>                    
            <strong >
                ¿ARTÍCULOS DISPONIBLES?
            </strong>
            <i class="fa fa-pencil text_cantidad">                
            </i>
            <div class="text_numero_existencia">                
                <?=valida_text_numero_articulos($existencia)?>                                       
            </div>
        </div>
        <div class="input_cantidad" style="display: none;">
            <input 
                type="number" 
                name="existencia" 
                class="existencia" 
                required="" 
                value="<?=$existencia?>">
            <button class="btn input-sm btn_guardar_cantidad_productos">
                Guardar 
            </button>
        </div>
    