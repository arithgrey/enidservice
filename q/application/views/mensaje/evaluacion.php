<div class="col-lg-6 col-lg-offset-3">
    <?= div(anchor_enid(img(
        [
                "src" => '../img_tema/enid_service_logo.jpg'
            ,
            'width' => '100%'
        ]
    ),
        ['href' => $url_request . "contact/#envio_msj"]), 4, 1) ?>
    <?= div(heading_enid('RECIBIMOS TU NOTIFICACIÓN!', 3, ["style" => "font-size: 2em;"]), 6, 1) ?>
    <?= hr() ?>
    <?= div(anchor_enid(
        add_element(
            "Ver más promociones", "button",
            ["class" => "btn a_enid_black"]),

        ["href" => $url_request]
    ), 6, 1) ?>
    <?= div(anchor_enid("Anuncia tus artículos", ["href" => $url_request . "login", "class" => "anunciar_productos"]), 6, 1) ?>
</div>