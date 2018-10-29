
<?=n_row_12()?>	
	<?=crea_tabla_resumen_ticket($info_ticket  , $info_num_tareas);?>	
<?=end_row()?>
<?=n_row_12()?>	
	<div class="col-lg-8">
	</div>	
	<div class="col-lg-4">
		<table class="top_20 ">
			<tr>			
				<?=get_td(div("+ AGREGAR" , 
				[ "class"	=>	"blue_enid_background btn_agregar_tarea padding_1 white cursor_pointer"]))?>
				<?=get_td(valida_mostrar_tareas($info_tareas))?>			
			</tr>
		</table>			
	</div>					
<?=end_row()?>
<br>
<hr>



<?=n_row_12()?>
	<div class="seccion_nueva_tarea top_20">					
		<?=heading_enid("SOLICITAR TAREA", 1)?>			
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
	foreach($info_tareas as $row){

		$id_tarea 			=  	$row["id_tarea"];
		$status 			=  	$row["status"];
		$valor_actualizar 	= 	0; 
		$estado_tarea 		= 	""; 
		$fecha_registro 	=  	$row["fecha_registro"];			
		$nombre 			=  	$row["nombre"];
		$apellido_paterno 	= 	$row["apellido_paterno"];
		$apellido_materno 	=  	$row["apellido_materno"];
		$num_comentarios 	=  	$row["num_comentarios"];

		$nombre_usuario_registro = $nombre ." " .$apellido_paterno ." " . $apellido_materno;

		if($status == 0){
			$valor_actualizar = 1; 					
		}else{
			$valor_actualizar = 0; 
			$estado_tarea = "tarea_pendiente"; 					
		}

		$tipo_usuario 	=  valida_tipo_usuario_tarea($perfil);
		$extra_checkbox =" ";	
				
		$input 					=	valida_check_tarea($id_tarea,$valor_actualizar,$status,$perfil);
		$seccion_respuesta_num 	=	"seccion_respuesta_".$id_tarea;
		
?>	
<div class="listado_pendientes">
	<div class='<?=$estado_tarea?> top_20 contenedor_tarea_ticket'>
		<?=n_row_12()?>	
			<table>
				<tr>				
					<?=get_td($nombre_usuario_registro ,  ["class" =>"usuario_abre_tarea"])?>				
					<?=get_td($fecha_registro ,["class" =>	"fecha_registro_tarea"])?>
					<?=get_td($tipo_usuario , ["class" => "text-right tipo_usuario"])?>
				</tr>
				<tr>
					<?=get_td("" , ["colspan" => 2])?>
					<?=get_td($input)?>
				</tr>
				<tr>
					<?=get_td(div($row["descripcion"] , 1) ,  ["colspan" => 3] )?>			
				</tr>
				<tr class="top_20">
					<?=get_td(div("Ver comentarios(" . $num_comentarios .")" , 
							[
								"class"	=>	'strong comentarios_tarea cursor_pointer', 
								"id"	=>	$id_tarea
							])
						, ["colspan" => 2] )?>
						
					<?=get_td(div("+ agregar comentario" , 
							[
								"class"	=>	'text-right strong agregar_respuesta  cursor_pointer', 
								"id"	=>	$id_tarea
							])
						)?>
				</tr>
			</table>
												
		<?=end_row()?>				
		<?=place($seccion_respuesta_num , ["id" => $id_tarea])?>

	</div>		
	<hr>			
</div>
<?php }?>
