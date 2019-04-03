<div class="contenedor_principal_enid">
    <?= div(get_menu($in_session), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= input_hidden([
                "class" => 'id_usuario',
                "value" => $id_usuario
            ]) ?>
            <div class="tab-pane active " id="tab1">
                <?= get_format_info_usuario() ?>
            </div>
            <div class="tab-pane" id='tab_productividad_ventas'>
                <?= get_format_afiliados(); ?>
            </div>
            <div class="tab-pane" id='tab_perfiles_permisos'>
                <?= $this->load->view("secciones_2/perfiles_permisos_seccion"); ?>
            </div>
            <div class="tab-pane" id='tab_agregar_recursos'>
                <?= get_form_agregar_recurso() ?>
            </div>
            <div class="tab-pane" id='tab_agregar_categorias'>
                <?= get_format_categorias() ?>
            </div>
            <div class="tab-pane" id='agregar_tallas'>
                <?= get_format_tipo_clasificacion() ?>
            </div>
            <div class="tab-pane" id='tab_mas_info_usuario'>
                <?= get_format_view_usuario() ?>
            </div>
        </div>
    </div>
</div>
