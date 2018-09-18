<?=n_row_12()?>						
	<table>
		<tr>
			<?=get_td("SOLICITUDES")?>
			<?=get_td("+ AGREGAR" , ["class"	=>	"btn_agregar_tarea"]  )?>
			<?=get_td(valida_mostrar_tareas($info_tareas))?>			
		</tr>
	</table>			
<?=end_row()?>

<?=n_row_12()?>	
	<?=crea_tabla_resumen_ticket($info_ticket  , $info_num_tareas);?>	
<?=end_row()?>
<?=n_row_12()?>
	<div class="seccion_nueva_tarea">					
		<?=span("SOLICITAR TAREA", [] , 1)?>			
		<?=n_row_12()?>
			<form class='form_agregar_tarea'>
				<?=div("-" , ["id"=>"summernote", "class"=>"summernote"] , 1)?>				
				<?=input_hidden(["class"=>'tarea_pendiente',  "name"=>'tarea'])?>				
				<?=guardar("Solicitar" , [] , 1)?>				
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

		$tipo_usuario =  valida_tipo_usuario_tarea($perfil);
		$extra_checkbox =" ";	
				
		$input=valida_check_tarea($id_tarea,$valor_actualizar,$status,$perfil);
		$seccion_respuesta_num ="seccion_respuesta_".$id_tarea;
		
?>



			<div class='<?=$estado_tarea?>'>
				<?=n_row_12()?>	

					<div>
					<div class='col-lg-10 col-lg-offset-1'>
						<?=div($nombre_usuario_registro . "||" .$tipo_usuario , 
							[ "class"=>'col-lg-7'])?>
						<?=div($fecha_registro . $input , ["class"=>'col-lg-5'])?>		
					</div>							
					</div>					
				<?=end_row()?>
				<?=n_row_12()?>
					<div>						
						<?=$row["descripcion"]?>
					</div>	
				<?=end_row()?>
				<?=n_row_12()?>						
					<table>
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
