<?php

$list = "";
$franja_horaria = get_franja_horaria();

$style = "";
$lista = "";
for ($a = 0; $a < count($franja_horaria); $a++) {

	$lista .= "<tr>";
	$lista .= get_td($franja_horaria[$a], $style);
	$lista .= get_comparativas_metricas($franja_horaria[$a], $info_global);
	$lista .= "</tr>";
}

?>


<div class="col-lg-6 col-lg-offset-3">
	<?= div("Comparativa atención al cliente y tareas resueltas",
		["class" => "blue_enid_background white pading_10"]) ?>
	<table class='table_enid_service text-center' border="1">
		<tr class='f-enid' style="background: #0022B7;color: white;">
			<?= get_td("Franja horaria") ?>
			<?= get_td("Hace 7 días") ?>
			<?= get_td("Ayer") ?>
			<?= get_td("Hoy") ?>
		</tr>
		<?= $lista ?>
	</table>
</div>