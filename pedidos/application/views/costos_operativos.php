<?= br() ?>
<div class="col-lg-6 col-lg-offset-3">
	<div class="contenedor_costos_registrados">
		<?= div(heading_enid("COSTOS DE OPERACIÓN", 3), ["class" => "jumbotron text-center"]) ?>
		<?= get_formar_add_pedidos($table_costos) ?>
	</div>
	<div class="display_none contenedor_form_costos_operacion">
		<?= get_form_costos($tipo_costos, $id_recibo) ?>
	</div>
</div>