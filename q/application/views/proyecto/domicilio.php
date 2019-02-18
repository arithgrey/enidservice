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
    $pais = "";
}
?>


<div>
    <div>
        <div>
            <div>

                <?= div(append_data([
                    icon('fa fa-bus'),
                    "Dirección de envio "
                ])) ?>
                <div id='modificar_direccion_seccion' class="contenedor_form_envio">
                    <?= hr() ?>
                    <form class="form-horizontal form_direccion_envio">
                        <div>
                            <div>
                                <div class="value">

                                    <?= div("Código postal", ["class" => "label-off"]) ?>
                                    <?= input([
                                        "maxlength" => "5",
                                        "name" => "cp",
                                        "value" => $cp,
                                        "placeholder" => "* Código postal",
                                        "required" => "required",
                                        "class" => "codigo_postal",
                                        "id" => "codigo_postal",
                                        "type" => "text",

                                    ]) ?>
                                    <?= place("place_codigo_postal") ?>

                                    <?= input_hidden([
                                        "type" => "hidden",
                                        "name" => "id_usuario",
                                        "value" => $param['id_usuario']

                                    ]) ?>

                                </div>


                                <?= get_btw(
                                    div("Calle", ["class" => "label-off", "for" => "dwfrm_profile_address_address1"]),

                                    input([
                                        "class" => "textinput address1required",
                                        "name=" > "calle",
                                        "value=" > $calle,
                                        "maxlength" => "30",
                                        "placeholder" => "* Calle",
                                        "required" => "required",
                                        "autocorrect" => "off",
                                        "type" => "text"

                                    ]),
                                    "value"


                                ) ?>

                                <?= get_btw(
                                    div("Entre la calle y la calle, o información adicional", ["class" => "label-off", "for" => "dwfrm_profile_address_address3"])
                                    ,
                                    input([
                                        "required" => true,
                                        "class" => "textinput address3",
                                        "name" => "referencia",
                                        "value" => $entre_calles,
                                        "placeholder" => "Entre la calle y la calle, o información adicional",
                                        "type" => "text"
                                    ])
                                    ,
                                    "value"
                                ) ?>


                                <?= get_btw(
                                    div("Número Exterior", ["class" => "label-off", "for" => "dwfrm_profile_address_houseNumber"])
                                    ,
                                    input([
                                        "class" => "required numero_exterior",
                                        "name" => "numero_exterior",
                                        "value" => $numero_exterior,
                                        "maxlength" => "8",
                                        "placeholder" => "* Número Exterior",
                                        "required" => "true",
                                        "type" => "text"
                                    ])
                                    ,
                                    "value"
                                ) ?>

                                <?= get_btw(
                                    div("Número Interior", [
                                        "class" => "label-off",
                                        "for" => "dwfrm_profile_address_address2"
                                    ])

                                    ,
                                    input([
                                        "class" => "numero_interior",
                                        "name" => "numero_interior",
                                        "value" => $numero_interior,
                                        "maxlength" => "10",
                                        "autocorrect" => "off",
                                        "type" => "text",
                                        "required" => "true"
                                    ])
                                    ,
                                    "value"
                                ) ?>

                                <div <?= $direccion_visible ?> class="parte_colonia_delegacion">


                                    <?= get_btw(

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


                                    <?= div(get_btw(
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


                                    ), ["class" => "district delegacion_c"]) ?>



                                    <?= div(get_btw(
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
                                    ), ["class" => " district  estado_c"]) ?>

                                    <div class=" district pais_c">
                                        <div class="value">
                                            <?= div("País", ["class" => "label-off", "for" => "dwfrm_profile_address_district"]) ?>
                                        </div>
                                    </div>
                                    <div class="direccion_principal_c">
                                        <?= div("Esta es mi dirección principal", ["class" => "strong"]) ?>
                                        <select name='direccion_principal'>
                                            <option value="1">
                                                SI
                                            </option>
                                            <option value="0">
                                                NO
                                            </option>
                                        </select>
                                    </div>
                                    <?= guardar("Registrar dirección", ["class" => "btn text_btn_direccion_envio"]) ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <div
            class="seccion_saldo_pendiente"
            id="seccion_saldo_pendiente"
            style="display: none;">
        <div class="price-table">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="pricing text-center two">
                        <img
                                src="../img_tema/bancos/ejemplo_proceso_envio.png"
                                width="100%">


                        <p
                                class="blue_enid_background white">
                            <em>

                                <?= create_seccion_saldo_pendiente($data_saldo_pendiente) ?>MXN
                            </em>
                        </p>
                        <p>
                            Saldo pendiente
                        </p>


                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
</div>
</div>
</div>
