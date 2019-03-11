<div class="seccion_registro_nuevo_usuario_enid_service">
    <?= get_format_nuevo_usuario() ?>
</div>
<div class="contenedor_recuperacion_password display_none">
    <?= get_format_recuperacion_pw() ?>
</div>
<div class="wrapper_login">
    <?= anchor_enid(
        "SOY NUEVO, CREAR UNA CUENTA!",
        ["class" => "btn_soy_nuevo",
            "style" => "color: white!important;"], 1); ?>
    <?= div(
        anchor_enid(
            img(
                ["src" => "../img_tema/enid_service_logo.jpg"]),
            ["href" => "../"],
            1),
        ["class" => "col-lg-6 col-lg-offset-3"]
        , ["class" => "col-lg-4 col-lg-offset-4"]) ?>


    <?= div(get_form_login(), ["class" => "col-lg-4 col-lg-offset-4"]) ?>
    <div class="col-lg-4 col-lg-offset-4">
        <?= get_format_olvide_pw($action) ?>
    </div>
</div>
<?= input_hidden(
    [
        "class" => "action",
        "value" => $action],
    1
); ?>