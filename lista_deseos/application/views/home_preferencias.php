<?= div(get_menu(), 2) ?>
<?= div(get_list_clasificaciones($is_mobile, $preferencias, $tmp), 10) ?>
<?= hr() ?>
<div class="col-lg-8 col-lg-offset-2">
    <div id="slider">
        <?= ul([
            li(get_format_temporadas(), "single-slide slide-2 active"),
            li(get_format_images_preferencias(), "single-slide slide-3"),
            li(get_format_images(), "single-slide slide-4"),

        ],
            "slides"
        ) ?>
        <?= get_btw(

            div(img(["src" => "../img_tema/preferencias/up-arrow.png"]), "slide-nav-up")
            ,
            div(img(["src" => "../img_tema/preferencias/up-arrow.png"]), "slide-nav-down")
            ,
            "slider-nav"
        ) ?>
    </div>
</div>
<hr>
