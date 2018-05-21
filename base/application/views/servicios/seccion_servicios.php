<div class="contenedor_inf_servicios contenedor_inf_servicios_ciclo_facturacion">
        <?=n_row_12()?>
             <div class="strong black row" style="font-size: 1em;">
                <div class="col-md-3">                    
                    
                    <div> 
                        <i class="fa fa-pencil text_ciclo_facturacion ">                
                        </i>                
                        <strong>
                            CICLO DE FACTURACIÓN
                        </strong>    
                    </div>
                    <div>
                        <?=get_nombre_ciclo_facturacion(
                            $ciclos_disponibles,
                            $id_ciclo_facturacion )?>
                        
                    </div>
                </div>
                <div class="col-md-3 input_ciclo_facturacion" style="display: none;" >
                    <div>
                        <span style="font-size: .8em;">
                            <?=create_select_selected(
                                $ciclos_disponibles , 
                                "id_ciclo_facturacion" , 
                                "ciclo" , 
                                $id_ciclo_facturacion , 
                                "ciclo_facturacion" ,  
                                "ciclo_facturacion form-control"  
                            )?>                                                     
                        </span>
                    </div>  
                    <button class="btn_guardar_ciclo_facturacion">
                        Guardar 
                    </button>
                </div>
            </div>
        <?=end_row()?>
</div>