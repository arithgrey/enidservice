<div class="seccion_registro_nuevo_usuario_enid_service">

    <?= anchor_enid(
        "ACCEDER AHORA",
        [
            "class" => "btn_acceder_cuenta_enid a_enid_blue",
            "id" => "btn_acceder_cuenta_enid",
            'style' => "color:white!important"

        ]) ?>

    <?= addNRow(div(div(anchor_enid(img(["src" => "../img_tema/enid_service_logo.jpg"])), ["class" => "col-lg-6 col-lg-offset-3"]), ["class" => "col-lg-4 col-lg-offset-4"])) ?>
    <?= addNRow(div(heading('ÚNETE A ENID SERVICE', 3), ["class" => "col-lg-4 col-lg-offset-4"])) ?>
    <?= div(get_form_registro() , ["class"=>"col-lg-4 col-lg-offset-4"] ) ?>

</div>
<!--RECUPERAR CONTRASEÑA-->
<div class="contenedor_recuperacion_password display_none" >

    <?= anchor_enid("ACCEDER AHORA!",
        [
            "class" => "btn_acceder_cuenta_enid a_enid_blue",
            "id" => "btn_acceder_cuenta_enid",
            "style" => "color: white!important"
        ],
        1
    ); ?>
    <?= anchor_enid(div(div(img(["src" => "../img_tema/enid_service_logo.jpg"]), ["class" => "col-lg-6 col-lg-offset-3"]), ["class" => "col-lg-4 col-lg-offset-4"]), ["href" => "../"], 1) ?>

    <div class="col-lg-4 col-lg-offset-4">
        <?= heading('RECUPERA TUS DATOS DE ACCESO', '3') ?>
        <?= get_form_recuperacion() ?>
    </div>


</div>
<div class="wrapper_login">

    <?= anchor_enid(
        "SOY NUEVO, CREAR UNA CUENTA!",
        ["class" => "btn_soy_nuevo",
            "style" => "color: white!important;"], 1); ?>


    <div class="col-lg-4 col-lg-offset-4">

        <?= div(anchor_enid(
            img(
                ["src" => "../img_tema/enid_service_logo.jpg"]),
            ["href" => "../"],
            1),
            ["class" => "col-lg-6 col-lg-offset-3"]
        ) ?>

    </div>

    <?=div(get_form_login() ,  ["class"=>"col-lg-4 col-lg-offset-4"])  ?>


    <div class="col-lg-4 col-lg-offset-4">
        <?= place("place_acceso_sistema top_20 bottom_20") ?>
        <?= anchor_enid(
            "¿OLVIDASTE TU CONTRASEÑA?",
            [
                "id" => "olvide-pass",
                "class" => "recupara-pass  olvide_pass "
            ],
            1
        ); ?>
        <?= anchor_enid(
            div(strong("¿ERES NUEVO?", ["class" => "black"]) . "  REGISTRA UNA AHORA!", ['class' => 'llamada-a-la-accion '])
            ,
            ['class' => 'registrar-cuenta registrar_cuenta']
        ) ?>

        <?php if ($action === "registro") { ?>
            <?= div("COMPRA O VENDE ACCEDIENDO A TU CUENTA!", ["class" => "mensaje_bienvenida"]) ?>
        <?php } ?>
    </div>
</div>
<?= input_hidden(
    [
        "class" => "action",
        "value" => $action],
    1
); ?>