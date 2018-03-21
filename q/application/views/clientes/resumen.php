<?php  
	$l ="";
	
	foreach ($info as $row) {	
		$id_persona =  $row["id_persona"];
		$nombre =  $row["nombre"];
		$a_paterno =  $row["a_paterno"];
		$a_materno =  $row["a_materno"];
		$tel =  $row["tel"];
		$tel_2 =  $row["tel_2"];
		$sitio_web =  $row["sitio_web"];
		$correo =  $row["correo"];
		$nombre_fuente =  $row["nombre_fuente"];
		$nombre_servicio =  $row["nombre_servicio"];
		$tipo_negocio =  $row["tipo_negocio"];		 		
		$nombre = $nombre . " " . $a_paterno . " " . $a_materno; 						
		
		/*PERSONA*/
		$extra_persona =  "<i class='info_persona fa fa-history ' 
								id='".$id_persona."'>
							</i>";



		$extra_agendar =  "<i 
							href='#tab_agendar_llamada' 
		    				data-toggle='tab' 
							class='btn_agendar_llamada fa fa-phone-square ' 
							id='".$id_persona."'>
							</i>";
	

		$l .= "<tr>";							
			$l.= get_td($nombre , "style='font-size:.8em;'");
			$l.= get_td($extra_persona , "style='font-size:.8em;'  ");
			$l.= get_td($extra_agendar , "style='font-size:.8em;' ");
			$l.= get_td($tel  , "style='font-size:.8em;' ");						
			$l.= get_td($correo  , "style='font-size:.8em;' ");
			$l.= get_td($nombre_fuente  , "style='font-size:.8em;' ");
			$l.= get_td($nombre_servicio  , "style='font-size:.8em;' ");
			$l.= get_td($tipo_negocio  , "style='font-size:.8em;' ");			
		$l .= "</tr>";
		
	}
 	
?>
  	                               

	<table class="table table-striped table-bordered text-center" width="100%">
		<thead class='text-center' style='font-size:1em;' >                       		              							
			<th style='color:#007BE3!important;'>
				Nombre
			</th>				
			<th style='color:#007BE3!important;'>
				Historial
			</th>				
			<th style='color:#007BE3!important;'>
				Agendar llamada
			</th>				
			<th style='color:#007BE3!important;'>
				Tel
			</th>
			<th style='color:#007BE3!important;' class='campo_avanzado_agenda'>
				Tel2.
			</th>
			<th style='color:#007BE3!important;' class='campo_avanzado_agenda'>
				Sitio Web
			</th>
			<th style='color:#007BE3!important;'>
				Correo
			</th>
			<th style='color:#007BE3!important;'>
				Fuente
			</th>
			<th style='color:#007BE3!important;'>
				Interés
			</th>
			<th style='color:#007BE3!important;'>
				Tipo negocio
			</th>		 		
		</thead>	              
		<?=$l;?>                           
	</table>            
