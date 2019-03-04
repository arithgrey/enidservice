<div class="col-lg-8">
    <div class="page-section ">
        <div class="wrapper">

	        <?=get_motificacion_evaluacion($recibo, $es_vendedor , $evaluacion)?>
            <?= heading_enid("RASTREAR PEDIDO" . icon("fa fa-map-signs"), 3) ?>
            <?= div(create_linea_tiempo($status_ventas , $recibo, $domicilio, $es_vendedor), ["class" => "timeline"]) ?>
        </div>
    </div>
</div>
<div class="col-lg-4">

    <?= get_btw(
        heading("ORDEN #" . $recibo[0]["id_proyecto_persona_forma_pago"]),
        img(["src" => link_imagen_servicio($recibo[0]["id_servicio"])]),
        "page-section "
    ) ?>
</div>
<?= input_hidden(["value" => $notificacion_pago, "class" => "notificacion_pago"]) ?>
<?= input_hidden(["value" => $orden, "class" => "orden"]) ?>