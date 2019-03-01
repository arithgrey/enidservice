<hr>
<div class="col-lg-8 col-lg-offset-2">
    <div id="slider">
        <ul class="slides">
            <li class="single-slide slide-2 active">
                <?= div("Apparel", ["class" => "slide-label"]) ?>
                <?= div(img([
                    "src" => "../img_tema/preferencias/preferencias-1.jpg",
                    "class" => "from-left"
                ]), ["class" => "slide-image animate"]) ?>
                <div class="slide-content">
                    <?= get_format_temporada() ?>
                </div>
            </li>
            <li class="single-slide slide-3">
                <?= div("Bags", ["class" => "slide-label"]) ?>
                <?= div(img([
                        "src" => "../img_tema/preferencias/preferencias-2.jpg",
                        "class" => "from-left"
                    ])
                    , ["class" => "slide-image animate"]) ?>
                <div class="slide-content">
                    <?= get_format_slide_accesorios() ?>
                </div>
            </li>
            <li class="single-slide slide-4">
                <?= div("Diferentes estilos", ["class" => "slide-label"]) ?>
                <?= div(img(["src" => "../img_tema/preferencias/preferencias-4.jpg",
                    "class" => "from-left",
                    "alt" => "image-3"]), ["class" => "slide-image animate"]) ?>
                <div class="slide-content">
                    <?= div(
                        heading_enid("Encuentra entre múltiples opciones", 3,

                            ["class" => "from-bottom"]),
                        ["class" => "animate"]) ?>

                    <?= p("Para Dama y Caballero") ?>

                    <?= heading_enid(
                        "Mira las opciones", 3,
                        [
                            "class" => "shop-now",
                            "href" => "../search"],
                        1) ?>
                </div>
            </li>
        </ul>
        <?= get_btw(
            div(img(["src" => "../img_tema/preferencias/up-arrow.png", "alt" => "up"]), ["class" => "slide-nav-up"]),
            div(img(["src" => "../img_tema/preferencias/up-arrow.png", "alt" => "down"]), ["class" => "slide-nav-down"]),
            "slider-nav"
        ) ?>
    </div>
</div>
<hr>