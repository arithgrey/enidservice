<?php 
	
	$info =  json_encode($info);  	
	$l = "";
	foreach ($info as $row) {
		
		$l .= $row["id_proyecto_persona_forma_pago"];
	}
?>
<?=$l;?>
