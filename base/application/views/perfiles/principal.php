	
	<div class='row'>
		<div class='contenedor_tipos_negocio'>			
			<div class='text-left'>		
				<?=get_tag_delete_perfiles(count($perfiles_diponibles_prospectacion))?>
				<?=get_perfiles_disponible_dia($perfiles_diponibles_prospectacion)?>
			</div>			
		</div>
	</div>
	
	<div class='row'>
		<table style='width:100%' border="1">
			<?=get_lista_perfiles($perfiles , $extra)?>
		</table>
	</div>

	<style type="text/css">
	.lb_nota{
		
		padding: 10px;
		margin-top: 10px!important;
	}
	.contenedor_tipos_negocio{
		height: 100px;
		overflow: auto;
		overflow-x: hidden;
	}

	</style>