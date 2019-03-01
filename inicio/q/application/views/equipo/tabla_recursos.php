<?php
$l = "<table>";
$b = 1;
foreach ($recursos as $row) {

	$nombre = $row["nombre"];
	$idperfil = $row["idperfil"];
	$url = $row["urlpaginaweb"];
	$id_recurso = $row["id_recurso"];

	$ver_sitio = anchor_enid("Ver sitio",
		[
			"href" => $url,
			"class" => 'blue_enid_background white ',
			"id" => $id_recurso,
			"target" => '_black'
		]);

	$l .= "<tr>";
	$l .= get_td($b . ".-");

	if ($idperfil > 0) {
		$l .=
			get_td(input(
				[
					"type" => 'checkbox',
					"class" => 'perfil_recurso',
					"id" => $id_recurso,
					"checked" => true
				]));
	} else {
		$l .= get_td(
			input([
					"type" => 'checkbox',
					"class" => 'perfil_recurso',
					"id" => $id_recurso]
			));
	}

	$l .= get_td($nombre);
	$l .= get_td($ver_sitio);
	$l .= "</tr>";
	$b++;
}
$l .= "</table>";
?>
<?= $l; ?>