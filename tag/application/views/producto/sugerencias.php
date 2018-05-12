<?php 
	$table =  width_productos_sugeridos($lista_productos); 
?>
<div class="separador"></div>
<?php if (count($lista_productos)>0): ?>
	<?=n_row_12()?>
		<div class="col-lg-12">
			<div class="col-lg-12">
			<p style="font-size: 2em;" 
				class="black strong" >							
				TAMBIÉN PODRÍA INTERESARTE
			</p>
			</div>
		</div>
		
	<?=end_row()?>
<?php endif; ?>
<div style="margin-top: 30px;">	
</div>
<?=n_row_12()?>
	<div class="col-lg-12">
		<div class="col-lg-12">
		<div class="productos_sugeridos" style="width: 100%">
			<div <?=$table["tabla"]?>>
				<?php foreach ($lista_productos as $row):?>							
					<div <?=$table["producto"]?> class='productos_sugerencia' >
						<?=get_td($row)?>		
					</div>
				<?php endforeach; ?>				
			</div>
		</div>
		</div>
	</div>
<?end_row()?>
<style type="text/css">
	.productos_sugeridos .productos_sugerencia{
		display: inline-table!important;		
	}	
</style>
