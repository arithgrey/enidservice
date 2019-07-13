<?= h("SERVICIOS POSTULADOS", 3) ?>
<?php
$l = "";
$url_imagen = "";
foreach ($servicios as $row) {

    $nombre_servicio = $row["nombre_servicio"];
    $fecha_registro = $row["fecha_registro"];
    $id_servicio = $row["id_servicio"];
    $url_imagen = "../imgs/index.php/enid/imagen_servicio/" . $id_servicio;
    $precio = $row["precio"];
    $vista = $row["vista"];
    $id_error = "imagen_" . $id_servicio;

    $r = [];
    $r[] = img([
        "src" => $url_imagen,
        "style" => 'width: 44px!important;height: 44px;',
    ]);
    $r[] = d("alcance" . $vista);

    ?>

    <a href="../producto/?producto=<?= $id_servicio ?>" class='contenedor_resumen_servicio'>
        <div class="popup-box chat-popup" id="qnimate" style="margin-top: 4px;">
            <?= d(d(append($r),  "popup-head-left pull-left"),  "popup-head") ?>
        </div>
    </a>
<?php } ?>
<?= $l; ?>