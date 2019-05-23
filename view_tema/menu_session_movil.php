<div id="mySidenav" class="sidenav">
    <?= anchor_enid("×",
        [
            "href" => "javascript:void(0)",
            "class" => "closebtn closebtn_lateral",
            "onclick" => "closeNav()"
        ]) ?>

    <?= div(
        anchor_enid(img_enid([]),
            [
                    "href" => path_enid("home")
            ]
        ), "logo_lateral_login"
    ) ?>


    <form class="form" action="../search">
        <?= input(["name" => "q", "placeholder" => "Articulo ó servicio", "class" => "input_search"]) ?>
        <?= guardar("BUSCAR", ['class' => 'boton-busqueda'], 1) ?>
        <?= form_close() ?>

        <?php if ($in_session < 1): ?>
            <?= get_btw(
                anchor_enid("INICIAR SESSION",
                    [
                        "class" => "iniciar_sesion_lateral",
                        "style" => "color: white!important;",
                        "href" => "../login"
                    ],
                    1)
                ,
                anchor_enid("ANUNCIA TU NEGOCIO AQUÍ" . icon('fa fa-user'),
                    [
                        "class" => "call_to_action_anuncio",
                        "style" => "color: white!important;",
                        "href" => path_enid("nuevo_usuario")
                    ],
                    1),
                "contenedor-lateral-menu"

            ) ?>
        <?php else: ?>
        <?php endif; ?>
</div>