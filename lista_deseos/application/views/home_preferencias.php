<?= div(get_menu(), ["class" => "col-lg-2"]) ?>
<?= div(get_list_clasificaciones($is_mobile, $preferencias, $tmp), ["class" => "col-lg-10"]) ?>
<?= hr() ?>
<div class="col-lg-8 col-lg-offset-2">
    <div id="slider">
        <ul class="slides">
            <li class="single-slide slide-2 active">
                <?= get_format_temporadas() ?>
            </li>
            <li class="single-slide slide-3">
                <?= get_format_images_preferencias() ?>
            </li>
            <li class="single-slide slide-4">
                <?= get_format_images() ?>
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
