<div class="col-lg-10 col-lg-offset-1">
    <div class="col-lg-8">

        <?= get_btw(

            div(heading_enid("# ORDEN " . $orden, 3), ["class" => "numero_orden encabezado_numero_orden"])
            ,

            div(icon("fa fa-pencil"),
                [
                    "class" => "text-right editar_estado",
                    "id" => $orden
                ]),
            "d-flex align-items-center justify-content-between bottom_30", 1


        ) ?>

        <?= div(crea_estado_venta($status_ventas, $recibo), 1) ?>
        <div class="selector_estados_ventas top_20 bottom_20">


            <?= get_btw(

                div(strong("STATUS DE LA COMPRA"))
                ,
                create_select(
                    $status_ventas,
                    "status_venta",
                    "status_venta form-control ",
                    "status_venta",
                    "text_vendedor",
                    "id_estatus_enid_service",
                    1,
                    1,
                    0,
                    "-"
                )
                ,
                "d-flex align-items-center justify-content-between bottom_30", 1


            ) ?>
            <?= place("place_tipificaciones") ?>


            <?= get_btw(

                div(strong("SALDO CUBIERTO"))
                ,
                div(

                    get_btw(

                        div(input(

                                [
                                    "class" => "form-control saldo_cubierto_pos_venta",
                                    "id" => "saldo_cubierto_pos_venta",
                                    "type" => "number",
                                    "step" => "any",
                                    "required" => "true",
                                    "name" => "saldo_cubierto",
                                    "value" => $recibo[0]["saldo_cubierto"]

                                ]
                            )
                        ),
                        div("MXN", ["class" => "ml-4 mxn "])
                        ,
                        "d-flex align-items-center justify-content-between "
                    )

                )
                ,
                "d-flex align-items-center justify-content-between bottom_30 form_cantidad_post_venta top_20", 1


            ) ?>
            <?= place("mensaje_saldo_cubierto_post_venta") ?>
            <?= get_form_cantidad($recibo, $orden) ?>
        </div>
        <?= div("SOLICITUD  ". br() . $recibo[0]["fecha_registro"], ["class" => "letter-spacing-5 "], 1) ?>

        <?= div(crea_fecha_entrega($recibo),["class"=> "letter-spacing-5 top_30 border padding_10 botttom_20"],1) ?>
        <?= crea_seccion_productos($recibo) ?>
        <?= create_fecha_contra_entrega($recibo, $domicilio) ?>
        <?= notificacion_por_cambio_fecha($recibo, $num_compras, $recibo[0]["saldo_cubierto"]); ?>
        <?= addNRow(crea_seccion_recordatorios($recordatorios, $tipo_recortario)) ?>
        <?= addNRow(create_seccion_tipificaciones($tipificaciones)) ?>
        <?= addNRow(get_form_nota($id_recibo)) ?>
        <?= addNRow(create_seccion_comentarios($comentarios, $id_recibo)) ?>
    </div>
    <?= div(get_format_resumen_cliente_compra($recibo, $tipos_entregas, $domicilio, $num_compras, $usuario, $id_recibo), 4) ?>
</div>
<?= get_hiddens_detalle($recibo) ?>
