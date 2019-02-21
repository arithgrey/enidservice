<div class="col-lg-6 col-lg-offset-3">
	<form class="form_fecha_recordatorio">
		<?= heading_enid("RECORDATORIO",
			4,
			["class" => "strong titulo_horario_entra"]) ?>
		<?= br() ?>
		<?= label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-4 control-label"]) ?>
		<?= div(input([
			"data-date-format" => "yyyy-mm-dd",
			"name" => 'fecha_cordatorio',
			"class" => "form-control input-sm ",
			"type" => 'date',
			"value" => date("Y-m-d"),
			"min" => add_date(date("Y-m-d"), -15),
			"max" => add_date(date("Y-m-d"), 15)
		]),
			["class" => "col-lg-8"]) ?>

		<?= label(icon("fa fa-clock-o") . " HORA",
			["class" => "col-lg-4 control-label"]
		) ?>
		<?= div(lista_horarios(), ["class" => "col-lg-8"]) ?>
		<?= input_hidden([
			"class" => "recibo",
			"name" => "recibo",
			"value" => $orden
		]) ?>
		<?= br() ?>
		<?= label(" TIPO",
			["class" => "col-lg-4 control-label"]
		) ?>
		<?= div(create_select($tipo_recortario, "tipo", "form-control tipo_recordatorio", "tipo_recordatorio", "tipo", "idtipo_recordatorio"), ["class" => "col-lg-8"]) ?>
		<?= textarea(["name" => "descripcion", "class" => "form-control"]); ?>
		<?= guardar("CONTINUAR", ["class" => "top_20"]) ?>
	    <?=form_close()?>
</div>
<?= place("place_recordatorio") ?>