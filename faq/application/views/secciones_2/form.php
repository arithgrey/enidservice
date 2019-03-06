<?= form_open("", ["class" => "form_respuesta", "id" => 'form_respuesta']) ?>
<?= label("Categoria") ?>
<?= create_select($lista_categorias, "categoria", "form-control categoria", "categoria",
	"nombre_categoria", "id_categoria"); ?>
<?= label("Tipo") ?>
<select class="form-control tipo_respuesta" name='status'>
	<option value="1">
		Pública
	</option>
	<option value="0">
		Privada
	</option>
	<option value="2">
		Solo para labor de venta
	</option>
	<option value="3">
		Pos venta
	</option>
</select>
<?= label("Pregunta frecuente") ?>
<?= input(["type" => "text", "name" => "titulo", "class" => 'form-control titulo', "required" => true]) ?>
<?= label("Respuesta") ?>
<?= div("-", ["id" => "summernote"]) ?>
<?= guardar("Registrar", ["class" => "btn", "type" => "submit"]) ?>
<?= form_close() ?>
<?= place("place_refitro_respuesta") ?>
