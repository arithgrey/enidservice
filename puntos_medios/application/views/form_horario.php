<div class="col-lg-6 col-lg-offset-3">
	<?= get_form_punto_encuentro_horario([
		input_hidden([
			"class" => "recibo",
			"name"	=> "recibo",
			"value"	=> $recibo
		]),

		input_hidden(["name" => "punto_encuentro" , "class"  => "punto_encuentro_form" , "value" => $punto_encuentro])
	]) ?>
</div>