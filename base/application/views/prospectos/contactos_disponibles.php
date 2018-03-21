<?php
	
	$l ="";
	$num_elementos = count($info_registros); 
	$z = 0;
	foreach ($info_registros as $row) {

		if ($z != $num_elementos-1) {
			$l .= $row["email"].",";	
		}else{
			$l .= $row["email"];
		}
		$z ++;		
	}
?>

<form class="form_update_correo"  id='form_update_correo'>
	<textarea class='form-control text_info' name='text_info'>
		<?=$l?>
	</textarea>
	<button class="btn input-sm btn_registro_actualizacion">
		Registrar como enviado
	</button>
</form>
<div class="place_registro">	
</div>
