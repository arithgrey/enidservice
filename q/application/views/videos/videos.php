<?php 
	$seccion_video ="";

	foreach ($videos as $row){
					
		$id_servicio 		= $row["id_servicio"];
		$nombre_servicio  	= $row["nombre_servicio"];
		$cash 				= icon('fa fa-credit-card-al');	
		$url_compra 		= "../producto/?producto=".$id_servicio."&q2=".$id_usuario;;					

	
		$url_video_facebook =  $row["url_video_facebook"];
		$url_vide_youtube  	= $row["url_vide_youtube"]; 
		$seccion_video 		.= n_row_12();		
		$seccion_video 		.=  valida_url_youtube($url_vide_youtube);  	
				
				$copi= 'icon('btn_copiar_enlace_pagina_contacto fa fa-clone " 
									data-clipboard-text="'.$url_vide_youtube.'"')';	



				if (strlen($url_video_facebook) < 5){

					$url_video_facebook = $url_vide_youtube; 
				}						
				$compartir_fb = "https://www.facebook.com/sharer/sharer.php?u=".$url_video_facebook;		
				$copi_facebook =  '<a href="'.$compartir_fb.'" target="_black">
									icon('btn_copiar_enlace_pagina_contacto fa fa-facebook " 
									data-clipboard-text="'.$compartir_fb.'"')
									</a>';	

		

								
				$donde_compro =  "<a href='".$url_compra."' target='_black'>¿Dónde lo compra el cliente? 
				".$cash."</a>";		
				$seccion_video .= "<p class='strong  white' 
										style='padding:5px;background:#072430!important;font-size:.8em;'>
										".$nombre_servicio."

									</p>";	
				
				$seccion_video .= "<p>". $copi . $copi_facebook ."</p>";	
									
				$seccion_video .= end_row();
				$seccion_video .= "<hr>";		
			
		}
		
?>


<?=$seccion_video;?>