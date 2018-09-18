
	<?=heading_enid("SÉ EL PRIMERO EN REVISAR ESTE PRODUCTO"  , 2)?>	
	
	<div class="row">
		<div class="col-lg-3">
			<?=div(anchor_enid("ESCRIBE UNA RESEÑA" . icon("fa fa-chevron-right ir") , 
			[
				"href"	=>"../valoracion?servicio=".$servicio, 
				"style"	=>"color:white!important;"
			]),  
			['class'  => 'a_enid_blue'])?>
		</div>
	</div>		
	<div class="row">
		<div class="col-lg-3">
			<?=div(anchor_enid("MÁS VALORACIONES DEl VENDEDOR" . icon("fa fa-chevron-right ir") , 
			[
				"href"	=>"../recomendacion/?q=".$id_usuario, 
				"style"	=>"color:white!important;"
			]),  
			['class'  => 'a_enid_black'])?>

		</div>
	</div>