<div class="col-lg-6 col-lg-offset-3">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="text-center">
            <?= anchor_enid(img(
                ["src" => '../img_tema/enid_service_logo.jpg',
                    'width' => '100%']),
                ['href' => $url_request . "contact/#envio_msj"]); ?>
        </div>
    </div>
    <div class="col-lg-6 col-lg-offset-3">
        <div class="text-center">
            <?= heading_enid('RECIBIMOS TU NOTIFICACIÓN!', '3',
                ["style" => "font-size: 2em;"]); ?>
        </div>
    </div>
    <hr>
    <div class="col-lg-6 col-lg-offset-3">
        <?= anchor_enid(
            add_element(
                "Ver más promociones", "button",
                ["class" => "btn a_enid_black"]),

            ["href" => $url_request]
        ) ?>

    </div>
    <div class="col-lg-6 col-lg-offset-3">
        <?= anchor_enid("Anuncia tus artículos",
            ["href" => $url_request . "login", "class" => "anunciar_productos"]) ?>

    </div>
</div>