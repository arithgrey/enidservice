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
				
				$copi= icon('btn_copiar_enlace_pagina_contacto fa fa-clone ', ["data-clipboard-text"=> $url_vide_youtube] );	

				if (strlen($url_video_facebook) < 5){

					$url_video_facebook = $url_vide_youtube; 
				}						
				$compartir_fb = "https://www.facebook.com/sharer/sharer.php?u=".$url_video_facebook;		
				
				$copi_facebook = anchor_enid(icon('btn_copiar_enlace_pagina_contacto fa fa-facebook')  ,  
											[
												"href"					=> 	$compartir_fb,
												"target"				=>	"_black",
												"data-clipboard-text"	=>	$compartir_fb
											]);

		

								
				
				$donde_compro = anchor_enid("¿Dónde lo compra el cliente?" . $cash ,  
					[
						"href"		=>	 $url_compra,
						"target"	=>	'_black'
					]);

				$seccion_video .= div($nombre_servicio , 
					[
						"class"	=>	'strong  white',
						"style"	=>	'padding:5px;background:#072430!important;font-size:.8em;'
					] )
				
				$seccion_video .= div( $copi . $copi_facebook);
				$seccion_video .= end_row();
				$seccion_video .= "<hr>";		
			
		}
		
?>


<?=$seccion_video;?>