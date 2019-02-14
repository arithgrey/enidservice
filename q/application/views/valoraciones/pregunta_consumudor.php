<?php
$f = [];
array_push($f, textarea([
    "class" => "form-control",
    "id" => "pregunta",
    "name" => "pregunta",
    "placeholder" => "Tu pregunta"
]));

array_push($f, input_hidden(["name" => "servicio", "value" => $id_servicio]));
array_push($f, input_hidden(["name" => "propietario", "class" => "propietario", "value" => $propietario]));
array_push($f, place(".place_area_pregunta"));
array_push($f, place(".nuevo"));
array_push($f, guardar("ENVIAR PREGUNTA" . icon("fa fa-chevron-right ir")));
array_push($f, place(".place_registro_valoracion"));
?>
<?= heading_enid("ESCRIBE UNA PREGUNTA " . strtoupper($vendedor[0]["nombre"] . " " . $vendedor[0]["apellido_paterno"]), 2) ?>
<?= div("SOBRE SU" . $servicio[0]["nombre_servicio"]) ?>
<?= br(2) ?>
<form class="form_valoracion ">
    <?= append_data($f) ?>
</form>