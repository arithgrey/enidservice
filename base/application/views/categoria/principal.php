<div class="<?=$nivel;?> seccion_lista_categorias" >
	<select size='20' style='background:white;border-style: solid;'>
        <?php foreach ($info_categorias as $row): ?>
        	<option style='font-size:1.2em;'
					class='num_clasificacion'
					value='<?=$row["id_clasificacion"];?>'>
				<?=$row["nombre_clasificacion"];?>				
			</option>
        <?php endforeach; ?>
	</select>
</div>


