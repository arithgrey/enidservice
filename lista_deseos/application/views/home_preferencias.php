<div class="contenedor_principal_enid">
    <?= div(get_menu(), ["class" => "col-lg-2"]) ?>
    <?= div(get_list_clasificaciones($is_mobile, $preferencias, $tmp), ["class" => "col-lg-10"]) ?>
</div>
<?= hr() ?>
<div class="col-lg-8 col-lg-offset-2">
    <div id="slider">
        <ul class="slides">
            <li class="single-slide slide-2 active">
                <?= append_data([
                    div("Apparel", ["class" => "slide-label"]),

                    div(img([
                        "src" => "../img_tema/preferencias/preferencias-1.jpg",
                        "class" => "from-left"
                    ]), ["class" => "slide-image animate"]),

                    div(get_format_temporada(), ["class" => "slide-content"])

                ]) ?>
            </li>
            <li class="single-slide slide-3">
                <?= append_data([
                    div("Bags", ["class" => "slide-label"]),
                    div(img([
                            "src" => "../img_tema/preferencias/preferencias-2.jpg",
                            "class" => "from-left"
                        ])
                        , ["class" => "slide-image animate"]),

                    div(get_format_slide_accesorios(), ["class" => "slide-content"])

                ]) ?>


            </li>
            <li class="single-slide slide-4">

                <?= div("Diferentes estilos", ["class" => "slide-label"]) ?>
                <?= div(img(["src" => "../img_tema/preferencias/preferencias-4.jpg",
                    "class" => "from-left",
                    "alt" => "image-3"]), ["class" => "slide-image animate"]) ?>


                <?= div(append_data([
                    div(
                        heading_enid("Encuentra entre múltiples opciones", 3,

                            ["class" => "from-bottom"]),
                        ["class" => "animate"]),

                    p("Para Dama y Caballero"),

                    heading_enid(
                        "Mira las opciones", 3,
                        [
                            "class" => "shop-now",
                            "href" => "../search"],
                        1)

                ]),
                    ["class" => "slide-content"]) ?>
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
