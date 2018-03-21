<?php 
	

	$lista_prioridades =["" , "Alta" , "Media" , "Baja"];
	$lista =  "";
	$asunto = "";
	$mensaje = "";
	$prioridad = "";
	$nombre_departamento = "";

	foreach ($ticket as $row) {
				
		$asunto =  $row["asunto"]; 
		$mensaje =  $row["mensaje"]; 		 
		$prioridad = $row["prioridad"];
		$nombre_departamento =  $row["nombre_departamento"]; 
		 
	}
?>
<div style="margin-top: 20px;">
	<span>
		<strong>
			Prioridad:
		</strong>
	</span>  
	<?=$lista_prioridades[$prioridad]?>	
</div>
<div style="margin-top: 20px;">
	<span>
		<strong>
			Departamento a quien está dirigido:
		</strong>
	</span>  
	<?=$nombre_departamento?>	
</div>

<div style="margin-top: 20px;">
	<span>
		<strong>
			Asunto:
		</strong>
	</span>  
	<?=$asunto?>	
</div>

<div style="margin-top: 20px;">
	<span>
		<strong>
			Reseña:
		</strong>
	</span>  
	<?=$mensaje?>	
</div>


<?=print_r($ticket);?>

