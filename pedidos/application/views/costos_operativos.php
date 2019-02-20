<?= br() ?>
<div class="contenedor_costos_registrados">
	<div class="col-lg-6 col-lg-offset-3">
		<div class="jumbotron text-center">

			<?= heading_enid("COSTOS DE OPERACIÓN", 3) ?>
		</div>
	</div>
	<div class="col-lg-6 col-lg-offset-3">
		<?= $table_costos ?>
		<?=br(1)?>
		<?= anchor_enid("Agregar",
			[
					"class" => "underline top_50",
					"style" => "font-size: 1.4em;color: #031326;",
					"onclick" => "muestra_formulario_costo();"
			]) ?>
	</div>
</div>
<div class="display_none contenedor_form_costos_operacion">
	<div class="col-lg-6 col-lg-offset-3">
		<?= hr(["class" => "strong"], 1) ?>
	</div>
	<div class="col-lg-6 col-lg-offset-3">
		<?= get_form_costos($tipo_costos, $id_recibo) ?>
	</div>
</div>