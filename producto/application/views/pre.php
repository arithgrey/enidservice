<?php $class_contenedor = ($orden_pedido == 1) ? "col-lg-6 col-md-6 col-xs-12 cursor_pointer" : "col-lg-6 col-md-6 col-xs-12 cursor_pointer"; ?>
<div class="col-lg-6 col-lg-offset-3">
    <?= div(heading_enid("¿CÓMO PREFIERES TU ENTREGA?", 3, ["class" => "titulo_preferencia strong"]), ["class" => "text-center"]) ?>
</div>
<?= get_btw(
    div(get_format_eleccion_mensajeria(), ["class" => $class_contenedor, "onclick" => "carga_opcion_entrega(2, " . $id_servicio . "  ,  " . $orden_pedido . " );"]),
    div(get_format_eleccion_contra_entrega(), ["class" => $class_contenedor, "onclick" => "carga_opcion_entrega(1, " . $id_servicio . "  ,  " . $orden_pedido . " );"]),
    "col-lg-6 col-lg-offset-3"
) ?>
<?= get_seccion_pre_pedido($url_imagen_servicio,  $orden_pedido, $plan, $extension_dominio, $ciclo_facturacion, $is_servicio, $q2, $num_ciclos, $id_servicio) ?>
