<div class="col-lg-6 col-lg-offset-3">
	<form class="form_fecha_entrega">
		<?= heading_enid("FECHA DE ENTREGA", 4, ["class" => "strong titulo_horario_entra"]) ?>
		<?= br() ?>
		<?= label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-4 control-label"]) ?>
		<?= div(input([
			"data-date-format" => "yyyy-mm-dd",
			"name" => 'fecha_entrega',
			"class" => "form-control input-sm ",
			"type" => 'date',
			"value" => date("Y-m-d"),
			"min" => add_date(date("Y-m-d"), -15),
			"max" => add_date(date("Y-m-d"), 15)
		]),
			["class" => "col-lg-8"]) ?>

		<?= label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO",
			["class" => "col-lg-4 control-label"]
		) ?>
		<?= div(lista_horarios(), ["class" => "col-lg-8"]) ?>
		<?= input_hidden([
			"class" => "recibo",
			"name" => "recibo",
			"value" => $orden
		]) ?>
		<?= br() ?>
		<?= guardar("CONTINUAR", ["class" => "top_20"]) ?>
		<?= place("place_notificacion_punto_encuentro") ?>
	</form>
</div>
<?= place("place_fecha_entrega") ?>