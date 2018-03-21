<?php
	
	$l =""; 
	foreach ($pagos_notificados as $row) {
		
		$id_notificacion_pago =  $row["id_notificacion_pago"];
		$nombre_persona      = $row["nombre_persona"];
		$correo              = $row["correo"];
		$nombre_servicio     = $row["nombre_servicio"];
		$dominio             = $row["dominio"];
		$num_recibo =  $row["num_recibo"];		
		$fecha_pago          = $row["fecha_pago"];
		$fecha_registro      = $row["fecha_registro"];
		$cantidad            = $row["cantidad"];
		
		$referencia          = $row["referencia"];
		$comentario          = $row["comentario"];
		$forma_pago  = $row["forma_pago"];	
		/**/	
		$more_info ="
		<a 
            href='#tab_mas_info_pagos_notificados' 
            data-toggle='tab'
            class='pago_notificado' id='".$id_notificacion_pago."'>
            ".$num_recibo."
		</a> ";

		$l .=  "<tr>";						
			$l .= get_td($more_info, "style='font-size:.75em;background:#000790;color:white;'  ");
			$l .=  get_td($cantidad ." MXN", "style='font-size:.75em;'");
			$l .=  get_td($nombre_persona , "style='font-size:.75em;'");						
			$l .=  get_td($fecha_pago , "style='font-size:.75em;'");
			$l .=  get_td($fecha_registro , "style='font-size:.75em;'");			
			$l .=  get_td($forma_pago , "style='font-size:.75em;'");					
		$l .=  "</tr>";
	}

?>

<div class="contenedor_listado_info contenedor_listado ">
	<?=$this->load->view("../../../view_tema/header_table")?>  	               						
		<th style='font-size:.8em;' class="white blue_enid_background text-center">
			Recibo
		</th>
		<th style='font-size:.8em;' class="white blue_enid_background text-center">
			Cantidad 
		</th>
		<th style='font-size:.8em;' class="white blue_enid_background text-center">
			Cliente
		</th>
		
		<th style='font-size:.8em;' class="white blue_enid_background text-center">
			Pago
		</th>		
		<th style='font-size:.8em;' class="white blue_enid_background text-center">
			Registro
		</th>
		<th style='font-size:.8em;' class="white blue_enid_background text-center">
			Forma de pago
		</th>		                     
	<?=$l?>
	<?=$this->load->view("../../../view_tema/footer_table")?>  	              
</div>