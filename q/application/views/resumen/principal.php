<?php	
	
	$extra ="";
	$nombre     = "";
	$a_paterno  = "";
	$a_materno  = "";
	$tel        = "";
	$list ="";
	$z =1;
	foreach ($clientes as $row) {
		
		$nombre     = $row["nombre"];
		$a_paterno  = $row["a_paterno"];
		$a_materno  = $row["a_materno"];
		$tel        = $row["tel"];
		$correo = $row["correo"];

		$nombre_completo =$nombre ." " . $a_paterno ." " .$a_materno ." ";

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
		<tr>
			<?=get_td("#", $extra)?>
			<?=get_td("Nombre", $extra)?>
			<?=get_td("Teléfono", $extra)?>
			<?=get_td("Correo", $extra)?>
		</tr>
		<?=$list;?>
	</table>
</div>