<?php	
	$lista_proyectos =  ""; 
	foreach($proyectos as $row){

		$id_proyecto     = $row["id_proyecto"];
		$proyecto        = $row["proyecto"];
		$descripcion     = $row["descripcion"];
		$fecha_registro  = $row["fecha_registro"];		
		$url             = $row["url"];
		$url_img         = $row["url_img"];
		$status          = $row["status"];
		
		$lista_proyectos .= "<div class='col-lg-3'>";
		$lista_proyectos .= "<a href='".$url."' target='black'>											
								<img  src='".$url_img."'  style='width: 100%; height:150px;'/>
							</a>";
		$lista_proyectos .= "</div>";


	}
?>



<?=$lista_proyectos;?>
