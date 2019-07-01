<div class="top_50">

    <div class="col-lg-5">
        <?= div(get_motificacion_evaluacion($recibo, $es_vendedor, $evaluacion), 1) ?>
        <?= div(heading_enid("RASTREAR PEDIDO" . icon("fa fa-map-signs"), 3), 1) ?>
        <?= div(create_linea_tiempo($status_ventas, $recibo, $domicilio, $es_vendedor), "timeline top_40", 1) ?>
    </div>

    <?= div(
        div(

            btw(

                heading("ORDEN #" . $recibo[0]["id_proyecto_persona_forma_pago"], 3)

                ,

                anchor_enid(img(["src" => $recibo[0]["url_img_servicio"]]), ["href" => get_url_servicio($id_servicio)])

                ,

                " "

            ),
            1

        ),
        3
    ) ?>

    <?= div("", 4) ?>

</div>
<?= div(heading_enid("También te podría interezar", 3), "col-lg-12 top_50 hidden text_interes") ?>
<?= div(place("place_tambien_podria_interezar"), "col-lg-12 top_50") ?>
<?= input_hidden(["value" => $notificacion_pago, "class" => "notificacion_pago"]) ?>
<?= input_hidden(["value" => $orden, "class" => "orden"]) ?>
<?= input_hidden(["value" => $id_servicio, "class" => "qservicio"]) ?>
