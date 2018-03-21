<?php  
	$l ="";
	$tipo = 0;
	foreach ($info as $row) {	

		$tipo =  $row["tipo"];
		$id_persona =  $row["id_persona"];
		$nombre =  $row["nombre"];
		$a_paterno =  $row["a_paterno"];
		$a_materno =  $row["a_materno"];
		$tel =  $row["tel"];
		
		$nombre_servicio =  $row["nombre_servicio"];
		$tipo_negocio =  $row["tipo_negocio"];		 		
		$nombre = $nombre . " " . $a_paterno . " " . $a_materno; 						
		$fecha_envio_validacion = $row["fecha_envio_validacion"];
			

		$extra_persona =  "<i class='info_persona fa fa-history ' id='".$id_persona."'>
						   </i>";
		/*PERSONA*/	
		$extra_liberar_servicio ="<i class='fa fa-check btn_liberar_proyecto' id='".$id_persona."' ></i>";

		$l .= "<tr>";	

			$l.= get_td($nombre , "style='font-size:.8em!important;'");						
			$l.= get_td($extra_persona , "style='font-size:.8em!important;'  ");
			$l.= get_td($fecha_envio_validacion , "style='font-size:.8em!important;'  " );		
			$l.= get_td($extra_liberar_servicio , "style='font-size:.8em!important;'  ");					
			$l.= get_td($nombre_servicio  , "style='font-size:.8em!important;' ");
			$l.= get_td($tipo_negocio  , "style='font-size:.8em!important;' ");			
			
		$l .= "</tr>";	
	} 
?>
  	                              
<div class='<?=valida_class_extra_scroll($info)?>'>
	<?=$this->load->view("../../../view_tema/header_table")?>
		<thead class='text-center' style='font-size:1em;' >                       		              
			<th style='font-size:.8em;background: #0030ff;color: white;'>
				Cliente enviado a validación
			</th>		
			<th style='font-size:.8em;background: #0030ff;color: white;'> 
				Historial
			</th>	
			<th style='font-size:.8em;background: #0030ff;color: white;'>
				Se recibe en validación 
			</th>							
			<th style='font-size:.8em;background: #0030ff;color: white;'>
				Estado de validación
			</th>			
			<th style='font-size:.8em;background: #0030ff;color: white;'>
				Interés
			</th>
			<th style='font-size:.8em;background: #0030ff;color: white;'>
				Tipo negocio
			</th>					
		</thead>	              
		<?=$l;?>                           
	<?=$this->load->view("../../../view_tema/footer_table")?>
</div>