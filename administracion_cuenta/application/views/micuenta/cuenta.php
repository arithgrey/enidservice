<div class="col-lg-8">
    <div class="col-lg-5">
        <div style="position: relative;">
            <?=get_format_perfil_usuario($id_usuario)?>
        </div>
        <?= place("place_form_img") ?>
    </div>
    <?= div(get_format_user($usuario), ["class" => "page-header menu_info_usuario"]) ?>
    <?= div("Mantén la calma esta información será solo será visible si tú lo permites ", ['class' => 'registro_telefono_usuario_lada_negocio blue_enid_background2 white padding_1'], 1) ?>
</div>
<div class="col-lg-4">
    <div class="contenedor_lateral">
        <?=get_format_resumen_cuenta($usuario)?>
    </div>
</div>
