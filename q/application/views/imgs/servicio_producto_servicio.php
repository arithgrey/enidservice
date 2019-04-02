<?= form_open_multipart('',
    [
        "accept-charset" => "utf-8",
        "method" => "POST",
        "id" => "form_img_enid",
        "class" => "form_img_enid",
        "enctype" => "multipart/form-data"
    ]) ?>
<?= input([
    "type" => "file",
    "id" => "imagen_img",
    "class" => "imagen_img",
    "name" => "imagen",
    "enctype" => "multipart/form-data",
    "size" => "20"
]) ?>
<?= input_hidden(["name" => 'q', "value" => $q, "class" => "q_imagen"]) ?>
<?= input_hidden(["name" => $q2, "value" => $q3, "class" => "q2_imagen"]) ?>
<?= input_hidden(["class" => 'dinamic_img', "id" => 'dinamic_img', "name" => 'dinamic_img']) ?>
<?= place("separate-enid") ?>
<?= place("place_load_img", ["id" => 'place_load_img']) ?>
<?= place("separate-enid") ?>
<?= guardar("AGREGAR IMAGEN" . icon("fa fa-check"),
    [
        "class" => 'guardar_img_enid ',
        "id" => 'guardar_img'
    ], 1
    ,
    1
) ?>
<?= form_close() ?>
<?= place("previsualizacion", ["id" => "previsualizacion"]) ?>



 
      