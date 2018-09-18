<?php

	$dias = array("",  'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
	$info=  $info_preguntas["info_accesos"];		
	$lista_fechas =get_arreglo_valor($info , "fecha");
	
	$fechas ="";
	$b =0;

	foreach ($lista_fechas as $row){		

		if ($b == 0) {
			$fechas .=	get_td("Artículo" , " ");
			$fechas .=	get_td("Total" , " ");
			$b++;
		}

		$fecha_text  = $dias[date('N', strtotime($row) )]; 
		$fechas .= get_td( $fecha_text ."".$row , " ");
	}
	
	

	$blogs =  $info_preguntas["blogs"]; 		
	$list ="";
	foreach ($blogs as $row) {
		
		$titulo =  $row["titulo"];
		$url =  $row["url"];

		$articulo ="<a href='".$url."' target='_black' >".$titulo. "</a>";

		$list .="<tr class='text-left'>";	
			$list .=  "<td >".$articulo."</td>";



				$lista_2 ="";
				$total_accesos = 0;
				
				foreach($lista_fechas as $row){		
					
					$fecha_actual = $row;				
					$num_accesos
					= valida_accesos_url_fecha($info_preguntas["info_accesos"] ,  $fecha_actual , $url);

					$total_accesos =  $total_accesos + $num_accesos;
					$lista_2  .= get_td($num_accesos , " class='text-center' ");

				}
				$list .=  get_td($total_accesos , "style='font-size:.8em;background:#526A99;color:white;' class='text-center' ");
				$list .= $lista_2;

		$list .="<tr>";	

	}

?>



<div style='overflow:auto;'>
<table class="table table-striped table-bordered text-center" id='table_articulos_faq' width="100%">
	<thead  style='background:#0022B7;' class='white'>
		<tr>			
			<?=$fechas;?>	
		</tr>
	</thead>	
		<?=$list?>
</div>
