<div class="contenedor_principal_enid">
	<div class="col-lg-6 col-lg-offset-3">
	<?=heading_enid("RESEÑAS Y VALORACIONES SOBRE" , 1 )?>
		<?=anchor_enid(
		icon('fa fa-shopping-cart').get_campo($usuario, "nombre" ),
			[	
				
			"href" 	=> "../search/?q3=".get_campo($usuario,"id_usuario" ),
			"class"	=> 'go-usuario'
		])?>			
		<?=div($resumen_recomendacion , 1)?>		
		<?=div($paginacion , 1)?>
		<?=div($resumen_valoraciones_vendedor , 1)?>			
		<?=div($paginacion , 1)?>			
	</div>
</div>