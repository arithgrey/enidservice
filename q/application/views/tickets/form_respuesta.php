<?= n_row_12() ?>
	<form class="form_respuesta_ticket top_20">
		<div class="form-group">
			<?= heading_enid("COMENTARIO", 3) ?>
			<?= textarea([
				"class" => "form-control",
				"id" => "mensaje",
				"name" => "mensaje",
				"required" => ""
			]) ?>
			<?= input_hidden(["name" => "tarea", "value" => $request["tarea"]]) ?>
			<?= guardar("Enviar") ?>
		</div>
	</form>
<?= end_row() ?>