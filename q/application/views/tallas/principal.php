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
$tipo_talla = heading_enid(
	$tipo,
	'2',
	['class' => 'info-tipo-talla']
);
?>
<div class="card">
	<div class="col-lg-9">
		<?= div(append_data([$tipo_talla, $msj_clasificaciones, $clasificaciones_existentes]), ["class" => "row agregadas"]) ?>
	</div>
	<div class="col-lg-3 ">
		<?= get_btw(
			heading_enid("CLASIFICACIONES", 3),
			get_form_clasificacion_talla(),
			"row sugerencias"
		) ?>
	</div>
</div>