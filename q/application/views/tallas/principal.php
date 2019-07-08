<?php
$id = 0;
$tipo = "";
foreach ($talla as $row) {
    $id = $row["id"];
    $tipo = $row["tipo"];
    $clasificacion = $row["clasificacion"];
}

$str = ($num_clasificaciones > 0) ? heading_enid(
    "CLASIFICACIONES AGREGADAS RECIENTEMENTE",
    5
    ,
    'titulo-tags-ingresos'
) : "";

?>
<?= div(
    append([

        heading_enid(
            $tipo,
            2,
            'info-tipo-talla'
        )
        , $str, $clasificaciones_existentes])
    ,
    "agregadas col-lg-9"
) ?>
<?= btw(
    heading_enid("CLASIFICACIONES", 3),
    get_form_clasificacion_talla(),
    " sugerencias col-lg-3"
) ?>
