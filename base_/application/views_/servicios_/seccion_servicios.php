<div class="contenedor_inf_servicios contenedor_inf_servicios_ciclo_facturacion">
    <?=icon('fa fa-pencil text_ciclo_facturacion')?>
    <?=icon('CICLO DE FACTURACIÓN' , [ "class" => "titulo_producto_servicio"])?>
    <?=div(get_nombre_ciclo_facturacion($ciclos_disponibles,$id_ciclo_facturacion ))?>
    <div class="input_ciclo_facturacion" style="display: none;" >
        <?=create_select_selected($ciclos_disponibles , 
        	"id_ciclo_facturacion" ,  
        	"ciclo" ,
        	$id_ciclo_facturacion ,
            "ciclo_facturacion" ,
            "ciclo_facturacion form-control"  
        )?> 
        <?=guardar("GUARDAR", ['class' => 'btn_guardar_ciclo_facturacion'])?>
    </div>
</div>
