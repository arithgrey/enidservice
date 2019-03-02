<div class="contenedor_principal_enid">
    <div class="col-lg-2">
        <nav class="nav-sidebar">
            <?= get_menu($id_usuario); ?>
        </nav>
    </div>
    <div class="col-lg-10">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_mis_datos">
                <?= $this->load->view("micuenta/cuenta"); ?>
            </div>
            <div class="tab-pane " id="tab_privacidad">
                <?= get_btw(
                    heading_enid("ACTUALIZAR DATOS DE ACCESO", 3),
                    get_form_set_password(),
                    "col-lg-4 col-lg-offset-4"
                ) ?>
            </div>
            <div class="tab-pane " id="tab_privacidad_seguridad">
                <?= get_format_privacidad_seguridad() ?>
            </div>
            <div class="tab-pane " id="tab_direccion">
                <?= get_format_calma() ?>
            </div>
        </div>
    </div>
</div>

	