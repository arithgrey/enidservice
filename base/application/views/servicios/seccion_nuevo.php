    <div style="margin-top: 20px;">        
    </div>
    <div class="strong black row" style="font-size: 1em;">
        <div class="col-md-2">                    
            ¿Es nuevo?
            <i class="fa fa-pencil text_nuevo">                
            </i>
            <div>
                <span style="font-size: .8em;">
                    <?=get_producto_usado($flag_nuevo)?>
                </span>
            </div>
        </div>
        <div class="col-md-3 input_nuevo" style="display: none;" >
            <?=select_producto_usado($flag_nuevo)?>            
            <button class="btn input-sm btn_guardar_producto_nuevo">
                Guardar 
            </button>
        </div>
    </div>