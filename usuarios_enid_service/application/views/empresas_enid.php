<div class="contenedor_principal_enid">
    <?= d(get_menu($in_session), 2) ?>
    <div class='col-lg-10'>
        <div class="tab-content">
            <?= hiddens([
                "class" => 'id_usuario',
                "value" => $id_usuario
            ]) ?>
            <?= tab_seccion(get_format_info_usuario(), "tab1", 1) ?>
            <?= tab_seccion(get_format_afiliados(), 'tab_productividad_ventas') ?>
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

                        <?= tab_seccion(
                            _text(
                                h("Recurso", 3)
                                ,
                                tab("+ Agregar Recurso", "#tab_agregar_recursos")
                                ,
                                place("place_perfilles_permisos")
                            )
                            ,
                            "sec_0", 1
                        ) ?>
                    </div>
                </div>
            </div>
            <?= tab_seccion(
                get_form_agregar_recurso(),
                'tab_agregar_recursos'
            ) ?>

            <?= tab_seccion(
                get_format_categorias(),
                'tab_agregar_categorias'
            ) ?>

            <?= tab_seccion(
                get_format_tipo_clasificacion(),
                'agregar_tallas'
            ) ?>
            <?= tab_seccion(
                get_format_view_usuario($departamentos),
                'tab_mas_info_usuario'
            ) ?>
        </div>
    </div>
</div>
