	<select class="custom-select" name="q2">
		<option value="0">
			Todos los departamentos
		</option>
		<?php			
			foreach ($clasificaciones as $row) {
			
					$id_clasificacion  =  $row["id_clasificacion"];
					$nombre_clasificacion 		 =  $row["nombre_clasificacion"];
				?>
				 <option value="<?=$id_clasificacion?>">
				 	<?=$nombre_clasificacion?>				 	
				 </option>
							
                <?php 
			}
		?>
	</select>	
