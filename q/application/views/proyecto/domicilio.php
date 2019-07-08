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
$direccion_visible = "style='display:none;'";
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

<?= div(append([
    icon('fa fa-bus'),
    "Dirección de envio "
])) ?>
<div id='modificar_direccion_seccion' class="contenedor_form_envio">
    <?= form_open("", ["class" => "form-horizontal form_direccion_envio"]) ?>
    <?= get_parte_direccion_envio($cp, $param, $calle, $entre_calles, $numero_exterior, $numero_interior) ?>
    <div <?= $direccion_visible ?> class="parte_colonia_delegacion">
        <?= btw(

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
        <?= place("place_asentamiento") ?>


        <?= div(
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


        ),  "district delegacion_c") ?>



        <?= div(btw(
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
        ),  " district  estado_c") ?>

        <?= btw(
            div("País", ["class" => "label-off", "for" => "dwfrm_profile_address_district"]),
            $pais,
            "district pais_c"
        ) ?>
        <?= input_hidden([
            "name" => "pais",
            "value" => $id_pais
        ]) ?>

        <div class="direccion_principal_c">
            <?= div("Esta es mi dirección principal",  "strong") ?>
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
            <?= create_select($opt, "direccion_principal", "direccion_principal", "direccion_principal", "text", "val") ?>
        </div>
        <?= guardar("Registrar dirección", ["class" => "btn text_btn_direccion_envio"]) ?>
    </div>
</div>
<?= form_close() ?>
</div>

