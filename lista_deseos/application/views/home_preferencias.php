<?= div(get_menu(), 2) ?>
<?= div(get_list_clasificaciones($is_mobile, $preferencias, $tmp), 10) ?>
<?= hr() ?>
<div class="col-lg-8 col-lg-offset-2">
    <div id="slider">
        <?= ul([
            li(get_format_temporadas(), ["class" => "single-slide slide-2 active"]),
            li(get_format_images_preferencias(), ["class" => "single-slide slide-3"]),
            li(get_format_images(), ["class" => "single-slide slide-4"]),

        ], ["class" => "slides"]) ?>
        <?= get_btw(
            div(img(["src" => "../img_tema/preferencias/up-arrow.png", "alt" => "up"]), ["class" => "slide-nav-up"]),
            div(img(["src" => "../img_tema/preferencias/up-arrow.png", "alt" => "down"]), ["class" => "slide-nav-down"]),
            "slider-nav"
        ) ?>
    </div>
</div>
<hr>
