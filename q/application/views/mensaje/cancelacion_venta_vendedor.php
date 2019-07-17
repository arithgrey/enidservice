<?php

$text = "Buen día " . strtoupper($info["usuario_notificado"][0]["nombre"]) . " - " . strtoupper($info["usuario_notificado"][0]["email"]) . " un placer";
$r[] = d($text, ["style" => "margin-top: 20px;text-decoration: underline;"]);
$r[] = d("Equipo Enid Service.");
$r[] = d("Nos encanta que emplees Enid Service para comprar y vender productos y servicios en Internet, te informamos que de momento una de tus compras ha sido cancelada por el vendedor, ");
$r[] = strong("pero mantén la calma!");
$r[] = d(", tu saldo se encuentra seguro en tu cuenta de Enid service, ya sea que desees emplear este para comprar otros artículos o retirar el mismo de tu cuenta puedes hacerlo accediendo aquí.");
$r[] = d("Si tienes alguna duda o algún comentario con gusto estamos para escucharte puedes contactarnos a través de alguno de los siguientes medios que se indican aquí!");
$r[] = d("Si quisieras calificar al vendedor o agregar algún comentario respecto a tu experiencia en esta compra ");
$r[] = a_enid("puedes hacerlo aquí.",
    [
        "style" => "background: blue;color: white;padding: 5px;",
        "href" => "http://enidservice.com/inicio/valoracion/?servicio=" . $info["id_recibo"]
    ]);
$r[] = d("Estamos en contacto y no dudes en contactarnos para este u otro tema relacionado!");
$r[] = a_enid(img([
    "src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
    "width" => "300px"
]),
    [
        "href" => "http://enidservice.com/"
    ]);

?>
<?= append($r) ?>
