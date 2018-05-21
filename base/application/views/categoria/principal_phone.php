	<?=n_row_12()?>
		<select class='form-control num_clasificacion num_clasificacion_phone <?=$nivel;?>' 
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
