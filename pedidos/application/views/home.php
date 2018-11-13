<div class="col-lg-12 ">
	<form class="form_busqueda_pedidos" method="post">
		<div class="col-lg-2">
			<?=strong("#Recibo")?>
			<?=input([
				"name"=> "recibo" , 
				"class"=>"form-control"
			])?>

			<?=input_hidden([
				"name"	=> "v" , 
				'value'	=>	1
				
			])?>		</div>
		<div class="col-lg-2">
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
<div class="col-lg-12 ">
	<?=place("place_pedidos")?>
</div>