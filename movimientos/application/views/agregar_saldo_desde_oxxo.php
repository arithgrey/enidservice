<?php
$heading_enid_1 =
	heading_enid(
		"AÑADE SALDO A TU CUENTA DE ENID SERVICE AL 
		REALIZAR DEPÓSITO DESDE CUALQUIER SUCURSAL OXXO",
		3);


$input_2 = input_hidden(["name" => "concepto", "value" => "1"]);

?>
<?= n_row_12() ?>
	<div class='contenedor_principal_enid'>
		<div class="col-lg-4 col-lg-offset-4">
			<?= $heading_enid_1 ?>
			<form method="GET" action="../orden_pago_oxxo">
				<?= append_data([
					input_hidden(["name" => "q2", "value" => $id_usuario]),
					input_hidden(["name" => "concepto", "value" => "1"]),
					input_hidden(["name" => "q3", "value" => $id_usuario])
				]) ?>

				<?= get_btw(

					input([
						"type" => "number",
						"name" => "q",
						"class" => "form-control input-sm input monto_a_ingresar",
						"required" => true
					])
					,
					heading_enid("MXN", 2)
					,
					"contenedor_form display_flex_enid"

				) ?>
				<?= div("¿MONTO QUÉ DESEAS INGRESAR A TU SALDO ENID SERVICE?",
					[
						"colspan" => "2",
						"class" => "underline"
					]
				) ?>
				<?= br() ?>
				<?= guardar("Generar órden") ?>
			</form>
		</div>
	</div>
<?= end_row() ?>