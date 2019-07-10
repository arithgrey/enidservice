<?php

$id_codigo_postal = 0;
$direccion = "";
$calle = "";
$entre_calles = "";
$numero_exterior = "";
$numero_interior = "";
$cp = "";
$asentamiento = "";
$direccion_envio = "";
$municipio = "";
$estado = "";
$flag_existe_direccion_previa = 0;
$pais = "";
$direccion_visible = "display:none;";
$id_pais = 0;
foreach ($info_envio_direccion as $row) {

    $direccion = $row["direccion"];
    $calle = $row["calle"];
    $entre_calles = $row["entre_calles"];
    $numero_exterior = $row["numero_exterior"];
    $numero_interior = $row["numero_interior"];
    $cp = $row["cp"];
    $asentamiento = $row["asentamiento"];
    $municipio = $row["municipio"];
    $estado = $row["estado"];
    $flag_existe_direccion_previa++;
    $direccion_visible = "";
    $id_codigo_postal = $row["id_codigo_postal"];
    $pais = $row["pais"];
    $id_pais = $row["id_pais"];
}
?>


<?php $response[] = form_open("", ["class" => "form-horizontal form_direccion_envio"]) ?>
<?php $response[] = get_parte_direccion_envio($cp, $param, $calle, $entre_calles, $numero_exterior, $numero_interior) ?>
<?php $r[] = btw(

    div("Colonia", ["class" => "label-off", "for" => "dwfrm_profile_address_colony"])
    ,
    div(input([
        "type" => "text",
        "name" => "colonia",
        "value" => $asentamiento,
        "readonly" => true
    ]), ["class" => "place_colonias_info"])
    ,
    "value"
) ?>
<?php $r[] = place("place_asentamiento") ?>
<?php $r[] = div(
    btw(
        div("Delegación o Municipio", ["class" => "label-off", "for" => "dwfrm_profile_address_district"])
        ,
        div(input([
            "type" => "text",
            "name" => "delegacion",
            "value" => $municipio,
            "readonly" => "true"
        ]), ["class" => "place_delegaciones_info"])
        ,
        "value"


    ), "district delegacion_c") ?>


<?php $r[] = div(btw(
    div("Estado", ["class" => "label-off", "for" => "dwfrm_profile_address_district"])
    ,
    div(
        input(
            [
                "type" => "text",
                "name" => "estado",
                "value" => $estado,
                "readonly" => "true"
            ]
        ),
        ["class" => "place_estado_info"]

    )
    ,
    "value"
), " district  estado_c") ?>

<?php $r[] = btw(
    div("País", ["class" => "label-off", "for" => "dwfrm_profile_address_district"]),
    $pais,
    "district pais_c"
) ?>
<?php $r[] = input_hidden([
    "name" => "pais",
    "value" => $id_pais
]) ?>
<?php $z[] = div("Esta es mi dirección principal", "strong"); ?>
<?php
$opt[] = array(
    "text" => "SI",
    "val" => 1
);
$opt[] = array(
    "text" => "NO",
    "val" => 0
);
?>
<?php $z[] = create_select($opt, "direccion_principal", "direccion_principal", "direccion_principal", "text", "val"); ?>
<?php $r[] = div(append($z), "direccion_principal_c") ?>
<?php $r[] = guardar("Registrar dirección", ["class" => "btn text_btn_direccion_envio"]) ?>
<?php $response[] = div(append($r), ["style" => $direccion_visible, "class" => "parte_colonia_delegacion"]) ?>
<?php $response[] = form_close() ?>
<?= div(text_icon('fa fa-bus', "Dirección de envio ")) ?>
<?= div(append($response), ["id" => 'modificar_direccion_seccion', "class" => "contenedor_form_envio"]) ?>