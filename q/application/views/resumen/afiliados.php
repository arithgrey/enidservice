<?php	
	
	$extra ="style='font-size:.8em;'";
	$nombre     = "";
	$tel        = "";
	$list ="";
	$z =1;
	foreach ($afiliados as $row) {
		
		$nombre     = $row["nombre"];
		$tel        = $row["tel_contacto"];
		$correo = $row["email"];

		$nombre_completo =$nombre;

		$list .="<tr>";
			
			$list .=get_td($z ,$extra );
			$list .=get_td($nombre_completo ,$extra );
			$list .=get_td($tel ,$extra );
			$list .=get_td($correo ,$extra );
		$list .="</tr>";

		$z ++;

	}
	
?>
<div  style='overflow-x:auto;'>
	<table class='table_enid_service' border=1>
		<tr class="white" style="background: #0022B7!important;font-size: .8em;">
			<?=get_td("#", $extra)?>
			<?=get_td("Nombre", $extra)?>
			<?=get_td("Teléfono", $extra)?>
			<?=get_td("Correo", $extra)?>
		</tr>
		<?=$list;?>
	</table>
</div>