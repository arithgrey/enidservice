<?php

$fecha = "";
$fecha_registro = "";
$num_afiliados = "";

$lista_fecha = get_td("Periodo");
$lista_afiliados = get_td("Afiliados");
$lista_solicitudes = get_td("Solicitudes");
$lista_ventas = get_td("Ventas Efectivas");
$lista_accesos = get_td("Accesos");

foreach ($info_afiliaciones as $row) {

	$fecha = $row["fecha"];
	$fecha_registro = "";
	$num_afiliados = $row["num_afiliados"];
	$num_accesos = $row["num_accesos"];

	$lista_fecha .= get_td($fecha);
	$lista_afiliados .= get_td(valida_num($num_afiliados));
	$lista_solicitudes .= get_td(valida_valor_por_fecha($fecha, "solicitudes", $ventas));
	$lista_ventas .= get_td(valida_valor_por_fecha($fecha, "ventas_efectivas", $ventas));
	$lista_accesos .= get_td(valida_valor_por_fecha($fecha, "num_accesos", $accesos));

}
?>
<div style='overflow-x:auto;'>
	<table class="table_enid_service" border="1">
		<tr>
			<?= $lista_fecha ?>
		</tr>
		<tr class="text-center">
			<?= $lista_afiliados; ?>
		</tr>
		<tr class="text-center">
			<?= $lista_solicitudes; ?>
		</tr>
		<tr class="text-center">
			<?= $lista_ventas; ?>
		</tr>
		<tr class="text-center">
			<?= $lista_accesos ?>
		</tr>
	</table>
</div>