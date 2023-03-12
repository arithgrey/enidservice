<div class="row top_150 base_enid_web">
    <?= d(get_menu($in_session), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= hiddens([
                "class" => 'id_usuario',
                "value" => $id_usuario
            ]) ?>
            <?= hiddens([
                "class" => 'q',
                "value" => $q
            ]) ?>
            <?= d(get_format_info_usuario($departamentos), ["class" => "tab-pane active ", "id" => "tab1"]) ?>
            <?= tab_seccion(form_recurso(),'configurar_recurso',0) ?>

            <?= d(get_format_afiliados(), ["class" => "tab-pane", "id" => 'tab_productividad_ventas']); ?>
            <div class="tab-pane" id='tab_perfiles_permisos'>
                <?= h("Perfiles / permisos", 3) ?>
                <div class="col-lg-3">
                    <?= h(_text_("Perfil" , icon("fa fa-space-shuttle")), 4) ?>
                    <?= create_select(
                        $perfiles_enid_service,
                        "perfil",
                        "form-control perfil_enid_service",
                        "perfil_enid_service",
                        "nombreperfil",
                        "idperfil") ?>
                </div>
                <div class='col-lg-9'>
                    <div class="tab-content">
                        <?= d(d(
                            _text(
                                h("Recurso", 3)
                                ,
                                tab("+ Agregar Recurso", "#tab_agregar_recursos")
                                ,
                                place("place_perfilles_permisos")
                            )
                        ),
                            [
                                "class" => "tab-pane active ", "id" => "sec_0"
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
            <?= d(get_form_agregar_recurso(), ["class" => "tab-pane", "id" => 'tab_agregar_recursos']) ?>
            <?= d(get_format_categorias(), ["class" => "tab-pane", "id" => 'tab_agregar_categorias']) ?>
            <?= d(get_format_tipo_clasificacion(), ["class" => "tab-pane", "id" => 'agregar_tallas']) ?>
            <?= d(get_format_view_usuario($departamentos,$perfiles_enid_service), ["class" => "tab-pane", "id" => 'tab_mas_info_usuario']) ?>
            <?= d(get_format_view_orden($info_empresa), ["class" => "tab-pane", "id" => 'tab_orden']) ?>
            <?= d(get_format_format_mas_vendidos($mas_vendidos), ["class" => "tab-pane", "id" => 'tab_mas_vendidos']) ?>
        </div>
    </div>
</div>
