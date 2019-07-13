<?php
$respuestas = "";
foreach ($info_respuestas as $row) {

	$respuesta = $row["respuesta"];
	$fecha_registro = $row["fecha_registro"];
	$id_usuario = $row["id_usuario"];
	$id_tarea = $row["id_tarea"];
	$nombre = $row["nombre"];
	$apellido_paterno = $row["apellido_paterno"];
	$apellido_materno = $row["apellido_materno"];
	$usuario_respuesta = $nombre . " " . $apellido_paterno;
	$idperfil = $row["idperfil"];
	$text_perfil = ($idperfil != 20) ? "Equipo Enid Service" : "Cliente";


	$r = anchor_enid(img(["class" => 'media-object']), ["class" => 'pull-left']);
	$r .= small(icon('fa fa-clock-o') . $fecha_registro, ["class" => 'pull-right time']);
	$r .= d($usuario_respuesta . "  | " . $text_perfil, ["class" => 'media-heading']);
	$r .= d($respuesta);

	$respuestas .= d($r, ["class" => "contenedor_respuestas_tickect_tarea"]);
	$respuestas .= hr();

}

$oculta_comentarios = (count($info_respuestas) > 0) ? d("Ocultar ", ["class" => 'ocultar_comentarios strong blue_enid', "id" => $id_tarea]) : "";

?>
<?= btw(
	$oculta_comentarios,
	d(
		d($respuestas,  "msg-wrap" )
		,
		"Message-wrap"
	),
	12
) ?>


