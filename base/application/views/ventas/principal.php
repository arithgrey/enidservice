<?php
	$personas_contactadas = get_td(0);
	foreach ($labor_venta["contactacion"] as $row){

		$personas_contactadas =  get_td($row["personas_contactadas"]);
	}
?>

<br>
<?=n_row_12()?>
		
		<div class='col-lg-8 col-lg-offset-2'>
			<table class="table_enid_service text-center" border="1" width="100%">			
				<tr class='blue_enid_background white'>
					<?=get_td("<h3 class='white'> Contactación</h3>")?>
				</tr>		
				<tr>
					<?=$personas_contactadas;?>
				</tr>
			</table>
		</div>

<?=end_row()?>

<br>
<br><br><br><br>