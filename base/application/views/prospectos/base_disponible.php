<?php	
	$l = "";
	foreach ($prospectos_disponibles as $row) {		
		$l .= get_td($row["pw"]);
		$l .= get_td($row["adw"]);
		$l .= get_td($row["tl"]);
		$l .= get_td($row["crm"]);		
		$l .= get_td($row["gestos_contenidos"]);
	}
?>


<div style='overflow-x:auto;'>
	<div class='text-center'>
	<table class="table_enid_service" border="1" width='100%'>		
		
		<tr class='blue_enid_background white'>
			<td colspan="5">
				Contactos disponibles
			</td>
		</tr>
		<tr class='blue_linkeding_background white'>
			<?=get_td("Páginas web")?>
			<?=get_td("Adwords")?>
			<?=get_td("Tienda en linea")?>
			<?=get_td("CRM")?>
			<?=get_td("Gestor de contenidos")?>
		</tr>
		<tr>
			<?=$l?>
		</tr>
	</table>
	</div>
</div>

