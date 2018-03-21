<?php
	
	$extra_table="class='blue_enid_background white text-center' 
						style='font-size: .8em;' ";
	$l ="";
	foreach ($saldos_pendientes as $row) {
		
		$proyecto                 		 = $row["proyecto"]; 
		$saldo_cubierto                  = $row["saldo_cubierto"]; 		
		$estatus_enid_service                          = $row["estatus_enid_service"]; 
		$fecha_vencimiento               = $row["fecha_vencimiento"]; 		
		$monto_a_pagar                   = $row["monto_a_pagar"]; 		
		$razon_social                    = $row["razon_social"]; 
		$fecha_vencimiento_anticipo      = $row["fecha_vencimiento_anticipo"]; 		
		$ciclo =  $row["ciclo"];		
		$flag_meses = $row["flag_meses"];
		$num_meses = $row["num_meses"];
		$id_proyecto_persona_forma_pago =  $row["id_proyecto_persona_forma_pago"];

		/**/
		$flag_red = " "; 

		$l .="<tr>";									
			$l .= get_td($id_proyecto_persona_forma_pago ,  "style='font-size:.8em;' ");
			$l .= get_td($proyecto ,  "style='font-size:.8em;' ");

            $nuevo_estado =  $estatus_enid_service;

			$l .= get_td($nuevo_estado ,  "style='font-size:.8em;' class='".$flag_red ."' ");
			$l .= get_td($ciclo ,  "style='font-size:.8em;' ");
			$l .= get_td($fecha_vencimiento ,  "style='font-size:.8em;' ");			
			
			
			
			
		$l .="</tr>";
	}
	
?>


<div class="contenedor_listado_info contenedor_listado">	
	<table class="table table-striped table-bordered text-center" 
			width="100%">
			<tr class='text-center' 
				style='font-size:1em;' >                       		       	   		
				<?=get_td("#Recibo" , $extra_table)?>
				<?=get_td("Proyecto" , $extra_table)?>
				<?=get_td("Estado" , $extra_table)?>
				<?=get_td("Ciclo facturación" , $extra_table)?>		
				<?=get_td("Próximo vencimiento" , $extra_table)?>
								
			</tr>    
		<?=$l;?>                     
	</table>            
</div>
<style type="text/css">
	.flag_red{
		background: red!important;
		color: white!important;
	}
</style>