<div class='contenedor_principal_enid'>
    <div class='col-lg-2'>
        <?= $this->load->view("menu") ?>
    </div>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= div(get_format_articulos_venta($list_orden), ["class" => "tab-pane " . valida_active_tab(0, $action, $considera_segundo), "id" => 'tab_servicios']) ?>
            <div class="tab-pane <?= valida_active_tab(1, $action) ?>" id='tab_form_servicio'>
                <?= $this->load->view("secciones/form_servicios") ?>
            </div>
        </div>
    </div>
    <?= div(get_top_articulos($top_servicios, $is_mobile), 2) ?>
</div>
<?= get_formar_hiddens($is_mobile, $action, $extra_servicio) ?>