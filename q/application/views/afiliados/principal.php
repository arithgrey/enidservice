<?php
	
	$fecha = "";
	$fecha_registro = "";
	$num_afiliados = "";
		
	$lista_fecha = get_td("Periodo");		
	$lista_afiliados = get_td("Afiliados");	
	$lista_solicitudes =  get_td("Solicitudes");	
	$lista_ventas =  get_td("Ventas Efectivas");
	$lista_accesos =  get_td("Accesos");

	foreach ($info_afiliaciones as $row) {
		
		$fecha = $row["fecha"];
		$fecha_registro = "";
		$num_afiliados =  $row["num_afiliados"];
	
		$lista_fecha .= get_td($fecha);
		$lista_afiliados .= get_td(valida_num($num_afiliados));
		/**/
		$lista_solicitudes .=   
		get_td(valida_valor_por_fecha($fecha , "solicitudes" , $ventas ), "style='font-size:.9em;'");
		
		$lista_ventas .=   
		get_td(valida_valor_por_fecha($fecha,"ventas_efectivas",$ventas ),"style='font-size:.9em;'");

		$lista_accesos .=   
		get_td(valida_valor_por_fecha($fecha,"num_accesos",$accesos ),"style='font-size:.9em;'");
		


	}
?>


<div  style='overflow-x:auto;'>
	<table style="width: 100%" class="table_enid_service" border="1">
		<tr style="background: #0022B7;color: white;font-size: .9em;">		
			<?=$lista_fecha?>
		</tr>
		<tr class="text-center">
			<?=$lista_afiliados;?>
		</tr>
		<tr class="text-center">
			<?=$lista_solicitudes;?>
		</tr>
		<tr class="text-center">
			<?=$lista_ventas;?>
		</tr>
		<tr class="text-center">
			<?=$lista_accesos?>
		</tr>
	</table>
</div>
<br>
<br><br><br>
