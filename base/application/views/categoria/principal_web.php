
		<select size='20' class='selector_categoria <?=$nivel;?>' >
	        <?php foreach ($info_categorias as $row): ?>
	        	<option style='font-size:1.2em;'
						class='num_clasificacion'
						value='<?=$row["id_clasificacion"];?>'>
					<?=$row["nombre_clasificacion"];?>				
				</option>
	        <?php endforeach; ?>
		</select>
	
