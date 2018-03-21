<?php 
	$extra ="style='font-size:.9em;' ";
?>
<?=n_row_12()?>
		<div class="overflow:auto;">
			<table class="table_enid_service " border="1" style="width: 100%">		
				<tr style="background: #0022B7;color: white;" class="text-center">					
					<?=get_td("Agregar/Quitar",$extra)?>									
					<?=get_td("Servicio",$extra)?>									
				</tr>
				<?=create_table_servicios_grupo($servicios);?>
			</table>
		</div>
<?=end_row()?>