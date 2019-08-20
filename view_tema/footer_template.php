<?= input_hidden([
    "class" => "in_session",
    "value" => $in_session
]) ?>
<?= input_hidden([
    "name" => "titulo_web",
    "class" => "titulo_web",
    "value" => $titulo
]) ?>


<?php if ($in_session == 0): ?>
    <?php

    $list_footer = [
        d(ul(

            [
                h("ASISTENCIA", 4, "strong"),
                a_enid("- Servicio al cliente",
                    [
                        "class" => 'black ',
                        "href" => path_enid("contacto")
                    ]
                ),
                a_enid("-Términos y condiciones",
                    [
                        "class" => 'black ',
                        "href" => path_enid("terminos-y-condiciones")
                    ]
                )
            ]


        ), 3),
        d(ul(


            [
                h(
                    "TEMAS RELACIONADOS"
                    ,
                    4
                    ,
                    "strong"
                ),
                a_enid(
                    "- Temas de ayuda",
                    [
                        "class" => 'black ',
                        "href" => path_enid("faqs")
                    ]
                )
            ]


        ), 3),
        d(ul(


            [
                h("ESPECIALES", 4, "strong"),
                a_enid("- Trabaja en nuestro equipo",
                    [
                        "class" => 'black ',
                        "href" => "../unete_a_nuestro_equipo"
                    ]
                )
            ]


        ), 3),


        d(ul(

            [
                h("ACERCA DE NOSOTROS", 4, "strong"),
                a_enid(
                    img(
                        [
                            "src" => path_enid("img_logo")
                        ]
                    ),
                    [
                        "class" => 'black ',
                        "href" => path_enid("sobre_enid")
                    ]
                )
            ]

        ), 3)
    ];

    ?>
    <?php if (!isset($proceso_compra) && !is_null($proceso_compra) && $proceso_compra == 0): ?>
        <?= d(append($list_footer), "base_paginas_extra", 1) ?>
    <?php endif ?>

    <?= d(
        btw(
            d("© 2019 ENID SERVICE.")
            ,
            d(
                a_enid("FAQS", ["class" => "white", "href" => path_enid("faqs")]) .
                a_enid("NOSOTROS", ["class" => "white ml-5", "href" => path_enid("sobre_enid")])
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
<?= gb_modal() ?>
</body>
</html>