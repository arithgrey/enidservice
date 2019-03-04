<?= heading_enid("MENSAJES ENVIADOS A ENID SERVICE", 3) ?>

<?php
$l = "";
foreach ($contactos as $row) {

	$id_contacto = $row["id_contacto"];
	$nombre = $row["nombre"];
	$email = $row["email"];
	$mensaje = $row["mensaje"];
	$fecha_registro = $row["fecha_registro"];
	$telefono = $row["telefono"];
	$id_tipo_contacto = $row["id_tipo_contacto"];


	?>
	<div class="popup-box chat-popup" id="qnimate" style="margin-top: 4px;">
		<div class="popup-head">
			<div class="popup-head-left pull-left">
				<?= img([
					"src" => "../img_tema/user/user.png",
					"style" => 'width: 44px!important;',
					"onerror" => "../img_tema/user/user.png"
				]) ?>
				<?= div($nombre . "|" . $email) ?>
				<?= div($mensaje . $telefono . $fecha_registro) ?>
			</div>
		</div>
	</div>
	<?php
}
?>

<?= $l; ?>
