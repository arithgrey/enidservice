<?php

$style = [];
$style_terminos = ["style" => 'background:#024d8d;color:white;'];
$style_solicitudes = ["style" => 'font-size:.8em;background:#ea330c;color:white;'];
$lista_fechas_text = get_td("Periodo", $style);
$lista_fechas_text .= get_td("Total", $style);
$lista_solicitudes = "";
$valor_solicitudes = "";
$lista_terminos = "";
$totales_solicitudes = 0;
$totales_realizadas = 0;
foreach ($info_global["lista_fechas"] as $row) {
	$fecha = $row["fecha"];
	$lista_fechas_text .= get_td($fecha, $style);
	$valor_solicitudes = get_valor_fecha_solicitudes($info_global["solicitudes"], $fecha);
	$totales_solicitudes = $totales_solicitudes + $valor_solicitudes;
	$lista_solicitudes .= get_td($valor_solicitudes, $style);
	$valor_terminos = tareas_realizadas($info_global["terminos"], $fecha);
	$totales_realizadas = $totales_realizadas + $valor_terminos;
	$lista_terminos .= get_td($valor_terminos, $style);
}
?>

<?= div("Atención al cliente/ tareas resueltas",
	["class" => "blue_enid_background white"],
	1) ?>
<?= br() ?>
<?= n_row_12() ?>
	<div style='overflow-x:auto;'>
		<table class='table_enid_service text-center' border="1" width="100%">
			<tr class='f-enid' style="background: #0022B7;color: white;">
				<?= $lista_fechas_text ?>
			</tr>
			<tr>
				<?= get_td("Solicitudes", $style_solicitudes); ?>
				<?= get_td($totales_solicitudes, $style_solicitudes) ?>
				<?= $lista_solicitudes ?>
			</tr>
			<tr>
				<?= get_td("Términos", $style_terminos) ?>
				<?= get_td($totales_realizadas, $style_terminos); ?>
				<?= $lista_terminos ?>
			</tr>
		</table>
	</div>
<?= end_row() ?>