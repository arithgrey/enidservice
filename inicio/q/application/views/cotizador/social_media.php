<?php $resumen = get_fechas_cotizador($info); ?>
<?= heading_enid("Tu Productividad", 2, ["class" => 'titulo_repo']) ?>
<?= n_row_12() ?>
	<div style='overflow-x:auto;'>
		<table class='table_enid_service' border=1>
			<tr class='f-enid'>
				<?= $resumen["fechas"] ?>
			</tr>
			<tr>
				<?= $resumen["proyectos"] ?>
			</tr>
			
			<tr>
				<?= $resumen["prospectos_contato"] ?>
			</tr>
			<tr>
				<?= $resumen["info_clientes_sistema"] ?>
			</tr>
			<tr>
				<?= $resumen["info_afiliados"] ?>
			</tr>
			<tr>
				<?= $resumen["info_visitas"] ?>
			</tr>
			<tr>
				<?= $resumen["contactos"] ?>
			</tr>
			<tr>
				<?= $resumen["contactos_promociones"] ?>
			</tr>
			<tr>
				<?= $resumen["email_enviados"] ?>
			</tr>
			<tr>
				<?= $resumen["email_leidos"] ?>
			</tr>
			
			<tr>
				<?= $resumen["blogs"]; ?>
			</tr>
		</table>
	</div>
<?= end_row() ?>