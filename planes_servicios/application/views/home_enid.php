<div class='contenedor_principal_enid'>
    <div class='col-lg-2'>
        <?= $this->load->view("menu") ?>
    </div>
    <div class='col-lg-10'>
        <div class="tab-content">
            <div class="tab-pane <?= valida_active_tab(0, $action, $considera_segundo) ?>" id='tab_servicios'>
                <?= $this->load->view("secciones/servicios"); ?>
            </div>
            <div class="tab-pane <?= valida_active_tab(1, $action) ?>" id='tab_form_servicio'>
                <?= $this->load->view("secciones/form_servicios") ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <?= get_top_articulos($top_servicios, $is_mobile) ?>
    </div>
</div>
<?= get_formar_hiddens($is_mobile, $action, $extra_servicio) ?>