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
		

		$nombre_transf =  $row["nombre_transf"];
		$apaterno_transf =  $row["apaterno_transf"];
		$amaterno_transf =  $row["amaterno_transf"];

		$nombre_usuario_transfiere = $nombre_transf . " " . $apaterno_transf . " " . $amaterno_transf ;

		$extra_persona =  "<i class='info_persona fa fa-history ' id='".$id_persona."'>
						   </i>";
		/*PERSONA*/	
		$extra_liberar_servicio ="<i class='fa fa-check btn_liberar_proyecto' id='".$id_persona."' ></i>";

		$l .= "<tr>";	

			$l.= get_td($nombre , "style='font-size:.8em;'");						
			$l.= get_td($extra_persona , "style='font-size:.8em;'  ");
			$l.= get_td( "Detalles" , "style='font-size:.8em;'  ");
			$l .=  get_td($fecha_envio_validacion , "style='font-size:.8em;'  " );
			$l .= get_td($nombre_usuario_transfiere ,  "style='font-size:.8em;' ");
			$l.= get_td($extra_liberar_servicio , "style='font-size:.8em;'  ");						
			$l.= get_td($nombre_servicio  , "style='font-size:.8em;' ");
			$l.= get_td($tipo_negocio  , "style='font-size:.8em;' ");			
			
		$l .= "</tr>";
		
	}
 	
?>
  	                              
<div class='<?=valida_class_extra_scroll($info)?>'>
	<?=$this->load->view("../../../view_tema/header_table")?>
		<thead class='text-center' style='font-size:1em;text-align: center!important;' >                       		            
			<th style='color:#007BE3!important;font-size: .8em;'>
				Posible cliente
			</th>		
			<th style='color:#007BE3!important;font-size: .8em;'> 
				Historial
			</th>	
			<th style='color:#007BE3!important;font-size: .8em;' nowrap="">
				Se recibe en validación 
			</th>				
			<th  style='color:#007BE3!important;font-size: .8em;' nowrap="">
				Persona que transfiere 
			</th> 		
			<th style='color:#007BE3!important;font-size: .8em;' nowrap="">
				Agregar comentario
			</th>			
			<th style='color:#007BE3!important;font-size: .8em;'>
				Interés
			</th>
			<th style='color:#007BE3!important;font-size: .8em;'>
				Tipo negocio
			</th>					
		</thead>	              
		<?=$l;?>                           
	<?=$this->load->view("../../../view_tema/footer_table")?>
</div>