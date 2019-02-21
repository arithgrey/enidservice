<div class="col-lg-8">
    <div class="col-lg-5">
        <div style="position: relative;">
            <?= div(img([
                "src" => "../imgs/index.php/enid/imagen_usuario/" . $id_usuario,
                "onerror" => "this.src='../img_tema/user/user.png'"
            ]), ["class" => "imagen_usuario_completa"]) ?>
            <?= anchor_enid("MODIFICAR", ["class" => "editar_imagen_perfil "]) ?>
        </div>
        <?= place("place_form_img") ?>
    </div>
    <div class="page-header menu_info_usuario">
        <?= get_format_user($usuario) ?>
    </div>
    <?= div("Mantén la calma esta información será solo será visible si tú lo permites ",
        ['class' => 'registro_telefono_usuario_lada_negocio blue_enid_background2 white padding_1'], 1) ?>
</div>
<div class="col-lg-4">
    <div class="contenedor_lateral">
        <?= heading_enid("TU CUENTA ENID SERVICE", 3) ?>
        <?= get_format_user($usuario, 1) ?>
        <?= addNRow(div(get_campo($usuario, "email", ""), ["class" => "top_20"], 1)) ?>
        <?= addNRow(get_campo($usuario, "tel_contacto", "Tu prime apellido", 1)) ?>
        <?= br() ?>
        <?= anchor_enid("MI DIRECCIÓN" . icon('fa  fa-fighter-jet'),
            ["class" => "a_enid_black btn_direccion top_20",
                "href" => "#tab_direccion",
                "data-toggle" => "tab"
            ],
            1,
            1) ?>
        <?= hr() ?>
    </div>
</div>
