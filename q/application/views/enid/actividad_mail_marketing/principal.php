<?php

	$seccion_fechas ="";
	$seccion_envios ="";
	$seccion_solicitudes = "";
	$seccion_ventas = "";

	$total_envios =0;
	$total_solicitudes =0;
	$total_ventas =0;
	$num_dias =0;
	$flag =0; 
	$dias = ["", 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];

	$l_fechas = [];
	$l_fecha_texto = [];
	$l_envios = [];
	$l_solicitudes = [];
	$l_ventas = [];

	foreach ($email as $row){
		$fecha_texto  = $dias[date('N', strtotime($row["fecha_registro"]))]; 
		array_push($l_fechas, $row["fecha_registro"]);
		array_push($l_envios, $row["envios"]);		
		array_push($l_solicitudes, $row["solicitudes"]);	
		array_push($l_ventas, $row["ventas"]);		
		array_push($l_fecha_texto, $fecha_texto);

	
	}
	
	$a =0;
	foreach($l_fechas as $row){
				
		$fecha_registro_texto =  $l_fecha_texto[$a];
		$fecha_registro =  $l_fechas[$a];
		$ft = $fecha_registro_texto ."".$fecha_registro;
				
		$envios =  valida_num($l_envios[$a]);
		$solicitudes =  valida_num($l_solicitudes[$a]);
		$ventas =  valida_num($l_ventas[$a]);

		$total_envios = $total_envios + $envios;
		$total_solicitudes =  $total_solicitudes + $solicitudes;
		$total_ventas =  $total_ventas + $ventas;
		$num_dias ++ ;
		$a ++ ;
?>	
	<?php $seccion_fechas .= get_td($ft);?>
	<?php $seccion_envios .= get_td($envios);?>
	<?php $seccion_solicitudes .= get_td($solicitudes);?>
	<?php $seccion_ventas .= get_td($ventas);?>
	
<?php } ?>
		
<table border="1" class="text-center" >
	<tr>
		<?=get_td("Periodo")?>
		<?=get_td("Totales  Días ".$num_dias)?>		
		<?=$seccion_fechas?>
	</tr>
	<tr>
		<?=get_td("Envios")?>		
		<?=get_td($total_envios)?>
		<?=$seccion_envios?>
	</tr>
	<tr>
		<?=get_td("Solicitudes")?>		
		<?=get_td($total_solicitudes)?>
		<?=$seccion_solicitudes?>
	</tr>
	<tr>
		<?=get_td("Ventas")?>		
		<?=get_td($total_ventas)?>
		<?=$seccion_ventas?>
	</tr>
</table>