<div class="col-lg-12 ">
	<form class="form_busqueda_pedidos row" method="post">
		<?= form_busqueda_pedidos($tipos_entregas, $status_ventas) ?>
		<div class="col-lg-3">
			<?= strong("ORDENAR") ?>
			<select name="tipo_orden" class="form-control">
				<option value="1">
					FECHA REGISTRO
				</option>
				<option value="5">
					FECHA CONTRA ENTREGA
				</option>
				<option value="2">
					FECHA ENTREGA
				</option>
				<option value="3">
					FECHA CANCELACION
				</option>
				<option value="4">
					FECHA PAGO
				</option>
			</select>
		</div>
		<div class="col-lg-6">
			<div class="row">
				<?= $this->load->view("../../../view_tema/inputs_fecha_busqueda") ?>
			</div>
		</div>
	</form>
	<?= form_form_search() ?>
</div>
<?= place("place_pedidos") ?>
