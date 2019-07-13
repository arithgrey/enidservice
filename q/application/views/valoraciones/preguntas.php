<?= get_titulo_modalidad($modalidad) ?>
<?php

foreach ($preguntas as $row) {

    $pregunta = $row["pregunta"];
    $fecha_registro = $row["fecha_registro"];
    $url_imagen = get_url_imagen_pregunta($modalidad, $row);
    $img = img([
        'style' => 'width: 44px!important;',
        'src' => $url_imagen,
        'onerror' => "this.src='../img_tema/user/user.png'"
    ]);

    ?>

    <?= d(btw(
        d(
            append(
                [
                    $img,
                    sobre_el_producto($modalidad, $row),
                    d($pregunta),
                    d($fecha_registro)
                ]
            ), "popup-head-left pull-left"
        )
        ,
        val_respuestas($modalidad, $row)
        ,
        "popup-head"
    ),
        ["class" => "popup-box chat-popup", "id" => "qnimate", "style" => "margin-top: 4px;"]

    ) ?>

    <?php
}
?>
