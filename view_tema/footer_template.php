<?php
$list = [
    heading_enid("ASISTENCIA", 4, "strong"),
    anchor_enid("- Servicio al cliente",
        [
            "class" => 'black ',
            "href" => path_enid("contacto")
        ]),
    anchor_enid("-Términos y condiciones",
        [
            "class" => 'black ',
            "href" => path_enid("terminos-y-condiciones")
        ]
    )
];

$list2 = [
    heading_enid(
        "TEMAS RELACIONADOS"
        ,
        4
        ,
        "strong"
    ),
    anchor_enid(
        "- Temas de ayuda",
        [
            "class" => 'black ',
            "href" => path_enid("faqs")
        ])
];

$list3 = [
    heading_enid("ESPECIALES", 4, "strong"),
    anchor_enid("- Trabaja en nuestro equipo",
        [
            "class" => 'black ',
            "href" => "../unete_a_nuestro_equipo"
        ])];

$list4 = [
    heading_enid("ACERCA DE NOSOTROS", 4, "strong"),
    anchor_enid(
        img(
            [
                "src" => path_enid("img_logo")
            ]
        ),
        [
            "class" => 'black ',
            "href" => path_enid("sobre_enid")
        ])
];


$base = "col-lg-3 col-sm-6 inner";

$list_footer = [
    div(ul($list), $base),
    div(ul($list2), $base),
    div(ul($list3), $base),
    div(ul($list4), $base)
];
?>

<?= input_hidden([
    "class" => "in_session",
    "value" => $in_session
]) ?>
<?= input_hidden([
    "name" => "titulo_web",
    "class" => "titulo_web",
    "value" => $titulo
]) ?>
<?php if (!is_null($in_session) && $in_session < 1): ?>
    <?php if (!is_null($proceso_compra) && !isset($proceso_compra) || $proceso_compra == 0): ?>

        <div class="row shadow bloque_general_info ">
            <div class="base_compras col-lg-12 top_50 bottom_50 text-center">
                <div class='col-lg-3'>
                    <?= div(icon('fa  fa-fighter-jet'), 2) ?>
                    <?= div("FACILIDAD DE COMPRA", 'strong') ?>
                    <?= div("Compras seguras al momento") ?>
                    <?php if (!is_null($id_usuario) && isset($id_usuario)): ?>
                        <?= input_hidden([
                            "class" => 'id_usuario',
                            "value" => $id_usuario
                        ]) ?>
                    <?php endif; ?>
                </div>
                <?php

                $x = [];
                $x[] = div(icon('fa fa-clock-o '), 2);
                $x[] = div(append_data([
                    div("+ ENTREGAS PUNTUALES", 'strong', 1),
                    div("Recibe lo que deseas en tiempo y forma", 1)
                ]));
                ?>
                <?= div(append_data($x), 3) ?>


                <?php
                $c = [];
                $c[] = div(icon('fa fa-lock '), 2);
                $c[] = div(append_data([
                    div(" COMPRAS SEGURAS", 'strong', 1),
                    div("Tu dinero se entregará cuando confirmes tu entrega!", 1)
                ]));

                ?>
                <?= div(append_data($c), 3) ?>


                <?php

                $c = [];
                $c[] = div(icon('fa fa-angle-right'), 2);
                $c[] = div(append_data([
                    div(" FAQS", 'strong', 1),
                    div("Lo que te intereza saver!", 1)
                ]));

                ?>
                <?= div(anchor_enid(append_data($c),
                    [
                        "href" => path_enid("faqs"),
                        "class" => "white"
                    ]), 3) ?>

            </div>

        </div>
        <?= hr() ?>
    <?php endif; ?>
<?php endif; ?>



<?php if ($in_session == 0): ?>
    <?php if (!isset($proceso_compra) && !is_null($proceso_compra) && $proceso_compra == 0): ?>
        <?= div(print_footer($list_footer), "base_paginas_extra" , 1) ?>
    <?php endif ?>
    <?php if (isset($is_mobile) && !is_null($is_mobile) && $is_mobile < 1): ?>
        <?php if (!isset($proceso_compra) || $proceso_compra == 0): ?>
            <?= div(get_metodos_pago(), 1) ?>
        <?php endif ?>
    <?php endif ?>
    <?= div(
        get_btw(
            div("© 2019 ENID SERVICE.")
            ,
            div(
                anchor_enid("FAQS", ["class" => "white", "href" => path_enid("faqs")]) .
                anchor_enid("NOSOTROS", ["class" => "white ml-5", "href" => path_enid("sobre_enid")])
            )
            ,
            'white footer-enid page-footer  d-flex align-items-center justify-content-between'

        )) ?>
<?php endif; ?>


<link rel="stylesheet" type="text/css" href="../css_tema/template/font.css">
<style>
    body {
        font-family: 'Ubuntu', sans-serif !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="../css_tema/template/main.css?<?= version_enid ?>">
<link rel="stylesheet" type="text/css" href="../css_tema/template/4bootstrap.min.css">

<link href="../css_tema/template/bootstrap.min.css?<?= version_enid ?>" rel="stylesheet" id="bootstrap-css">
<?php if (isset($css) && !is_null($css) && is_array($css) && count($css) > 0): ?>
    <?php foreach ($css as $c): $link = "../css_tema/template/" . $c; ?>

        <?php if (file_exists($link)): ?>
            <link rel="stylesheet" type="text/css" href="<?= $link; ?>?<?= version_enid ?>">
        <?php else: ?>
            NO SE CARGO ->  <?= print_r($link) ?><br>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($css_external) && !is_null($css_external) && is_array($css_external)): ?>
    <?php foreach ($css_external as $c): ?>
        <?php if (file_exists($c)): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $c; ?>?<?= version_enid ?>">
        <?php else: ?>
            NO SE CARGO ->  <?= print_r($c) ?>
            <?= br() ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
<script src="../js_tema/js/main.js?<?= version_enid ?>"></script>
<?php if (isset($js) && !is_null($js) && is_array($js)): ?>
    <?php $s = "../js_tema/";
    foreach ($js as $script): ?>
        <?php $file = $s . $script;
        if (file_exists($file)): ?>
            <script type='text/javascript' src='<?php echo $file; ?>?<?= version_enid ?>'></script>
        <?php else: ?>
            NO SE CARGO ->  <?= print_r($script) ?>
            <?= br() ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($js_extra) && !is_null($js_extra) && is_array($js_extra)): ?>
    <?php foreach ($js_extra as $script): ?>
        <?php if (file_exists($script)): ?>
            <script type='text/javascript' src='<?php echo $script; ?>'></script>
        <?php else: ?>
            NO SE CARGO <?= print_r($script) ?><br>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
<link rel="stylesheet" href="../css_tema/font-asome2/css/font-awesome.min.css?<?= version_enid ?>">
<div class="modal" tabindex="-1" role="dialog" id="modal-error-message">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <?=div(
                        p(
                                span(
                                        "", "text-order-name-error"
                                )
                                , "font-weight-bold text-dark"
                        ) , "modal-body"
                )?>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>