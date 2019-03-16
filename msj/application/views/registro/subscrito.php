<?php

$q = $info["q"];
$nombre = $q["nombre"];
$email = $q["email"];
$password_legible = $q["password_legible"];
$telefono = $q["telefono"];

?>
    <div class="jumbotron"
         style="padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;">
        <?= get_format_notificacion_subscrito($nombre) ?>
    </div>

    <table>
        <tr>
            <?= get_td("Info", ["colspan" => "2"]) ?>
        </tr>
        <tr>
            <?= get_td("Usuario") ?>
            <?= get_td("Información de acceso") ?>
        </tr>
        <tr>
            <?= get_td($email) ?>
            <?= get_td($password_legibleemail) ?>
        </tr>
    </table>


<?= div(img([
    "src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
    "style" => "width: 100%"
]),
    [
        "style" => "width: 30%;margin: 0 auto;"
    ]) ?>