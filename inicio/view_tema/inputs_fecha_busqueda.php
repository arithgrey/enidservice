<?= div(append_data([
	div("Inicio", ["class" => 'strong']),
	input([
		"data-date-format" => "yyyy-mm-dd",
		"name" => 'fecha_inicio',
		"class" => "form-control input-sm datetimepicker4",
		"id" => 'datetimepicker4',
		"value" => date("Y-m-d")
	])

]),
	["class" => 'col-lg-4']) ?>


<?= div(append_data([
	div("Fin", ["class" => 'strong']),
	input(
		[
			"data-date-format" => "yyyy-mm-dd",
			"name" => 'fecha_termino',
			"class" => "form-control input-sm datetimepicker5",
			"id" => 'datetimepicker5',
			"value" => date("Y-m-d")
		]
	)
]),
	["class" => 'col-lg-4']) ?>

<?= br() ?>
<?= div(guardar("Búsqueda " . icon("fa fa-chevron-right") . icon("fa fa-chevron-right")), ["class" => 'col-lg-4']) ?>