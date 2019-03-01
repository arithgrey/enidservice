<div class="contenedor_principal_enid">
    <div class="col-lg-2">
        <?= get_menu($action) ?>
    </div>
    <div class='col-lg-10'>
        <div class="tab-content">
            <div class="tab-pane <?= valida_active_tab('preguntas', $action) ?>" id="tab_buzon">
                <?= heading_enid("BUZÓN", 3) ?>
                <?= hr() ?>
                <?= div(append_data(

                    anchor_enid("HECHAS" .
                        span("", ['class' => 'notificacion_preguntas_sin_leer_cliente']),
                        ["class" => "a_enid_black preguntas btn_preguntas_compras",
                            "id" => '0'
                        ]
                    )
                    ,

                    anchor_enid(
                        "RECIBIDAS" .
                        span("", ['class' => 'notificacion_preguntas_sin_leer_ventas'])
                        ,
                        [
                            "class" => "a_enid_blue preguntas ",
                            "id" => "1"
                        ])

                )) ?>
                <?= place("place_buzon") ?>
            </div>
            <?= div(place("place_servicios_contratados"), ["class" => "tab-pane " . valida_active_tab('compras', $action), "id" => 'tab_mis_pagos']) ?>
            <div class="tab-pane <?= valida_active_tab('ventas', $action) ?>" id='tab_mis_ventas'>
                <?= get_format_valoraciones($valoraciones, $id_usuario, $alcance) ?>
            </div>
            <?= div(place("place_pagar_ahora"), ["class" => "tab-pane", "id" => "tab_pagos"]) ?>
            <?= div(place("place_resumen_servicio"), ["class" => "tab-pane", "id" => "tab_renovar_servicio"]) ?>
        </div>
    </div>
</div>
<?= input_hidden(["class" => "action", "value" => $action]) ?>
<?= input_hidden(["class" => "ticket", "value" => $ticket]) ?>

<?= div("", [
    "class" => "resumen_pagos_pendientes",
    "href" => "#tab_renovar_servicio",
    "data-toggle" => "tab"
]) ?>
