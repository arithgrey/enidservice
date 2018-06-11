<?=n_row_12()?>
	<div class="contenedor_principal_enid">
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
	</div>
<?=end_row()?>


