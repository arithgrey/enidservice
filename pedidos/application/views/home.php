<div class="col-lg-8 col-lg-offset-2">
	<form class="form_busqueda_pedidos" method="post">
		<div class="col-lg-4">

			<?=strong("TIPO ENTREGA")?>
			<select name="tipo_entrega" class="form-control">
				<option value="1">COMPRAS CONTRA ENTREGA</option>
				<option value="2">ENVIOS POR MENSAJERÍA</option>			
			</select>
		</div>
		<div class="col-lg-8">
			<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
		</div>
	</form>	
	
</div>
<div class="col-lg-10 col-lg-offset-1">
	<?=place("place_pedidos")?>
</div>