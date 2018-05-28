<main>
	<div class="contenedor_header"></div>	
	<div class="contenedor_principal_planes_servicios">
		<div class="col-lg-2">
		</div>	

		<div class="col-lg-10">
			
			<?=n_row_12()?>
				<h2 class="titulo_preferencias">
					TUS PREFERENCIAS E INTERESES
				</h2>
			<?=end_row()?>

			<?=n_row_12()?>
				
					<?php $z =0; foreach ($preferencias as $row): ?>
						
						<?php if ($z == 0): ?>
							<div class="col-lg-4">
							<ul>
						<?php endif; ?>

							<?php 
								$extra = 
								($row["id_usuario"] != null )?"selected_clasificacion":"";
							?>

							<li class="list-group-item item_preferencias <?=$extra?>" 
								id="<?=$row['id_clasificacion']?>">			
								<?=$row["nombre_clasificacion"];?>
								
							</li>
						
						<?php $z ++; if ($z == 10): ?>		
							</ul>
							</div>
						<?php $z =0; endif; ?>

					<?php endforeach; ?>
				
			<?=end_row()?>
		</div>
	</div>
</main>