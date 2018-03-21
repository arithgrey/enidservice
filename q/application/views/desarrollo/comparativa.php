<?php

	$list=""; 
	$franja_horaria = get_franja_horaria();	
	
	$style = "style='font-size:.8em;'";		
	$lista ="";
	for($a=0; $a < count($franja_horaria); $a++){ 
	
		$lista .="<tr>";		
			$lista .= get_td($franja_horaria[$a], $style);	
			$lista .= get_comparativas_metricas($franja_horaria[$a] , $info_global );	
		$lista .="</tr>";		
	}
	
?>

<?=n_row_12()?>	
	<div class="col-lg-6 col-lg-offset-3">
		<center>
			<span class="blue_enid_background white" style="padding: 6px;">
				Comparativa atención al cliente y tareas resueltas
			</span>
		<center>
		<br>
		<table class='table_enid_service text-center' border="1">		
			<tr class='f-enid' style="background: #0022B7;color: white;">									
				<?=get_th("Franja horaria")?>
				<?=get_th("Hace 7 días")?>
				<?=get_th("Ayer")?>
				<?=get_th("Hoy")?>
			</tr>		
			<?=$lista?>
		</table>	
	</div>	
<?=end_row()?>