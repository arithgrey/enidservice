<?php if ($in_session < 1): ?>

	<div class="contenedor_eleccion_correo_electronico">
		<div class="col-lg-6 col-lg-offset-3">
			<?= heading_enid("¿Quién recibe?", 2, ["class" => "strong"]) ?>
			<div class="contendor_in_correo ">
				<form class="form-horizontal form_punto_encuentro">
					<?= label(" NOMBRE ", ["class" => "col-lg-2 "]) ?>
					<div class="col-lg-10">
						<?= input([
							"id" => "nombre",
							"name" => "nombre",
							"type" => "text",
							"placeholder" => "Persona que recibe",
							"class" => "form-control input-md nombre",
							"required" => true
						]) ?>
					</div>
					<?= label("CORREO ", ["class" => "col-lg-2 "]) ?>
					<div class="col-lg-10">
						<?= input([
							"id" => "correo",
							"name" => "email",
							"type" => "email",
							"placeholder" => "@",
							"class" => "form-control input-md correo",
							"required" => true
						]) ?>
					</div>
					<?= label(" TELÉFONO ", ["class" => "col-lg-2 "]) ?>
					<div class="col-lg-10">
						<?= input([
							"id" => "tel",
							"name" => "telefono",
							"type" => "tel",
							"class" => "form-control input-md  telefono",
							"required" => true
						]) ?>

					</div>
					<?= br(2) ?>

					<?= div(heading_enid("¿En qué horario te gustaría recibir tu pedido?",
						4,
						["class" => "strong pull-right"]), ["class" => "col-lg-12"]) ?>

					<?= label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-2 "]) ?>
					<div class="col-lg-8">
						<?= input(
							[
								"data-date-format" => "yyyy-mm-dd",
								"name" => 'fecha_entrega',
								"class" => "form-control input-sm ",
								"type" => 'date',
								"value" => date("Y-m-d"),
								"min" => date("Y-m-d"),
								"max" => add_date(date("Y-m-d"), 4)
							]) ?>
					</div>
					<?= label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO",
						["class" => "col-lg-4 "]
					) ?>
					<?= div(lista_horarios(), ["class" => "col-lg-8"]) ?>
					<?= div("+ agregar nota", ["class" => "col-lg-12 cursor_pointer text_agregar_nota", "onclick" => "agregar_nota();"]) ?>
					<div class="input_notas">
						<?= div("NOTAS", ["class" => "strong col-lg-12"]) ?>
						<?= textarea(["name" => "comentarios"], 1) ?>
					</div>
					<?= input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form"]) ?>
					<?= input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]) ?>
					<?= br() ?>
					<?= guardar("CONTINUAR", ["class" => "top_20"]) ?>
					<?php if ($in_session == 0): ?>
						<div class="contenedor_ya_tienes_cuenta">
							<?= br() ?>
							<?= heading_enid("YA TIENES UN USUARIO REGISTRADO", 2,
								["class" => "display_none text_usuario_registrado"]) ?>
							<?= heading_enid("¿Ya tienes una cuenta? ", 3,
								["class" => " text_usuario_registrado_pregunta"]) ?>

							<?= div("ACCEDE AHORA!", [
								"plan" => $servicio,
								"num_ciclos" => $num_ciclos,
								"class" => "link_acceso cursor_pointer"
							], 1) ?>;

						</div>
						<?= place("place_notificacion_punto_encuentro_registro") ?>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="col-lg-6 col-lg-offset-3">

		<?= get_form_punto_encuentro_horario([
			input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
			input_hidden(["class" => "servicio", "name" => "servicio", "value" => $servicio]),
			input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos])
		]) ?>

	</div>
<?php endif; ?>