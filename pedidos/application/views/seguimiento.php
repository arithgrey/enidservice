<div class="top_50">
    <div class="col-lg-5">
        <?= div(get_motificacion_evaluacion($recibo, $es_vendedor, $evaluacion), 1) ?>
        <?= div(heading_enid("RASTREAR PEDIDO" . icon("fa fa-map-signs"), 3), 1) ?>
        <?= div(create_linea_tiempo($status_ventas, $recibo, $domicilio, $es_vendedor), ["class" => "timeline top_40"], 1) ?>
    </div>
    <div class="col-lg-3">
        <?= div(
            get_btw(
                heading("ORDEN #" . $recibo[0]["id_proyecto_persona_forma_pago"], 3),
                img(["src" => $recibo[0]["url_img_servicio"]]),
                " "
            ), 1) ?>
    </div>
</div>
<?= input_hidden(["value" => $notificacion_pago, "class" => "notificacion_pago"]) ?>
<?= input_hidden(["value" => $orden, "class" => "orden"]) ?>