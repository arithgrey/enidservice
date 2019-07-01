<div class='contenedor_principal_enid'>
    <div class='col-lg-2'>
    <?= get_menu($id_perfil ,$is_mobile, $action) ?>
    <?php $extra_estilos = ($action == 1) ? " display_none " : " "; ?>
    <?= btw(
        heading_enid("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA", 3)
        ,
        get_top_ventas($top_servicios)
        ,
        "contenedor_top " . $extra_estilos

    ) ?>
    </div>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= div(get_format_articulos_venta($list_orden), ["class" => "tab-pane " . valida_active_tab(0, $action, $considera_segundo), "id" => 'tab_servicios']) ?>
            <div class="tab-pane <?= valida_active_tab(1, $action) ?>" id='tab_form_servicio'>
                <?=get_form_ventas($ciclo_facturacion,$error_registro,$is_mobile)?>
            </div>
        </div>
    </div>
    <?= div(get_top_articulos($top_servicios, $is_mobile), 2) ?>
</div>
<?= get_formar_hiddens($is_mobile, $action, $extra_servicio,$id_perfil) ?>