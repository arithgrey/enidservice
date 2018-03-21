<?=construye_header_modal('agregar_comentarios_modal', 'Agregar comentario');?>                           				
	<form class='form_comentarios' id='form_comentarios'>
		<div class='text-left'>
			<label class='blue_linkeding_background white '>
				Tipificación
			</label>
		</div>
		<select class='form-control' id='tipificacion' name='tipificacion'>										
			<option value='1'>
					Le interesa
			</option>	
			<option value='2'>
					Llamar después 
			</option>									
			<option value='3'>
					No le interesa 
			</option>	
			<option value='4'>
					No volver a llamar 
			</option>					
			<option value='5'>
					No contesta
			</option>							
			<option value='6'>
					Venta
			</option>							
		</select>
		<div class='text-left'>
			<label class='blue_linkeding_background white'>
				Comentario
			</label>
		</div>
		<input 
	        name="id_usuario"
			type='hidden' 
			value='<?=$id_usuario;?>'>
			<textarea class='form-control' name='comentario' required>
			</textarea>
			<button class='btn'>
				Agregar
			</button>
			<div class='place_nuevo_comentario'>
			</div>
	</form>
<?=construye_footer_modal()?>  
<!---->