<div class="contenedor_principal_enid">
    <?= d(get_menu($in_session), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= hiddens([
                "class" => 'id_usuario',
                "value" => $id_usuario
            ]) ?>
            <?= d(get_format_info_usuario(), ["class" => "tab-pane active ", "id" => "tab1"]) ?>
            <?= d(get_format_afiliados(), ["class" => "tab-pane", "id" => 'tab_productividad_ventas']); ?>
            <div class="tab-pane" id='tab_perfiles_permisos'>
                <?= h("Perfiles / permisos", 3) ?>
                <div class="col-lg-3">
                    <?= h("Perfil" . icon("fa fa-space-shuttle"), 4) ?>
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
                        <?= d(append([
                            h("Recurso", 3),

                            a_enid("+ Agregar Recurso",
                                [
                                    "href" => "#tab_agregar_recursos",
                                    "data-toggle" => "tab",
                                    "class" => "btn input-sm"
                                ]),

                            place("place_perfilles_permisos")
                        ]),
                            ["class" => "tab-pane active ", "id" => "sec_0"]) ?>
                    </div>
                </div>
            </div>
            <?= d(get_form_agregar_recurso(), ["class" => "tab-pane", "id" => 'tab_agregar_recursos']) ?>
            <?= d(get_format_categorias(), ["class" => "tab-pane", "id" => 'tab_agregar_categorias']) ?>
            <?= d(get_format_tipo_clasificacion(), ["class" => "tab-pane", "id" => 'agregar_tallas']) ?>
            <?= d(get_format_view_usuario($departamentos), ["class" => "tab-pane", "id" => 'tab_mas_info_usuario']) ?>
        </div>
    </div>
</div>
