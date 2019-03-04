<?= heading_enid("Agregar Recurso", 3) ?>
<?= n_row_12() ?>
	<form class="form_recurso" id='form_recurso'>
		<div class="col-lg-6">
			<?= div("Nombre") ?>
			<?= input([
				"type" => "text",
				"name" => "nombre",
				"class" => "form-control",
				"required" => "true"
			]) ?>
		</div>
		<div class="col-lg-6">
			<?= div("../Url recurso") ?>
			<?= input([
				"type" => "text",
				"name" => "urlpaginaweb",
				"class" => "form-control",
				"required" => "true"
			]) ?>
		</div>
		<?= guardar("Registrar") ?>
		<?= place("place_recurso") ?>
	</form>
<?= end_row() ?>