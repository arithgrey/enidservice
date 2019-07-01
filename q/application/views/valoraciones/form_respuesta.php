<?php
$next = 0;
if ($info_usuario != 0) {
    $cliente = $info_usuario[0];
    $nombre = $cliente["nombre"] . " " . $cliente["apellido_paterno"];
    $telefono =
        (strlen($cliente["tel_contacto"]) > 4) ? $cliente["tel_contacto"] :
            $cliente["tel_contacto_alterno"];
    $next++;
}
?>
<?= heading_enid($data_send["pregunta"], 2) ?>
<?= anchor_enid(strong("SOBRE") . strtoupper($data_send["nombre_servicio"]),
    [
        "href" => get_url_servicio($data_send["id_servicio"]),
        "class" => 'a_enid_blue_sm'
    ]
    ,
    1
) ?>
<?= get_format_resumen_cliente($next, $nombre, $telefono) ?>
<div class="contenedor_preguntas">
    <div class="panel panel-primary">
        <?= div("Seguimiento", ["class" => "panel-heading"]) ?>
        <div class="panel-body">
            <div class="<?= mayorque(count($respuestas)  , 4 , " scroll_chat_enid " )  ?>">
                <ul class="chat">
                    <?php foreach ($respuestas as $row) {
                        $respuesta = $row["respuesta"];
                        $fecha_registro = $row["fecha_registro"];
                        $id_pregunta = $row["id_pregunta"];
                        $id_usuario = $row["id_usuario"];
                        $nombre = $row["nombre"];
                        $apellido_paterno = $row["apellido_paterno"];
                        ?>
                        <li class="left clearfix">
                            <?= span(
                                img([
                                    "src" => path_enid("imagen_usuario" , $id_usuario),
                                    "onerror" => "this.src='../img_tema/user/user.png'",
                                    "style" => "width: 40px!important;height: 32px!important;",
                                    "class" => "img-circle"
                                ]),
                                ["class" => "chat-img pull-left"]

                            ) ?>
                            <div class="chat-body clearfix">
                                <?= btw(
                                    strong($nombre . $apellido_paterno),
                                    small(icon("fa fa-clock") . $fecha_registro, "pull-right text-muted" ),
                                    "header"
                                ) ?>
                                <?= p($respuesta) ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?= get_form_valoracion_pregunta() ?>
    </div>
</div>
