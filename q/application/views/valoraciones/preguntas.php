<?= get_titulo_modalidad($modalidad) ?>
<?php
$l = "";
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
    <div class="popup-box chat-popup" id="qnimate" style="margin-top: 4px;">
        <?= btw(
            div(
                append(
                    [
                        $img,
                        get_texto_sobre_el_producto($modalidad, $row),
                        div($pregunta),
                        div($fecha_registro)
                    ]
                ), "popup-head-left pull-left"
            )
            ,
            valida_respuestas_nuevas($modalidad, $row)
            ,
            "popup-head"
        ) ?>
    </div>
    <?php
}
?>
<?= $l; ?>
