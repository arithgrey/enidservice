<?php

	$lista_proyectos =  ""; 
	foreach($proyectos as $row){

		$id_proyecto     = $row["id_proyecto"];
		$proyecto        = $row["proyecto"];
		$descripcion     = $row["descripcion"];
		$fecha_registro  = $row["fecha_registro"];
		$idtipo_proyecto = $row["idtipo_proyecto"];
		$url             = $row["url"];
		$url_img         = $row["url_img"];
		$status          = $row["status"];
		$tipo =  $row["tipo"];		
		
		

		$btn_config ="";
		
		if ($config ==  1){			
			$btn_config ="  <div> 
								<i id='".$id_proyecto."' 
								   href='#tab_modificar_proyecto' 
								   data-toggle='tab' 		
								   class='fa fa-cog btn_configuracion_proyecto'>
								   </i>
							</div>";
		}						
		$lista_proyectos .= $btn_config ."
								<div class='row'>
									<img  src='".$url_img."' width='100%' />
								</div>

								";
		


	}
?>

<?=n_row_12()?>
	<div class="col-lg-10 col-lg-offset-1">
		<?=$lista_proyectos;?>
	</div>
<?=end_row()?>