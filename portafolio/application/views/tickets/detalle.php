<?php
	$id_perfil =  $perfil[0]["idperfil"];
	$extra_estilos ="class='blue_enid_background white'  ";
?>
<div style="margin-top: 50px;"></div>
<?=n_row_12()?>						
	<table style="width: 100%;">
		<tr>
			<td>
				<span class="strong" style="font-size: 1.4em;">
					SOLICITUDES
				</span>
				<div>
					<span class="strong btn input-sm btn_agregar_tarea" 
							style="background: #0635FF !important">
						+ AGREGAR
					</span>
				</div>
			</td>
			<td class="text-right">
				<?=valida_mostrar_tareas($info_tareas)?>			
			</td>
		</tr>
	</table>			
<?=end_row()?>

<?=n_row_12()?>	
	<div style="border: solid 1px;padding: 10px;">
		<?=crea_tabla_resumen_ticket($info_ticket  , $info_num_tareas);?>	
	</div>
<?=end_row()?>
<?=n_row_12()?>
	<div class="seccion_nueva_tarea" style="display: none;margin-top: 25px;" >		
			<?=n_row_12()?>
				<span class="strong" style="font-size: 1.5em;">
					SOLICITAR TAREA
				</span>
			<?=end_row()?>
			<?=n_row_12()?>
				<form class='form_agregar_tarea'>
					<div id="summernote" class="summernote">        
						-
					</div>
					<input class='form-control tarea_pendiente'  name='tarea' type="hidden">	
					<button class="btn input-sm" style="background: black!important;">
						Solicitar 
					</button>				
				</form>		
			<?=end_row()?>			
	</div>	
<?=end_row()?>

<?php
	$z = 1; 			
	$l = "";	
	foreach ($info_tareas as $row){

		$id_tarea =  $row["id_tarea"];
		$status =  $row["status"];
		$valor_actualizar = 0; 
		$estado_tarea = ""; 
		$fecha_registro =  $row["fecha_registro"];			
		$nombre =  $row["nombre"];
		$apellido_paterno = $row["apellido_paterno"];
		$apellido_materno =  $row["apellido_materno"];

		$num_comentarios =  $row["num_comentarios"];

		$nombre_usuario_registro = 
		$nombre ." " .$apellido_paterno ." " . $apellido_materno;

		if($status == 0){
			$valor_actualizar = 1; 					
		}else{
			$valor_actualizar = 0; 
			$estado_tarea = "tarea_pendiente"; 					
		}

		$tipo_usuario =  valida_tipo_usuario_tarea($id_perfil);
		$extra_checkbox =" ";	
				
		$input=valida_check_tarea($id_tarea,$valor_actualizar,$status,$id_perfil);
		$seccion_respuesta_num ="seccion_respuesta_".$id_tarea;
		
?>



			<div class='<?=$estado_tarea?>'>
				<?=n_row_12()?>	
					<div style='background: #02022d;color:white;padding:5px;margin-top:50px;'>
							<div class='col-lg-10 col-lg-offset-1'>
								<div class='col-lg-7'>
									<?=$nombre_usuario_registro?>
									|| 
									<?=$tipo_usuario?>
								</div>
								<div class='col-lg-5'>
									<?=$fecha_registro?>
									<?=$input?>
								</div>
							</div>							
					</div>					
				<?=end_row()?>
				<?=n_row_12()?>
					<div style='padding: 10px;'>						
						<?=$row["descripcion"]?>
					</div>	
				<?=end_row()?>
				<?=n_row_12()?>						
					<table style='width:100%'>
						<tr>
							<td>
								<span 
									class='strong comentarios_tarea' 
									id='<?=$id_tarea?>'> 					
										Ver comentarios(<?=$num_comentarios?>)
								</span>					
							</td>
							<td class='text-right'>
								<span 
									class='strong agregar_respuesta a_enid_blue_sm' 
									id='<?=$id_tarea?>'> 
									+ agregar comentario
								</span>					
							</td>
						</tr>	
					</table>
				<?=end_row()?>
					
				<?=n_row_12()?>
					<div class='<?=$seccion_respuesta_num?>  row' id='<?=$id_tarea?>'>
					</div>
				<?=end_row()?>						
			</div>				
<?php }?>
