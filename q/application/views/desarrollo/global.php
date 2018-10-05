<?php
		
	$franja_horaria 	= 	get_franja_horaria();
	$lista_fechas 		= 	get_arreglo_valor($info_global , "fecha");	
	$estilos 			=	"  ";
	$fechas 			= 	get_fechas_global($lista_fechas);
	$list 				=	"";
	foreach($franja_horaria as $row){		

		$franja_h =  $row;	

		$list .= "<tr>";	
			$list .= get_td($franja_h , $estilos);			
				
				$total_tareas = 0;				
				$lista2 = "";
				foreach($lista_fechas as $row){		
					
					$fecha_actual 		= 	$row;									
					$tareas_realizadas 	= 	valida_tareas_fecha( $info_global , $fecha_actual , $franja_h);
					$total_tareas 		= 	$total_tareas + $tareas_realizadas;				
					$lista2 		   .= 	get_td($tareas_realizadas , $estilos ); 
				}				
				$list .= get_td($total_tareas , $estilos);
				$list .= $lista2;						

		$list .="</tr>";	

	}
?>
<?=div(
	"Atención al cliente/ tareas resueltas" , 
	["class"=>"blue_enid_background white padding_10"],
	1)?>

<?=n_row_12()?>	
	<div style='overflow-x:auto;' class="text-center">
		<table class='table_enid_service text-center' border="1">		
			<?=$fechas;?>			
			<?=$list?>
		</table>
	</div>
<?=end_row()?>