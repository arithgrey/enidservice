<br>
<?php
	$id_perfil =  $perfil[0]["idperfil"];
	$extra_estilos ="class='blue_enid_background white' style='font-size:.8em;' ";
?>
<?=n_row_12()?>
	<div class="col-lg-10 col-lg-offset-1">
		<div class='contenedor_movil contenedor_listado_info'>
	            <?=crea_tabla_resumen_ticket(
	            	$info_ticket  , $info_num_tareas);?>			
		</div>
	</div>
<?=end_row()?>
<?=n_row_12()?>
	<div class="col-lg-10 col-lg-offset-1">
		<span>
			
		</span>
	</div>
<?=end_row()?>


<?php 
	if ($id_perfil != 20 ) {
		$this->load->view("tickets/configuracion_ticket");
	}
?>


<?=n_row_12()?>
	<div class="col-lg-10 col-lg-offset-1 seccion_nueva_tarea" style="display: none;" >
		<div style="margin-top: 25px;" >
			<span class="strong" style="font-size: 1.5em;">
				Solicitar tarea
			</span>
			<form class='form_agregar_tarea'>
				<div id="summernote" class="summernote">        
					-
				</div>
				<input class='form-control tarea_pendiente'  name='tarea' type="hidden">	
				<button class="btn input-sm" style="background: black!important;">
					Solicitar 
				</button>				
			</form>			
		</div>
	</div>	
<?=end_row()?>





<?=n_row_12()?>	
		<?php
			$z = 1; 			
			$ltareas = "";	
			foreach ($info_tareas as $row){

				$id_tarea =  $row["id_tarea"];
				$status =  $row["status"];
				$valor_actualizar = 0; 
				$estado_tarea = ""; 
				$fecha_registro =  $row["fecha_registro"];			
				$nombre =  $row["nombre"];
				$apellido_paterno = $row["apellido_paterno"];
				$apellido_materno =  $row["apellido_materno"];

				/**/
				$num_comentarios =  $row["num_comentarios"];

				$nombre_usuario_registro = 
					$nombre ." " .$apellido_paterno ." " . $apellido_materno;



				if ($status == 0){
					$valor_actualizar = 1; 					
				}else{
					$valor_actualizar = 0; 
					$estado_tarea = "tarea_pendiente"; 					
				}

				$tipo_usuario =  valida_tipo_usuario_tarea($id_perfil);
				$extra_checkbox =" ";	
				
				$input =valida_check_tarea(
					$id_tarea ,  
					$valor_actualizar ,
					$status , 
					$id_perfil);

						$ltareas .= "<div class='".$estado_tarea."' style='background:#f5f8ff;'>";							
							$ltareas .= n_row_12();							
								$ltareas .= n_row_12();							
									$ltareas .="<div class='white'
													 style='background:#041965 !important;'>
														<div class='row'>
															<div class='col-lg-10 col-lg-offset-1'>
																<div class='col-lg-7'>

																	<span style='font-size:.8em;'>

																		".$nombre_usuario_registro."
																		|| 
																		".$tipo_usuario."
																	</span>
																</div>
																<div class='col-lg-5 '>
																	
																		
																	<div 
																		style='font-size:.8em;'
																		class='white'>
																		".$fecha_registro."
																		".$input."
																	</div>
																	
																	
																			
																	
																</div>			
															</div>			
														</div>				
												</div>

												

												";


								$ltareas .= end_row();																
								$ltareas .= n_row_12();										
									
									$ltareas .= "<div  style='padding:30px;'>"; 

										
										
										$ltareas .= "
													<div>
														<span style='font-size:.8em!important;'> 
															".$row["descripcion"] ."
														</span>
													</div>";
									$ltareas .= "</div>
										";
								$ltareas .= end_row();															
							$ltareas .= end_row();
							
						



						$seccion_respuesta_num ="seccion_respuesta_".$id_tarea;
						



						$ltareas .= "
							<div>
								<table style='width:100%'>
									<tr>
										<td>
										<span 
											style ='font-size:.8em;' 
											class='strong comentarios_tarea' 
											id='".$id_tarea."'> 									
											Ver comentarios(".$num_comentarios.")
										</span>					
										</td>
										<td class='text-right'>
										<span 
											style ='font-size:.8em;' 
											class='strong agregar_respuesta' 
											id='".$id_tarea."'> 
											+ agregar 
											comentario
										</span>					
										</td>
									</tr>	
								</table>	
							</div>
						";

						$ltareas .= "<div style='background:white !important;' class='row'>";
						$ltareas .= n_row_12();
							
							$ltareas .= "<div class='".$seccion_respuesta_num."' 
											id='".$id_tarea."'></div>";
							
						$ltareas .= end_row();
						$ltareas .= "</div>";					

					$ltareas .= "</div>
								<br>";	
						
				$z ++;
			}					
		?>


	<div class="col-lg-10 col-lg-offset-1">		

		<?=n_row_12()?>
			<hr>
			<div>
				<table style="width: 100%;">
					<tr>
						<td>
							<span class="strong" style="font-size: 2em;">
								Solicitudes
							</span>
							<div>
								<span class="strong btn input-sm btn_agregar_tarea" style="background: 
								#0635FF !important">
									+ Agregar 
								</span>
							</div>
						</td>
						<td class="text-right">
							<?=valida_mostrar_tareas($info_tareas)?>			
						</td>
					</tr>
				</table>
			</div>						
		<?=end_row()?>
		<?=$ltareas;?>
	</div>
<?=end_row()?>





















<style type="text/css">
.mostrar_todas_las_tareas{
	display: none;
}
.mostrar_tareas_pendientes:hover, .mostrar_todas_las_tareas:hover{
	cursor: pointer;
}
.ver_tickets:hover{
	cursor: pointer;
}
.agregar_respuesta:hover{
	cursor: pointer;
}
.comentarios_tarea:hover{
		cursor: pointer;
}
</style>