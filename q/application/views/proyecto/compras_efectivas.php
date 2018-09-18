<?=heading_enid(get_texto_por_modalidad($modalidad) , 3)?>
<?=div($paginacion , []  , 1)?>
<?=div(ver_totalidad_por_modalidad($modalidad , $compras["total"]) , [] , 1)?>

<?php if($compras["total"] >0 ): ?>
    <?php           
    	foreach($compras["compras"] as $row){

            $id_recibo              =  $row["id_proyecto_persona_forma_pago"];
    		$resumen_pedido         =  $row["resumen_pedido"];		
            $id_servicio            =  $row["id_servicio"];		
            $monto_a_pagar          =  $row["monto_a_pagar"];                                
            $url_imagen_servicio    =  "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
            $url_imagen_error       =  '../img_tema/portafolio/producto.png';     
            $fecha_registro         =  $row["fecha_registro"];           		
    	?>
    	<?=n_row_12()?>
            <div class="contenedor_articulo">
                <div class="col-lg-3">                      
                <?=img([
            		"src" 		=> 	$url_imagen_servicio,
                    "onerror" 	=>	"this.src='".$url_imagen_error."' ",
                    "class" 	=> 	'imagen_articulo'
            	])?>
                </div>    
                <div class="col-lg-9">
                    <div class="contenedor_articulo_text">
                    	<?=icon('fa fa-shopping-bag')?>
                    	<?=span($resumen_pedido , ["class"=>'texto_compra'] )?>
                    	<?=div($monto_a_pagar . "MXN")?>
                    	<?=div($fecha_registro)?>
    	            </div>  
                </div>          
            </div>
       	<?=end_row()?>
    <?php }?>
<?php endif; ?>