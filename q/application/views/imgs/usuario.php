<?= form_open("", [
    "accept-charset" => "utf-8",
    "method" => "POST",
    "id" => "form_img_enid",
    "class" => "form_img_enid",
    "enctype" => "multipart/form-data"
]) ?>
<?= input([
    "type" => "file",
    "id" => 'imagen_img',
    "class" => 'imagen_img',
    "name" => "imagen"
]) ?>
<?= input_hidden(["name" => 'q', "value" => 'perfil_usuario']) ?>
<?= input_hidden(["class" => 'dinamic_img', "id" => 'dinamic_img', "name" => 'dinamic_img']) ?>
<?= place("place_load_img", ["id" => 'place_load_img']) ?>
<?= guardar("ACTUALIZAR",
    [
        "type" => "submit",
        "class" => 'guardar_img_enid display_none top_10'

    ], 1, 1) ?>

<?= form_close() ?>

