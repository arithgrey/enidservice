<?php
$menu = [li(heading_enid("¿Tienes alguna duda?", ["class" => 'strong'])),
    li(div("Lunes a Viernes de 08:00 a 19:00 y  Sábados de 09:00 a 18:00", 1)),

    li(div("Síguenos en", 1)),

    li(anchor_enid("", [
        "href" => $url_facebook,
        "target" => "_black",
        "class" => "fa fa-facebook black",
        "title" => "Compartir en Facebook"
    ])),

    li(anchor_enid("",
        [
            "class" => "fa fa-twitter black",
            "title" => "Tweet",
            "target" => "_black",
            "data-size" => "large",
            "href" => $url_twitter,
        ])),

    li(anchor_enid("", [
        "href" => $url_pinterest,
        "class" => "fa fa-pinterest-p black",
        "title" => "Pin it"
    ])),

    li(anchor_enid("", [
        "href" => $url_tumblr,
        "class" => "fa fa-tumblr black",
        "title" => "Tumblr"
    ])),

    li(mailto("ventas@enidservice.com", icon("fa fa-envelope-open black")))];

?>

<?= anchor(img_enid(), ["href" => path_enid("faqs")]) ?>
<?= hidden(["class" => "in_session", "value" => $in_session]) ?>
<?= ul($menu) ?>
