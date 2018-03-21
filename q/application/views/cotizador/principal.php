<?php 	
	$extra_periodo =" style='background:#02316f;color:white!important;' ";
	$extra_nuevos_usuarios ="style='background: #2372e9;color: white !important;text-align: center;' ";
	$extra_trans ="style='background: #d0e2fe;color: white !important;text-align: center;' ";
	$extra_usablidad ="style='background: #375789;color: white !important;text-align: center;' ";
	$extra_valoraciones ="style='background: #000;color: white !important;text-align: center;' ";
	$extra_accesos ="style='background: #00b7ff;color: white !important;text-align: center;' ";
	$extra_contacto ="style='text-align: center;' ";
	$extra_labor ="style='text-align: center;background: #1c404e;color: white !important;' ";
	/**/
	$accesos ="";		
	$accesos_a_intento_compra = "";
	$accesos_contacto =  "";
	$accesos_area_cliente = "";
	$usuarios = "";
	$transacciones = "";
	$compras_efectivas =  "";
	$solicitudes =  "";
	$envios ="";
	$cancelaciones = "";
	$contacto =  "";
	$labores_resueltas ="";
	$total_valoraciones = "";
	$si_recomendarian =  "";
	$no_recomendarian =  "";


	foreach($actividad_enid_service as $row){
	
		
		
		/**/
		$table ="<table width='100%' border=1  style='text-align: center;'>";
			$table .="<tr>";	
				$table .=get_td("Usuarios");						
				$table .=get_td("Usabilidad");											
				$table .="</tr>";	
				$table .="<tr>";	
				$table .=get_td($row["usuarios"]);						
				$table .=get_td($row["accesos_area_cliente"]);										
			$table .="</tr>";	
		$table .="</table>";
		$nuevos_usuarios = get_td($table);


		$accesos = $row["accesos"];				
		$accesos_a_intento_compra = $row["accesos_a_intento_compra"];		
		$accesos_contacto = $row["accesos_contacto"];		
		
			$table ="<table width='100%' border=1  style='text-align: center;'>";
				$table .="<tr>";	
					$table .=get_td("Total");						
					$table .=get_td("Intento de compra");						
					$table .=get_td("Contacto");					
				$table .="</tr>";	
				$table .="<tr>";	
					$table .=get_td($accesos);						
					$table .=get_td($accesos_a_intento_compra);						
					$table .=get_td($accesos_contacto);						
				$table .="</tr>";	
			$table .="</table>";			
			$accesos .=  get_td($table);



		if(count($row["ventas"]) > 0){


			$ventas =$row["ventas"][0];			
			$num_transacciones = $ventas["total"];
			$compras_efectivas =  $ventas["compras_efectivas"];
			$solicitudes =  $ventas["solicitudes"];
			$envios =  $ventas["envios"];
			$cancelaciones = $ventas["cancelaciones"];

			$table ="<table width='100%' border=1  style='text-align: center;'>";
				$table .="<tr>";	
					$table .=get_td("Transacciones");						
					$table .=get_td("Ventas");						
					$table .=get_td("Cancelaciones");	
					$table .=get_td("Solicitudes");	
					$table .=get_td("Envíos");	
				$table .="</tr>";	
				$table .="<tr>";	
					$table .=get_td($num_transacciones);						
					$table .=get_td($compras_efectivas);						
					$table .=get_td($cancelaciones);	
					$table .=get_td($solicitudes );	
					$table .=get_td($envios);	
				$table .="</tr>";	
			$table .="</table>";			
			$transacciones .=  get_td($table);



		}else{
			$table ="<table width='100%' border=1  style='text-align: center;'>";
				$table .="<tr>";	
					$table .=get_td("Transacciones");						
					$table .=get_td("Ventas");						
					$table .=get_td("Cancelaciones");	
					$table .=get_td("Solicitudes");	
					$table .=get_td("Envíos");	
				$table .="</tr>";	
				$table .="<tr>";	
					$table .=get_td(0);						
					$table .=get_td(0);						
					$table .=get_td(0);	
					$table .=get_td(0);	
					$table .=get_td(0);	

				$table .="</tr>";	
			$table .="</table>";
			
			$transacciones .=  get_td($table);

		}
		/**/
		$contacto .= get_td($row["contacto"]);
		$labores_resueltas .=  get_td($row["labores_resueltas"]);


		if(count($row["valoraciones"]) > 0){
			
			$valoraciones = $row["valoraciones"][0];
			$total_val =  $valoraciones["num_valoraciones"];
			$si_recomendarian  = $valoraciones["si_recomendarian"];
			$no_recomendarian  = $valoraciones["no_recomendarian"];

			$extra_total =" title ='Personas que han valorado ' ";			
			$extra_si_recomendaria =" title ='Personas que SI recomendarían la compra 
										$si_recomendarian ' ";
			$extra_no_recomendaria =  " title ='Personas que NO recondarían la compra 
										$no_recomendarian' ";			
			$porcentaje_si =  porcentaje($total_val, intval($si_recomendarian));
			$porcentaje_no =  porcentaje($total_val, intval($no_recomendarian));

			$table ="<table width='100%' border=1  style='text-align: center;'>";
				$table .="<tr>";	
					$table .=get_td("Total");						
					$table .=get_td("Recomendarian");			
					$table .=get_td("NO recomendarían");	
				$table .="</tr>";	
				$table .="<tr>";	
					$table .=get_td($total_val , $extra_total);						
					$table .=get_td($porcentaje_si."%" , $extra_si_recomendaria);			
					$table .=get_td($porcentaje_no."%"  , $extra_no_recomendaria);	
				$table .="</tr>";	
			$table .="</table>";
			
			$total_valoraciones .=  get_td($table);

		}else{
			/**/

			$table ="<table width='100%' border=1>";
				$table .="<tr>";	
					$table .=get_td("Total");						
					$table .=get_td("Recomendarian");			
					$table .=get_td("NO recomendarían");	
				$table .="</tr>";
				$table .="<tr>";	
					$table .=get_td("0");	
					$table .=get_td("0%");	
					$table .=get_td("0%");	
				$table .="</tr>";	
			$table .="</table>";

			$total_valoraciones .=  get_td($table);
			
		}
		
	}	
?>
<table width="100%" border="1">
	<tr>
		<?=get_td("Periodo" , $extra_periodo )?> 
		<?=get_td($envio_usuario["fecha_inicio"] . " al " . $envio_usuario["fecha_termino"] , 
		$extra_periodo)?> 
	</tr>
	<tr>
		<?=get_td("Usuarios nuevos" , $extra_nuevos_usuarios)?><?=$nuevos_usuarios?>
	</tr>
	<tr>
		<?=get_td("Transacciones" , $extra_trans )?> <?=$transacciones?>
	</tr>	
	<tr>
		<?=get_td("Valoraciones" , $extra_valoraciones)?><?=$total_valoraciones?>
	</tr>		
	<tr>
		<?=get_td("Accesos" , $extra_accesos)?> <?=$accesos?>
	</tr>
	
	<tr>
		<?=get_td("Contacto",$extra_contacto)?><?=$contacto?>
	</tr>
	<tr>
		<?=get_td("Labores resueltas" ,$extra_labor)?><?=$labores_resueltas?>
	</tr>	
</table>
