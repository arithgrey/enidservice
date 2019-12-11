<?= hiddens(
    [
        "class" => "in_session",
        "value" => $in_session
    ]
) ?>
<?= hiddens(
    [
        "name" => "titulo_web",
        "class" => "titulo_web",
        "value" => $titulo
    ]
) ?>


<?php if ($in_session == 0): ?>
    <?php

    $list_footer = [
        d(
            ul(

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
        d(
            ul(
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
        d(
            ul(


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


        d(
            ul(

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
<?php endif; ?>
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
<?= gb_modal() ?>
<?php if (prm_def($this->input->get(), "debug")): ?>
    <style>
        body * {
            border: solid 1px blue !important
        }
    </style>
<?php endif; ?>
</body>
<?= d("© 2019 ENID SERVICE.", "blue_enid3 white p-2 footer_enid w-100 col-lg-12") ?>
</html>
