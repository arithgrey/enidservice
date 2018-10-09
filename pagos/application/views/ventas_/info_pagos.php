<?php 
	
	$extra_part_header ="class='white' style='font-size:.8em!important;background:#002E4B!important;' ";
	$resumen_pagos = "";		
	
	$z = 0; 
	foreach ($historial_pagos as $row){
		
		$id_proyecto_persona_forma_pago = $row["id_proyecto_persona_forma_pago"];
		$fecha_registro = $row["fecha_registro"]; 	
		$saldo_cubierto = $row["saldo_cubierto"]; 			
		$status = $row["status"]; 			
		$fecha_vencimiento = $row["fecha_vencimiento"]; 	
		$id_usuario_validacion = $row["id_usuario_validacion"]; 	
				
		$monto_a_pagar =  $row["monto_a_pagar"];
		$saldo_pendiente =  $monto_a_pagar - $saldo_cubierto;
		$fecha_vencimiento_anticipo =  $row["fecha_vencimiento_anticipo"];
		
		$dias_restantes =  $row["dias_restantes"];
		$class_extra_saldo = "class='blue_enid' style='font-size.8em!important;' ";


		$btn_agregar_pendiente = "";

		if ($saldo_pendiente > 0 ){						
			$status =  "Pendiente";
			$class_extra_saldo = "class='red_enid_background white' 
			style='font-size:.8em!important;' ";

		}if( $saldo_pendiente  < 0  || $saldo_pendiente ==  0){
			$status =  "Liquidado";
			$saldo_pendiente = 0;
			$class_extra_saldo = " style='font-size:.8em!important;' ";
			$fecha_vencimiento_anticipo ="-";
			
		}
		


		$extra_part ="style='font-size:.8em!important;' ";
		$historico ="icon('fa fa-credit-card-alt id_proyecto_persona_forma_pago' 
						id='".$id_proyecto_persona_forma_pago."' ";

		$extra_liquidar_servicio = "
			id='".$id_proyecto_persona_forma_pago."'
			href='#tab_liquidar_servicio' 
			data-toggle='tab' 
			class='btn_liquidar_servicio'
			 ";	
					

		$tipo_servicio_pago = "Renovación";	
		if($z  ==  count($historial_pagos) - 1 ){		
			$tipo_servicio_pago = "Contratación";			
		}
		$z ++;		

		$resumen_pagos .="<tr>";			
			$resumen_pagos .= get_td("<span $extra_liquidar_servicio>".$historico."</span>",$extra_part);
			$resumen_pagos .= get_td($tipo_servicio_pago,$extra_part);			
			$resumen_pagos .=  get_td($status , $extra_part);			
			$resumen_pagos .=  get_td($monto_a_pagar ."MXN", $extra_part);			
			$resumen_pagos .=  get_td($saldo_pendiente , $class_extra_saldo );

			if($saldo_pendiente > 0 ){
				$resumen_pagos .=  get_td(
					"<span $extra_liquidar_servicio>+ Registrar pago</span>" , $class_extra_saldo );	
			}else{
				$resumen_pagos .=  get_td(" - " , $class_extra_saldo );				
			}
			$resumen_pagos .=  get_td($fecha_vencimiento_anticipo , $class_extra_saldo);			
			$resumen_pagos .=  get_td($fecha_vencimiento , $extra_part);			
		$resumen_pagos .=  "</tr>";
	}

?>





<?=n_row_12()?>	

	<div class="col-lg-10 col-lg-offset-1">
		<?=n_row_12()?>	
			<a 
				href="#tab_renovar_servicio_form" 
				data-toggle="tab" 
				class='btn  input-sm renovar_servicio_btn row' 
				style="background: black!important">
				Renovar servicio 
			</a>
		<?=end_row()?>
		<div class="contenedor_listado_info">
		
		   <?=$this->load->view("../../../view_tema/header_table");?>
		   
		    <?=get_td("Historia" , $extra_part_header);?>
			<?=get_td("Tipo" , $extra_part_header);?>			
			<?=get_td("Estado", $extra_part_header);?>	
			<?=get_td("Servicio", $extra_part_header);?>	
			<?=get_td("Saldo pendiente" , $extra_part_header);?>
			<?=get_td("Liquidar", $extra_part_header);?>
			<?=get_td("Límite para liquidar" , $extra_part_header);?>
			<?=get_td("Siguiente renovación" , $extra_part_header);?>
			<?=$resumen_pagos;?>
		   <?=$this->load->view("../../../view_tema/footer_table")?>               
		</div>   
	</div>	
<?=end_row()?>






