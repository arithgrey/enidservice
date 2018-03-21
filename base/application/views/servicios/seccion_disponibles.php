
    <div style="margin-top: 20px;">        
    </div>
    <div class="strong black row" style="font-size: 1em;">
        <div class="col-md-6">                    
            <span class='text_articulos_disponibles'>
                Artículos disponibles
            </span>
            <i class="fa fa-pencil text_cantidad">                
            </i>
            <div class="text_numero_existencia">                
                <?=valida_text_numero_articulos($existencia)?>                                       
            </div>
        </div>
        <div class="col-md-6 input_cantidad" style="display: none;">
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
    </div>

    