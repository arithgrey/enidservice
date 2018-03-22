<main>  
	<div class="col-lg-6 col-lg-offset-3">
		<?=n_row_12()?>
			<center>
				<h3 style="font-weight: bold;font-size: 3em;">		
					RESEÑAS Y VALORACIONES SOBRE 
					<a 	href="../search/?q3=<?=entrega_data_campo($usuario , "id_usuario" )?>"
						class='go-usuario'>
						<i class="fa fa-shopping-cart"></i>
						<?=entrega_data_campo($usuario , "nombre" )?>
					</a>
				</h3>	
			</center>
		<?=end_row()?>

		<?=n_row_12()?>
			<center>
				<?=$resumen_recomendacion?>
			</center>
		<?=end_row()?>

		<?=n_row_12()?>
			<div class="col-lg-10 col-lg-offset-1">
				<?=n_row_12()?>
					<?=$paginacion;?>
				<?=end_row()?>
				<?=$resumen_valoraciones_vendedor?>
			</div>			
		<?=end_row()?>
		<?=n_row_12()?>
			<?=$paginacion;?>
		<?=end_row()?>
	</div>
</main>

<br>
<br><br><br><br>
<br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br>
<br><br><br><br>
<br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br>
<style type="text/css">
	.promedio_num{
		font-size: 2em;
		font-weight: bold;
	}
	.go-usuario{
		color: blue; text-decoration: underline;
	}
	.go-usuario:hover{

		background: black;
		color: white!important; 
		padding: 2px;

	}
	.text_resumen{
		font-weight: bold;font-size: 1.1em;
		background: black;
		color: white;
		padding: 1px;
	}
	.pagination > li > a, .pagination > li > span{
		color: white!important;
	}
</style>