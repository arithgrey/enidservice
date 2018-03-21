<?php

	$l ="<table >";
	$b = 1;
	foreach ($recursos as $row){

		$nombre = $row["nombre"];
		$idperfil =  $row["idperfil"];
		$url =  $row["urlpaginaweb"];
		$id_recurso =  $row["id_recurso"];

		$ver_sitio =  "<a href='".$url."' 
						class='blue_enid_background white '
						id= '".$id_recurso."'  
						target='_black'
						style='padding:5px;font-size:.8em;' >
						Ver sitio
					</a>";

		$l .="<tr>";
			$l .=get_td($b.".-");

			if ($idperfil > 0 ) {
				$l .=get_td("<input type='checkbox' class='perfil_recurso' id= '".$id_recurso."'  checked>");
			}else{
				$l .=get_td("<input type='checkbox' class='perfil_recurso' id= '".$id_recurso."'  >");	
			}

			$l .=get_td($nombre , "style='font-size:.9em;' ");		
			$l .=get_td($ver_sitio);			
		$l .="</tr>";
		$b ++;
	}
	$l .="</table>";

?>

<?=$l;?>