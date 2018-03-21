<?php 
	/**/
	$select ="<div class='".$nivel."'> 
			<select size='10'>";
	foreach($info_categorias as $row){
		
		$nombre_clasificacion =  $row["nombre_clasificacion"];
		$id_clasificacion =  $row["id_clasificacion"];
		$is_producto_servicio =  $row["is_servicio_producto"];

		$select .= "<option 
						class='num_clasificacion'
							 value='".$id_clasificacion."'>".
						$nombre_clasificacion
						."</option>";
	}
	$select .="</select>
			</div>"; 


	if (count($info_categorias) > 0 ) {
		echo  $select; 
	}
?>





