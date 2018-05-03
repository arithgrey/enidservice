<?php 
	$table =  width_productos_sugeridos($lista_productos); 
?>
<?php if (count($lista_productos)>0): ?>
	<?=n_row_12()?>
		<div style="margin-top: 30px;">
			<center>
				<h3 
					style="font-size: 2em;" 
					class="black strong" >							
					TAMBIÉN PODRÍA INTERESARTE
				</h3>
			</center>
		</div>
	<?=end_row()?>
<?php endif; ?>
<div style="margin-top: 20px;">	
</div>
<?=n_row_12()?>
	<div class="productos_sugeridos" style="width: 100%">
		<div <?=$table["tabla"]?>>
			<?php foreach ($lista_productos as $row):?>							
				<div <?=$table["producto"]?> class='productos_sugerencia' >
					<?=get_td($row)?>		
				</div>
			<?php endforeach; ?>				
		</div>
	</div>
<?end_row()?>
<style type="text/css">
	.productos_sugeridos{		
		margin: 0 auto;
		text-align: center;
	}
	.productos_sugeridos .productos_sugerencia{
		display: inline-table!important;		
	}

	
</style>
