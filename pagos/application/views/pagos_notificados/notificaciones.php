

<?php
	
	$info =  $info_notificados[0];
	$nombre_persona =   $info["nombre_persona"];
	$id_notificacion_pago = $info["id_notificacion_pago"];
	$nombre_servicio =  $info["nombre_servicio"];
	$fecha_pago =  $info["fecha_pago"];
	$num_recibo =  $info["num_recibo"];
	$correo =  $info["correo"];
	$fecha_registro = $info["fecha_registro"];
	$forma_pago =  $info["forma_pago"];
	$cantidad =  $info["cantidad"];

	$estatus =  $info["status"];

	$estados_pago_notificado = ["Pendiente de validación" , "Pago aprobado" , "Negar pago"];
?>
<?=n_row_12()?>	
	<div class="col-lg-10 col-lg-offset-1">	
		<span style="background: #002062;color: white;padding: 5px;" class="strong">
			<?=$estados_pago_notificado[$estatus];?>
		</span>
	</div>
	
	<div class="col-lg-10 col-lg-offset-1">		
		<div class="col-lg-4" style="background: #0f3ec6;padding: 10px;color: white;">		
			
			
			<div class="text-center">
				<span style="" class="strong">
					Monto
					
					Notificado
				</span>
			</div>
			<div class="text-center" style="" >
				<span>
					<?=$cantidad?>MXN
				</span>
			</div>
			
			<div class="text-center strong" style="" class="strong">
				<span>
					Recibo
				</span>				
			</div>			
			<div class="text-center" style="">
				<span>
					#<?=$num_recibo?>
				</span>
			</div>
		</div>		
		<div class="col-lg-8" style="background: #f9fbff;padding: 10px;">			
			<div class="col-lg-8">
				<div class="strong">
					Cliente
				</div>
				<div >
					<?=$nombre_persona?>
				</div>
				<div >
					 <?=$correo?>
				</div>
				<div class="strong">
					Servicio
				</div>
				<div >
					<?=$nombre_servicio?> 
				</div>
				<div class="strong">
					Forma de pago
				</div>
				<div >
					<?=$forma_pago?>
				</div>
			</div>
			<div class="col-lg-4" >		
				<div class="strong">
					Pago
				</div>
				<div >
					<?=$fecha_pago?>
				</div>
				<div class="strong">
					Registro
				</div>
				<div >
					<?=$fecha_registro?>
				</div>
				<form class="form_actualizacion_pago_pendiente" action="" method="">
					<select class="form-control estado_pago_nofificado" name='estado'>
						<option value="0" disabled="">						
							Pendiente de validación
						</option>
						<option value="1">
							Aprobar pago
						</option>
						<option value="2">
							Negar pago
						</option>					
					</select>
					<button class="btn input-sm col-lg-12">
						Registrar
					</button>
				</form>				
			</div>
				
		</div>
	</div>
<?=end_row()?>
<?=n_row_12()?>
	<div class="col-lg-10 col-lg-offset-1">
		<div class="place_pago_notificado_actualizacion">	
		</div>
	</div>
<?=end_row()?>