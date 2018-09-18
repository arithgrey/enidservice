<?php 	
	$id 	=0;
	$tipo 	= "";
	foreach ($talla as $row) {
		$id 			= 	$row["id"];
		$tipo 			= 	$row["tipo"];
		$clasificacion 	= 	$row["clasificacion"];
	}

	$msj_exists 			= heading_enid(
									"CLASIFICACIONES AGREGADAS RECIENTEMENTE" , 
									"5" 
									, array('class'	=>	'titulo-tags-ingresos'));


	$msj_clasificaciones 	= ($num_clasificaciones > 0) ?$msj_exists:"";
	$tipo_tall				=  heading_enid(
											$tipo,
											'2' , 
											array('class'	=>	'info-tipo-talla')
										); 
?>
<div class="card">  
  	<div class="col-lg-9">
  		<div class="row agregadas">
		  	<?=$tipo_tall?>		  	
		  	<?=$msj_clasificaciones?>
		  	<?=$clasificaciones_existentes?>
	  	</div>
  	</div>
  	<div class="col-lg-3 ">
  		<div class="row sugerencias">
  			<?=heading_enid("CLASIFICACIONES",  '3' )?>  	
  			
			<form class="form-agregar-clasificacion-talla"	>
				<input type="text" name="clasificacion" required="" placeholder="Busca por clasificación">
		    </form>
		    
		    <?=n_row_12()?>
		    	<div class="info_tags">
		    	</div>
		    <?=end_row()?>
		</div>
  	</div>  	
  
</div>