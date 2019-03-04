<?= form_open("", ["class" => "form_respuesta_ticket top_20"]) ?>
	<?= heading_enid("COMENTARIO", 3) ?>
	<?= textarea([
		"class" => "form-control",
		"id" => "mensaje",
		"name" => "mensaje",
		"required" => ""
	]) ?>
	<?= input_hidden(["name" => "tarea", "value" => $request["tarea"]]) ?>
	<?= guardar("Enviar") ?>
<?= form_close() ?>
