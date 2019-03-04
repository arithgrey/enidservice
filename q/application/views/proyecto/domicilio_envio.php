<?php

$id_recibo = $param["id_recibo"];
$id_codigo_postal = 0;
$direccion = "";
$calle = "";
$entre_calles = "";
$numero_exterior = "";
$numero_interior = "";
$cp = "";
$asentamiento = "";
$direccion_envio = "";
$municipio = "";
$estado = "";
$flag_existe_direccion_previa = 0;
$pais = "";
$direccion_visible = "style='display:none;'";
$nombre_receptor = "";
$telefono_receptor = "";
foreach ($info_envio_direccion as $row) {

	$direccion = $row["direccion"];
	$calle = $row["calle"];
	$entre_calles = $row["entre_calles"];
	$numero_exterior = $row["numero_exterior"];
	$numero_interior = $row["numero_interior"];
	$cp = $row["cp"];
	$asentamiento = $row["asentamiento"];
	$municipio = $row["municipio"];
	$estado = $row["estado"];
	$flag_existe_direccion_previa++;
	$direccion_visible = "";
	$id_codigo_postal = $row["id_codigo_postal"];
	$pais = "";
	$nombre_receptor = $row["nombre_receptor"];
	$telefono_receptor = $row["telefono_receptor"];
}


if ($registro_direccion == 0) {

	$nombre = get_campo($info_usuario, "nombre");
	$apellido_paterno = get_campo($info_usuario, "apellido_paterno");
	$apellido_materno = get_campo($info_usuario, "apellido_materno");
	$nombre_receptor = $nombre . " " . $apellido_paterno . " " . $apellido_materno;
	$telefono_receptor = get_campo($info_usuario, "tel_contacto");
}
?>

<div class='contenedor_informacion_envio'>
	<?= heading_enid("DIRECCIÓN DE ENVÍO", 2) ?>
	<div id='modificar_direccion_seccion' class="contenedor_form_envio">
		<?= hr() ?>
		<form class="form-horizontal form_direccion_envio">

			<div class="row">
				<div class="col-lg-6">
					<?= div("Persona que recibe", ["class" => "titulo_enid_sm_sm"]) ?>
					<?= input([
						"maxlength" => "80",
						"name" => "nombre_receptor",
						"value" => $nombre_receptor,
						"placeholder" => "* Tu o quien más pueda recibir tu ,pedido",
						"required" => "required",
						"class" => "nombre_receptor",
						"id" => "nombre_receptor",
						"type" => "text"
					]) ?>

				</div>

				<div class="col-lg-6">
					<?= div("Teléfono", ["class" => "titulo_enid_sm_sm"]) ?>
					<?= input([
						"maxlength" => "12",
						"name" => "telefono_receptor",
						"value" => $telefono_receptor,
						"placeholder" => "* Algún número telefónico ",
						"required" => "required",
						"class" => "telefono_receptor",
						"id" => "telefono_receptor",
						"type" => "text"
					]) ?>
				</div>
			</div>
			<?= div("Código postal", ["class" => "titulo_enid_sm_sm"]) ?>
			<?= input([
				"maxlength" => "5",
				"name" => "cp",
				"value" => $cp,
				"placeholder" => "* Código postal",
				"required" => "required",
				"class" => "codigo_postal",
				"id" => "codigo_postal",
				"type" => "text"
			]) ?>
			<?= place('place_codigo_postal') ?>
			<?= input_hidden(["name" => "id_usuario", "value" => $id_usuario]) ?>

			<?= div("Calle", ["class" => "titulo_enid_sm_sm"]) ?>
			<?= input([
				"class" => "textinput address1",
				"name" => "calle",
				"value" => $calle,
				"placeholder" => "* Calle",
				"required" => "required",
				"autocorrect" => "off",
				"type" => "text"
			]) ?>

			<?= div("Entre la calle y la calle, o información adicional",
				["class" => "titulo_enid_sm_sm"]) ?>
			<?= input([
				"required" => true,
				"class" => "textinput address3 ",
				"name" => "referencia",
				"value" => $entre_calles,
				"placeholder" => "true",
				"Entre la calle y la calle, o información adicional",
				"type" => "text"
			]) ?>
			<div class="row">

				<?= get_btw(
					div("Número Exterior", ["class" => "titulo_enid_sm_sm"]),
					input([
						"class" => "required numero_exterior",
						"name" => "numero_exterior",
						"value" => $numero_exterior,
						"maxlength" => "8",
						"placeholder" => "* Número Exterior",
						"required" => "true",
						"type" => "text"
					]),
					"col-lg-6"
				) ?>



				<?= get_btw(

					div("Número Interior", ["class" => "titulo_enid_sm_sm"]),
					input([
						"class" => "numero_interior",
						"name" => "numero_interior",
						"value" => $numero_interior,
						"maxlength" => "10",
						"autocorrect" => "off",
						"type" => "text",
						"required " => "true"
					]),
					"col-lg-6"


				) ?>
			</div>


			<div <?= $direccion_visible ?> class="parte_colonia_delegacion">

				<?= div("Colonia", ["class" => "titulo_enid_sm_sm"]) ?>

				<?= div(input([
						"type" => "text",
						"name" => "colonia",
						"value" => $asentamiento,
						"readonly" => true
					]

				), ["class" => "place_colonias_info"]) ?>

				<?= place('place_asentamiento') ?>

				<?= get_btw(

					div("Delegación o Municipio", ["class" => "titulo_enid_sm_sm"]),
					div(input([
						"type" => "text",
						"name" => "delegacion",
						"value" => $municipio,
						"readonly" => true
					]), ["class" => "place_delegaciones_info"]),
					" district delegacion_c"
				) ?>



				<?= get_btw(
					div("Estado", ["class" => "titulo_enid_sm_sm"]),
					div(input([
						"type" => "text",
						"name" => "estado",
						"value" => $estado,
						"readonly" => "true"
					]), ["class" => "place_estado_info"]),
					"district  estado_c"
				)
				?>

				<?= get_btw(
					div("País", ["class" => "titulo_enid_sm_sm"]),
					place("place_pais_info"),
					" district pais_c"

				) ?>

				<div class="direccion_principal_c">
					<?= div("Esta es mi dirección principal ",
						["class" => "titulo_enid_sm_sm"]) ?>
					
					<select name='direccion_principal'>
						<option value="1">SI</option>
						<option value="0">NO</option>
					</select>
				</div>
				<?= input_hidden([
					"name" => "id_recibo",
					"value" => $id_recibo,
					"class" => "id_recibo"
				]) ?>

				<?= div(
					guardar("Registrar dirección ",
						['class' => "text_btn_direccion_envio"]),
					["class" => "button_c"]
				) ?>
				<?= place("notificacion_direccion") ?>
			</div>
		</form>
	</div>
</div>