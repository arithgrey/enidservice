<?php
$id = 0;
$tipo = "";
foreach ($talla as $row) {
    $id = $row["id"];
    $tipo = $row["tipo"];
    $clasificacion = $row["clasificacion"];
}

$msj_exists = heading_enid(
    "CLASIFICACIONES AGREGADAS RECIENTEMENTE",
    "5"
    ,
    ['class' => 'titulo-tags-ingresos']
);

$msj_clasificaciones = ($num_clasificaciones > 0) ? $msj_exists : "";

?>
<?= div(
    append([

    heading_enid(
        $tipo,
        2,
        'info-tipo-talla'
    )
    , $msj_clasificaciones, $clasificaciones_existentes])
    ,
    "agregadas col-lg-9"
) ?>
<?= btw(
    heading_enid("CLASIFICACIONES", 3),
    get_form_clasificacion_talla(),
    " sugerencias col-lg-3"
) ?>
