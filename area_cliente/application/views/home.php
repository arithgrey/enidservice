<div class="contenedor_principal_enid">
    <?= div(get_menu($action), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= div(place("place_servicios_contratados"), ["class" => "tab-pane " . valida_active_tab('compras', $action), "id" => 'tab_mis_pagos']) ?>
            <?= div(place("place_ventas_usuario"), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_mis_ventas']) ?>
            <?= div(get_format_valoraciones($valoraciones, $id_usuario, $alcance), ["class" => "tab-pane " . valida_active_tab('ventas', $action), "id" => 'tab_valoraciones']) ?>
            <?= div(place("place_pagar_ahora"), ["class" => "tab-pane", "id" => "tab_pagos"]) ?>
            <?= div(place("place_resumen_servicio"), ["class" => "tab-pane", "id" => "tab_renovar_servicio"]) ?>
        </div>
    </div>
</div>
<?= get_hiddens_tickects($action, $ticket) ?>
<?= div("",
    [
        "class" => "resumen_pagos_pendientes",
        "href" => "#tab_renovar_servicio",
        "data-toggle" => "tab"
    ]) ?>