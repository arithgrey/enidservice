<div class="contenedor_principal_enid">
    <?= div(get_menu($id_usuario), 2); ?>
    <div class="col-lg-10">
        <div class="tab-content">

            <?= div(get_format_foto_usuario($id_usuario, $usuario), ["class" => "tab-pane active", "id" => "tab_mis_datos"]) ?>

            <div class="tab-pane " id="tab_privacidad">
                <?= get_btw(

                    heading_enid("ACTUALIZAR DATOS DE ACCESO", 3)
                    ,
                    get_form_set_password()
                    ,
                    4,
                    1

                ) ?>
            </div>
            <?= div(get_format_privacidad_seguridad(), ["class" => "tab-pane ", "id" => "tab_privacidad_seguridad"]) ?>
            <?= div(get_format_calma(), ["class" => "tab-pane ", "id" => "tab_direccion"]) ?>

        </div>
    </div>
</div>

