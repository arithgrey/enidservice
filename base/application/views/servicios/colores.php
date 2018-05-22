<hr class="hr_producto">
<div class="contenedor_inf_servicios">
	<div class="titulo_seccion_producto">
		COLORES
	</div>
	<?=n_row_12()?>
		<?=n_row_12()?>
			<div style="margin-top: 15px;">		
				<span class="strong text_agregar_color" style="background: black;padding: 5px;color: white">
					+ Agregar color
				</span>
			</div>
		<?=end_row()?>
		<?=n_row_12()?>
			<p class="strong" style="margin-bottom: 10px;margin-top: 30px">
				Disponibles
			</p>
		<?=end_row()?>
		<?=n_row_12()?>
			<div style="margin-top: 10px;">
				<?=$info_colores?>	
			</div>
		<?=end_row()?>
		<?=n_row_12()?>
			<br>
			<div class="input_servicio_color" style="display: none;">
				<div class="place_colores_disponibles"></div>
				<div id="seccion_colores_info"></div>
			</div>
			<br>
		<?=end_row()?>
	<?=end_row()?>
</div>