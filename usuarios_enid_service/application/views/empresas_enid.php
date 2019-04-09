<div class="contenedor_principal_enid">
    <?= div(get_menu($in_session), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= input_hidden([
                "class" => 'id_usuario',
                "value" => $id_usuario
            ]) ?>
            <?= div(get_format_info_usuario(), ["class" => "tab-pane active ", "id" => "tab1"]) ?>
            <?= div(get_format_afiliados(), ["class" => "tab-pane", "id" => 'tab_productividad_ventas']); ?>
            <div class="tab-pane" id='tab_perfiles_permisos'>
                <?= $this->load->view("secciones_2/perfiles_permisos_seccion"); ?>
            </div>
            <?= div(get_form_agregar_recurso(), ["class" => "tab-pane", "id" => 'tab_agregar_recursos']) ?>
            <?= div(get_format_categorias(), ["class" => "tab-pane", "id" => 'tab_agregar_categorias']) ?>
            <?= div(get_format_tipo_clasificacion(), ["class" => "tab-pane", "id" => 'agregar_tallas']) ?>
            <?= div(get_format_view_usuario($departamentos), ["class" => "tab-pane", "id" => 'tab_mas_info_usuario']) ?>
        </div>
    </div>
</div>
