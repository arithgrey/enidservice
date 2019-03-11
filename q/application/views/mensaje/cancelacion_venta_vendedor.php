<?php

$text = "Buen día " . strtoupper($info["usuario_notificado"][0]["nombre"]) . " - " . strtoupper($info["usuario_notificado"][0]["email"]) . " un placer";
$r[] = div($text, ["style" => "margin-top: 20px;text-decoration: underline;"]);
$r[] = div("Equipo Enid Service.");
$r[] = div("Nos encanta que emplees Enid Service para comprar y vender productos y servicios en Internet, te informamos que de momento una de tus compras ha sido cancelada por el vendedor, ");
$r[] = strong("pero mantén la calma!");
$r[] = div(", tu saldo se encuentra seguro en tu cuenta de Enid service, ya sea que desees emplear este para comprar otros artículos o retirar el mismo de tu cuenta puedes hacerlo accediendo aquí.");
$r[] = div("Si tienes alguna duda o algún comentario con gusto estamos para escucharte puedes contactarnos a través de alguno de los siguientes medios que se indican aquí!");
$r[] = div("Si quisieras calificar al vendedor o agregar algún comentario respecto a tu experiencia en esta compra ");
$r[] = anchor_enid("puedes hacerlo aquí.",
    [
        "style" => "background: blue;color: white;padding: 5px;",
        "href" => "http://enidservice.com/inicio/valoracion/?servicio=" . $info["id_recibo"]
    ]);
$r[] = div("Estamos en contacto y no dudes en contactarnos para este u otro tema relacionado!");
$r[] = anchor_enid(img([
    "src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
    "width" => "300px"
]),
    [
        "href" => "http://enidservice.com/"
    ]);

?>
<?= append_data($r) ?>
