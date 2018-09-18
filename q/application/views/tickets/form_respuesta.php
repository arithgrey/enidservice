<?php 
	$tarea =  $request["tarea"];
?>
<?=n_row_12()?>
	<form class="form_respuesta_ticket">
		<div class="form-group">
		  	<label class="col-md-12 control-label" for="mensaje">Mensaje
		  	</label>
		  	<div class="col-md-12">                     
		    	<textarea class="form-control" id="mensaje" name="mensaje" required=""></textarea>
		    	<input type="hidden" name="tarea" value='<?=$tarea;?>'>
		  	</div>
		  	<div class="col-md-12">                     
			  	<button class="btn input-sm" style="background: black!important;">
					Enviar		
				</button>
			</div>
		</div>		
	</form>
<?=end_row()?>