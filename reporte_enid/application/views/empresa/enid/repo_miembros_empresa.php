<?php
$complete = "";
$lis_miembros = "";
$height = "style='overflow-x:auto;'";
if (count($miembros) >= 20) {
	$height = "style='overflow-x:auto; height: 300px;' ";
}
$b = 1;
foreach ($miembros as $row) {

	$idusuario = $row["idusuario"];
	$nombre = $row["nombre"];
	$email = $row["email"];
	$fecha_registro = $row["fecha_registro"];
	$puesto = $row["puesto"];
	$status = $row["status"];
	$apellido_paterno = $row["apellido_paterno"];
	$apellido_materno = $row["apellido_materno"];
	$email_alterno = $row["email_alterno"];
	$tel_contacto = $row["tel_contacto"];
	$tel_contacto_alterno = $row["tel_contacto_alterno"];
	$edad = $row["edad"];
	$cargo = $row["cargo"];
	$url_fb = $row["url_fb"];
	$url_tw = $row["url_tw"];
	$url_www = $row["url_www"];
	$sexo = $row["sexo"];


	$lis_miembros .= "<tr>";
	$lis_miembros .= td($idusuario);
	$lis_miembros .= td($nombre . " " . $apellido_paterno . " " . $apellido_materno);
	$lis_miembros .= td($email);
	$lis_miembros .= td($email_alterno);
	$lis_miembros .= td($tel_contacto);
	$lis_miembros .= td($tel_contacto_alterno);
	$lis_miembros .= td($fecha_registro);
	$lis_miembros .= td($puesto);
	$lis_miembros .= td($edad);
	$lis_miembros .= td($cargo);
	$lis_miembros .= td($url_fb);
	$lis_miembros .= td($url_tw);
	$lis_miembros .= td($url_www);
	$lis_miembros .= td($sexo);
	$lis_miembros .= td($status);
	$lis_miembros .= "</tr>";

}

?>
<?= d("# Miembros" . count($miembros), 'num_registros_encontrados' ) ?>
<div <?= $height ?> >
	<table class='table_enid_service' border=1>
		<tr class="table_enid_service_header">
			<?= td("#") ?>
			<?= td("Nombre") ?>
			<?= td("email") ?>
			<?= td("email_alterno") ?>
			<?= td("Tel.") ?>
			<?= td("Tel. 2") ?>
			<?= td("Fecha registro") ?>
			<?= td("Puesto") ?>
			<?= td("Edad") ?>
			<?= td("Cargo") ?>
			<?= td("Fb") ?>
			<?= td("Tw") ?>
			<?= td("www") ?>
			<?= td("Sexo") ?>
			<?= td("Estatus") ?>
		</tr>
		<?= $lis_miembros; ?>
	</table>
</div>