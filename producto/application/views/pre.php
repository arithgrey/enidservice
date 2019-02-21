<?php
$url = "../imgs/index.php/enid/imagen_servicio/" . $id_servicio;
$class_contenedor =
    ($orden_pedido == 1) ?
        "col-lg-6 col-md-6 col-xs-12 cursor_pointer" :
        "col-lg-6 col-md-6 col-xs-12 cursor_pointer";

?>
    <div class="col-lg-6 col-lg-offset-3">
        <?= div(heading_enid("¿CÓMO PREFIERES TU ENTREGA?", 3, ["class" => "titulo_preferencia strong"]), ["class" => "text-center"]) ?>
    </div>


    <div class="col-lg-6 col-lg-offset-3">
        <div class="<?= $class_contenedor ?>"
             onclick="carga_opcion_entrega(2, <?= $id_servicio ?> , <?= $orden_pedido ?>);">
            <div class="box-part text-center">
                <?= icon('fa fa-truck fa-3x') ?>
                <?= div(heading_enid("POR MENSAJERÍA", 3), ["class" => "title"]) ?>
                <?= div(div("QUE LLEGUE A TU CASA U OFICINA"), ["class" => "text"]) ?>
            </div>
        </div>
        <div class="<?= $class_contenedor ?>"
             onclick="carga_opcion_entrega(1, <?= $id_servicio ?> , <?= $orden_pedido ?>);">
            <div class="box-part text-center">
                <?= img(["src" => "..//img_tema/linea_metro/metro.jpg", "class" => "icono_metro"]) ?>
                <?= div(heading_enid("PAGO CONTRA ENTREGA", 3), ["class" => "title"]) ?>
                <?= div(div("ACORDEMOS UN PUNTO MEDIO "), ["class" => "text"]) ?>
            </div>
        </div>
    </div>


<?php if ($orden_pedido == 1): ?>
    <?= get_form_pre_pedido() ?>
    <?= get_form_pre_pedido($plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos) ?>
    <?= form_pre_pedido_contact($plan, $num_ciclos) ?>
    <?= form_pre_puntos_medios($plan, $num_ciclos) ?>
    <?= addNRow(div(img(["src" => $url]), ["class" => "col-lg-4 col-lg-offset-4"])) ?>
<?php else: ?>

<?php endif; ?>