        <div class="contenedor_es_nuevo">                    
            <div class="titulo_producto_servicio">
                ¿ES NUEVO?
            </div>
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
            <button class="es_nuevo btn_guardar_producto_nuevo">
                Guardar 
            </button>
        </div>
        <hr class="hr_producto">