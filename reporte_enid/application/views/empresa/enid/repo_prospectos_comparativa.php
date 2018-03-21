<?php
	
	$prospectos_semana =  0;
	$prospectos_ayer =  0;
	$prospectos_dia =  0;
	$eventos_dia =  0;
	$eventos_ayer =  0;
	$eventos_semana =  0;

	$modal_def =  " data-toggle='modal' data-target='#info-resumen' "; 
	foreach($datos_prospectos["info_prospectos"] as $row){

		$prospectos_semana =  $row["prospectos_semana"];
		$prospectos_ayer =  $row["prospectos_ayer"];
		$prospectos_dia =  $row["prospectos_dia"];
	}
	
	foreach($datos_prospectos["info_eventos"] as $row){
		$eventos_dia =  $row["eventos_dia"];
		$eventos_ayer =  $row["eventos_ayer"];
		$eventos_semana =  $row["eventos_semana"];
	}
	

?>




<?=titulo_enid("Comparativa prospectos Enid Service")?>
<table class='table_enid_service' border=1>


	<tr class="table_enid_service_header">		
		<?=get_td("Periodo " )?>
		<?=get_td("Hoy -8 ")?>
		<?=get_td("Ayer")?>
		<?=get_td("Hoy")?>
	</tr>

	<tr>
		<?=get_td("Prospecto" , " class='f-enid' ".$modal_def." ")?>
		<?=get_td(  $prospectos_semana ,  " class='info-dia-p' id='semana'  ".$modal_def."  ")?>
		<?=get_td( $prospectos_ayer ,  " class='info-dia-p' id='ayer'  ".$modal_def."  ")?>
		<?=get_td( $prospectos_dia ,  " class='info-dia-p' id='hoy'  ".$modal_def." ")?>
	</tr>

	<tr>
		<?=get_td("Eventos" , "class='f-enid'   ".$modal_def."  ")?>
		<?=get_td( $eventos_semana ,  "class='info-d' id='semana'  ".$modal_def." ")?>
		<?=get_td( $eventos_ayer ,  "class='info-d' id='ayer'  ".$modal_def." ")?>
		<?=get_td( $eventos_dia ,  "class='info-d' id='hoy'  ".$modal_def." ")?>
	</tr>

</table>
<br>