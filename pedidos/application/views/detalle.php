<div class="col-lg-10 col-lg-offset-1 top_50 bottom_100">
    <div class="col-lg-8">
        <div class="col-lg-12">
            <?= format_resumen_pedidos($orden) ?>
            <?= div(crea_estado_venta($status_ventas, $recibo), 1) ?>
            <?= format_estados_venta($status_ventas, $recibo, $orden) ?>
            <?= crea_seccion_solicitud($recibo) ?>
            <?= crea_seccion_productos($recibo) ?>
            <?= crea_fecha_entrega($recibo) ?>
            <?= create_fecha_contra_entrega($recibo, $domicilio) ?>
            <?= notificacion_por_cambio_fecha($recibo, $num_compras, primer_elemento($recibo, "saldo_cubierto")); ?>
            <?= addNRow(crea_seccion_recordatorios($recordatorios, $tipo_recortario)) ?>
            <?= create_seccion_tipificaciones($tipificaciones) ?>
            <?= addNRow(get_form_nota($id_recibo)) ?>
            <?= addNRow(create_seccion_comentarios($comentarios, $id_recibo)) ?>
        </div>
    </div>
    <?= div(get_format_resumen_cliente_compra($recibo, $tipos_entregas, $domicilio, $num_compras, $usuario, $id_recibo), 4) ?>
</div>
<?= get_hiddens_detalle($recibo) ?>
