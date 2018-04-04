    <div class='well'>        
        <div>                    
            <span class="titulo_seccion_producto">
                ¿Es nuevo?
            </span>
            <i class="fa fa-pencil text_nuevo">                
            </i>
            <div>
                <span>
                    <?=get_producto_usado($flag_nuevo)?>
                </span>
            </div>
        </div>
        <div class="input_nuevo" style="display: none;" >
            <?=select_producto_usado($flag_nuevo)?>            
            <button class="btn input-sm btn_guardar_producto_nuevo">
                Guardar 
            </button>
        </div>
    </div>