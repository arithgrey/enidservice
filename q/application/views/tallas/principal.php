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
<?= div(append_data([

    heading_enid(
        $tipo,
        2,
        ['class' => 'info-tipo-talla']
    )
    , $msj_clasificaciones, $clasificaciones_existentes]), ["class" => "agregadas col-lg-9"]) ?>
<?= get_btw(
    heading_enid("CLASIFICACIONES", 3),
    get_form_clasificacion_talla(),
    " sugerencias col-lg-3"
) ?>
