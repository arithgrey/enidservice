<?php 
    $ciclos_factura_servicio =  $ciclos_disponibles["ciclos_factura_servicio"];
    $ciclos =  $ciclos_disponibles["disponibles"]; 
    /**/
    $nombre_ciclo =  $ciclos_disponibles["nombre_ciclo"]; 

    
?>
        <?=n_row_12()?>
             <div class="strong black row" style="font-size: 1em;">
                <div class="col-md-3">                    
                    
                    <div> 
                        <i class="fa fa-pencil text_ciclo_facturacion">                
                        </i>                    
                        Ciclo de facturación
                    </div>
                    <div style="font-size: .8em;">
                        <span>
                            <?=$nombre_ciclo?>
                        </span>
                    </div>
                    
                </div>
                <div class="col-md-3 input_ciclo_facturacion" style="display: none;" >
                    <div>
                        <span style="font-size: .8em;">
                            <?=create_select_selected(
                                $ciclos , 
                                "id_ciclo_facturacion" , 
                                "ciclo" , 
                                $ciclos_factura_servicio , 
                                "ciclo_facturacion" ,  
                                "ciclo_facturacion"  
                            )?>                                                     
                        </span>
                    </div>  
                    <button class="btn input-sm btn_guardar_ciclo_facturacion">
                        Guardar 
                    </button>
                </div>
            </div>
        <?=end_row()?>
