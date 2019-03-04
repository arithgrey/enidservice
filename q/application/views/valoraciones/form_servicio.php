<?php

$propietario = ($extra["id_usuario"] == $servicio[0]["id_usuario"]) ? 1 : 0;
$nombre = "";
$email = "";

if ($extra["in_session"] == 1) {
	$nombre = $extra["nombre"];
	$email = $extra["email"];
}
$calificacion = ["", "Insuficiente", "Aceptable", "Promedio", "Bueno", "Excelente"];
?>
<div class="col-lg-6 col-lg-offset-3">
	<div>
		<center>
			<?= heading_enid("ESCRIBE UNA RESEÑA", 3, ["class" => "3em"]) ?>
			<?= div("Sobre  " . $servicio[0]["nombre_servicio"], ["style" => "font-size: 1.4em"]) ?>
		</center>

		<?= form_open("", ["class" => "form_valoracion"]) ?>
		<?= place("nuevo") ?>
		<table style='width:100%'>
			<tr>
				<?= get_td(strong("Valoración*", ["class" => "text-valoracion"])) ?>
				<td>
					<?= get_posibles_calificaciones($calificacion) ?>
				</td>
			</tr>
		</table>


		<?= place("nuevo") ?>

		<table style='width:100%'>
			<tr>
				<?= get_td(
					strong("¿Recomendarías este producto?*",
						["class" => "text-valoracion"])
				) ?>
				<td>
					<table style='width:100%'>
						<tr>
							<?= get_td(anchor_enid("SI", ["class" => 'recomendaria', "id" => 1])) ?>
							<?= get_td(anchor_enid("NO", ["class" => 'recomendaria', "id" => 0])) ?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?= place("place_recomendaria") ?>


		<?= place("nuevo") ?>

		<table style='width:100%'>
			<tr>
				<?= get_td("Tu opinión en una frase*",
					["class" => "text-valoracion strong"]) ?>

				<?= get_td(input([
					"type" => "text",
					"name" => "titulo",
					"class" => "input-sm input",
					"placeholder" => "Por ejemplo: Me encantó!",
					"required" => "Agrega una breve descripción"
				])) ?>
				<?= input_hidden([
					"name" => "propietario",
					"class" => "propietario",
					"value" => $propietario
				]) ?>
			</tr>
		</table>

		<?= place("nuevo") ?>

		<table style='width:100%'>
			<tr>
				<?= get_td(strong("Tu reseña*", ["class" => "text-valoracion"])) ?>
				<?= get_td(input([
					"type" => "text",
					"name" => "comentario",
					"placeholder" => "¿Por qué te gusta el producto o por qué no?",
					"required" => "Comenta tu experiencia"
				])) ?>
			</tr>
		</table>

		<?= place("nuevo") ?>


		<table style='width:100%'>
			<tr>
				<?= get_td(strong("Nombre*", ["class" => "text-valoracion"])) ?>
				<td>

					<input
							type="text"
							name="nombre"
							placeholder="Por ejemplo: Jonathan"
							value="<?= $nombre ?>"
						<?= valida_readonly($nombre) ?>
							required>
					<?= input_hidden(["name" => "id_servicio", "value" => $id_servicio]) ?>

				</td>
			</tr>

		</table>

		<?= place("nuevo") ?>

		<table style='width:100%'>
			<tr>
				<?= get_td(strong("Tu correo electrónico*", ["class" => "text-valoracion"])) ?>
				<td>
					<input
							type="email"
							name="email"
							placeholder="Por ejemplo: jmedrano@enidservice.com"
							required
						<?= valida_readonly($email) ?>
							value="<?= $email ?>">
				</td>
			</tr>

		</table>
		<?= place("nuevo") ?>
		<?= guardar("ENVIAR RESEÑA" . icon('fa fa-chevron-right ir')) ?>
		<?= place("place_registro_valoracion") ?>
		<?= form_close() ?>
	</div>
</div>


