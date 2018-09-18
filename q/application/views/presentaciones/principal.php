<?php 
	
	$l = "";
	foreach ($info_presentaciones as $row) {
		
		$l .= "<tr>";	
			$l .= get_td($row["hora"]);	
			$l .= get_td($row["num_presentaciones"]);	


			$l .=  	get_td($row["sitios_1490"]);
			$l .=   get_td($row["sitios_tienda_en_linea"]);
			$l .=   get_td($row["sitios_3490"]);
			$l .=   get_td($row["sitios_4999"]);
			$l .=   get_td($row["tienda_en_linea"]);


		$l .= "</tr>";	
	}
?>
<div style='overflow-x:auto;'>
	<table class='table_enid_service' border=1 >		
		<tr style="background:#033045; color:white;">
			<?=get_td("<span class='white'>Hora</span>")?>
			<?=get_td("<span class='white'>Muestras</span>")?>

			<?=get_td("<span class='white'>Sitios 1490</span>")?>
			<?=get_td("<span class='white'>En página web tienda en linea </span>")?>
			<?=get_td("<span class='white'>Sitios 3490 </span>")?>
			<?=get_td("<span class='white'>Sitios 4999 </span>")?>
			<?=get_td("<span class='white'>Tienda en linea  </span>")?>
			
		

		</tr>

		<?=$l;?>
	</table>
</div>
<style type="text/css">
.f-enid , .table_enid_service_header{
	background: #03396E;
	color: white !important;
	
}
.white{
	color: white !important;
}
.strong{
	
}
table {
	text-align: center;
	width: 100%;
}

</style>