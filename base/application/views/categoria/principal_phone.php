	<?=n_row_12()?>
		<select class='num_clasificacion num_clasificacion_phone selector_categoria <?=$nivel;?>' 
			style="width: 100%!important;" >
	        <?php foreach ($info_categorias as $row): ?>
	        	<option 
	        		style='font-size:1.2em;' 
	        		class='num_clasificacion' 
	        		value='<?=$row["id_clasificacion"];?>'>
					<?=$row["nombre_clasificacion"];?>				
				</option>
	        <?php endforeach; ?>
		</select>	
	<?=end_row()?>
