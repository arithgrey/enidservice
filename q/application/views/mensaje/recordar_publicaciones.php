<?php

$r[] = div("Hemos tenido pocas noticias sobre ti!, ");
$r[] = div("Excelente día " . $nombre . "-" . $email . " hemos tenido pocas noticias sobre ti, ahora hay más personas que están vendiendo y comprando sus productos a través de Enid Service, la plataforma de comercio electrónico de México, apresurate y anuncia tus artículos y servicios para llegas a más personas que están en busca de lo que ofreces! ");
$r[] = anchor_enid("Puedes acceder a su cuenta Enid Service aquí!",
    [
        "href" => "http://enidservice.com/inicio/login",
        "style" => "background: blue;color: white;padding: 5px;"
    ]);

$r[] = anchor_enid(img([
    "src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
    "width" => "300px"
]),
    [
        "href" => "http://enidservice.com/"
    ]);
$r[] = hr();

$r[] = anchor_enid(
    "YA NO QUIERO RECIBIR ESTE CORREO",
    [
        'href' => $url_cancelar_envio,
        'style' => 'color:black;font-size:.9em;font-weight:bold'
    ]);


?>
<?= append_data($r) ?>