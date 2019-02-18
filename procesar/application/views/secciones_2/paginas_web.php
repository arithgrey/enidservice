<?php

$producto =
    create_resumen_servicio($servicio, $info_solicitud_extra);
$ciclos_solicitados = $info_solicitud_extra["num_ciclos"];
$resumen_producto = $producto["resumen_producto"];
$resumen_servicio_info = $producto["resumen_servicio_info"];
$monto_total = floatval($servicio[0]["precio"]) * floatval($ciclos_solicitados);

$costo_envio_cliente = 0;
$text_envio = "";
if ($servicio[0]["flag_servicio"] == 0) {
    $costo_envio_cliente = $costo_envio["costo_envio_cliente"];
    $text_envio = $costo_envio["text_envio"]["cliente"];
}

$monto_total_con_envio = $monto_total + $costo_envio_cliente;
?>
<div class="contenedor_compra">
    <div class="contenedo_compra_info">
        <div class="col-lg-10 col-lg-offset-1">
            <?=n_row_12()?>
            <div class="resumen_productos_solicitados">
                <?= heading_enid(
                    'RESUMEN DE TU PEDIDO' . icon("fa fa-shopping-bag")
                    ,
                    2,
                    ['class' => 'strong']
                ) ?>
                <?= div($resumen_producto, 1) ?>
                <?= div($text_envio, 1) ?>
                <?= input_hidden([
                    "name" => "resumen_producto",
                    "class" => "resumen_producto",
                    "value" => $resumen_servicio_info
                ]) ?>
                <?= n_row_12() ?>
                <div class="text-right">
                    <?= heading_enid("MONTO $" . $monto_total . "MXN", 4) ?>
                    <?= heading_enid("CARGOS DE ENVÍO $" . $costo_envio_cliente . "MXN", 4) ?>
                    <?= heading_enid("TOTAL $" . $monto_total_con_envio . "MXN", 3) ?>
                    <?= div("Precios expresados en Pesos Mexicanos.", ["class" => "bottom_10"]) ?>
                </div>
                <?= end_row() ?>
                <?= n_row_12() ?>
                <?php if ($in_session == 1): ?>
                    <?= guardar("ORDENAR COMPRA", ['class' => 'btn_procesar_pedido_cliente'], 1, 1) ?>
                    <?= place('place_proceso_compra') ?>
                <?php endif; ?>
                <?= end_row() ?>
                <hr>
            </div>


            <div class="contenedor_formulario_compra">
                <?php
                $info_ext = $info_solicitud_extra;
                $plan = $info_ext["plan"];
                $num_ciclos = $info_ext["num_ciclos"];
                $ciclo_facturacion = $info_ext["ciclo_facturacion"];
                $ingresar = anchor_enid('INGRESA', array(
                    'href' => '../login'
                ));
                $talla = (array_key_exists("talla", $info_solicitud_extra)) ? $info_solicitud_extra["talla"] : 0;

                ?>


                <?php if ($in_session == 0 && $is_mobile == 0) { ?>

                    <?= heading_enid("QUIEN ERES", 2, ["class" => "strong"]) ?>

                <?php } ?>


                <div>
                    <form class="form-miembro-enid-service" id="form-miembro-enid-service">

                        <?= input_hidden([
                            "name" => "descripcion",
                            "value" => ""
                        ]) ?>
                        <?= input_hidden([
                            "name" => "usuario_referencia",
                            "value" => $q2,
                            "class" => 'q2'
                        ]) ?>
                        <?= input_hidden([
                            "name" => "plan",
                            "class" => "plan",
                            "value" => $plan
                        ]) ?>
                        <?= input_hidden([
                            "name" => "num_ciclos",
                            "class" => "num_ciclos",
                            "value" => $num_ciclos
                        ]) ?>
                        <?= input_hidden([
                            "name" => "ciclo_facturacion",
                            "class" => "ciclo_facturacion",
                            "value" => $ciclo_facturacion
                        ]) ?>
                        <?= input_hidden([
                            "name" => "talla",
                            "class" => "talla",
                            "value" => $talla
                        ]) ?>

                        <?php if ($in_session == 0){ ?>
                        <div class="row">
                            <div class=" col-lg-6">
                                <?= div("Nombre *") ?>
                                <?= div(input([
                                    "name" => "nombre",
                                    "placeholder" => "Nombre",
                                    "class" => " input-sm  nombre",
                                    "type" => "text",
                                    "required" => "true"
                                ])) ?>
                            </div>
                            <div class=" col-lg-6">
                                <?= div("Correo Electrónico  *") ?>
                                <?= div(input([
                                    "name" => "email",
                                    "placeholder" => "email",
                                    "class" => " input-sm  email",
                                    "type" => "email",
                                    "required" => "true",
                                    "onkeypress" => "minusculas(this);"
                                ])) ?>
                                <?= place('place_correo_incorrecto') ?>
                            </div>
                        </div>

                        <?= div(icon('fa fa-unlock-alt') . "Escribe una contraseña") ?>
                        <?= input([
                            "id" => "password",
                            "class" => " input-sm password",
                            "type" => "password",
                            "required" => "true"
                        ]) ?>
                        <?= place("place_password_afiliado") ?>

                        <?= div(icon('fa fa-phone') . "Teléfono *") ?>
                        <?= input([
                            "id" => "telefono",
                            "class" => "telefono form-control",
                            "type" => "tel",
                            "pattern" => "^[0-9-+s()]*$",
                            "maxlength" => 13,
                            "minlength" => 8,
                            "name" => "telefono",
                            "required" => "true"
                        ]) ?>
                        <?= place("place_telefono") ?>
                        <?= guardar("CREA UNA CUENTA") ?>

                        <?= div(anchor_enid("TU USUARIO YA SE ENCUENTRA REGISTRADO",
                            [
                                'class' => "white",
                                "href" => "../login"

                            ]),
                            [
                                'class' => "usuario_existente black_enid_background padding_1 white top_20 enid_hide"
                            ],
                            1) ?>

                        <?= get_text_acceder_cuenta($is_mobile, $info_ext) ?>
                </div>
            </div>

            <?=place("place_config_usuario")?>
            <?php }?>
            </form>
            <?=place("place_registro_afiliado")?>
        </div>
    </div>
</div>
<?= end_row() ?>
<?=hr()?>