<?php 
	$tarea =  $request["tarea"];
?>
<?=n_row_12()?>
	<form class="form_respuesta_ticket">
		<div class="form-group">
			<?=label("Mensaje", ["class"=>"col-md-12 control-label",  "for"=>"mensaje"])?>		  
		  	<textarea class="form-control" id="mensaje" name="mensaje" required=""></textarea>		    
		    <?=input_hidden(["name"=>"tarea",  "value"=> $tarea ])?>
		  	<?=guardar("Enviar")?>		  	
		</div>		
	</form>
<?=end_row()?>