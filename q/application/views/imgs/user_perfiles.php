<form
		accept-charset="utf-8"
		method="POST"
		id="form_img_perfil_user"
		class="form_img_perfil_user" enctype="multipart/form-data">


	<?= input(
		["type" => "file",
			"id" => 'imagen_upload_perfiles_user',
			"class" => 'imagen_upload_perfiles_user',
			"name" => "imagen"]) ?>

	<?= input_hidden([
		"name" => 'q',
		"value" => 'perfil_user'
	]) ?>
	<?= input_hidden([
		"class" => 'dinamic_user',
		"id" => 'dinamic_user',
		"name" => 'dinamic_user',
		"value" => '0'
	]) ?>

	<?= guardar("CARGAR") ?>
	<?= place("lista_imagenes_user", ["id" => 'lista_imagenes_user']) ?>
</form>