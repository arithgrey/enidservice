<?php

$recibo = $recibo[0];
$id_recibo = $recibo["id_proyecto_persona_forma_pago"];
$id_servicio = $recibo["id_servicio"];
$num_ciclos = $recibo["num_ciclos_contratados"];
$id_error = "imagen_" . $id_servicio;


?>
<?= br() ?>
<div class="container-fluid ">
	<div class="row">
		<div class="col-md-3">
			<?= br() ?>
			<?= div("DOMICILIOS DE ENTREGA ", ["class" => "text_direcciones_registradas"]) ?>
			<?= agregar_nueva_direccion(0); ?>
				<?= ul(create_lista_direcciones($lista_direcciones, $id_recibo), ["class" => "list-group list-group-flush"]) ?>
			<?= br(2) ?>
		</div>
		<div class="col-md-3">
			<?= br() ?>
			<?= div("TUS PUNTOS DE ENCUENTRO ", ["class" => "text_puntos_registrados"]) ?>
			<?= agregar_nueva_direccion(1); ?>
			<?= ul([get_lista_puntos_encuentro($puntos_encuentro, $id_recibo, $domicilio)]) ?>
			<?= br(2) ?>
		</div>
		<div class="col-md-6 gedf-main">
			<?= br() ?>
			<div class="d-flex justify-content-between align-items-center">
				<div class="d-flex justify-content-between align-items-center">
					<?= div(img(
						[
							"src" => link_imagen_servicio($id_servicio),
							"class" => "rounded-circle",
							"id" => $id_error,
							"onerror" => "reloload_img( '" . $id_error . "','" . link_imagen_servicio($id_servicio) . "');",
							"style" => "width:100px!important;height:100px!important;"

						]),
						["class" => "mr-2"]) ?>
					<?= div(heading_enid(
						"ORDEN #" . $recibo["id_proyecto_persona_forma_pago"],
						5,
						["class" => "h5 m-0"]
					),
						["class" => "ml-2"]
					) ?>
				</div>
			</div>

			<?= create_descripcion_direccion_entrega($domicilio) ?>
			<?= valida_accion_pago($recibo) ?>
		</div>
	</div>
</div>
<?= get_form_registro_direccion($id_recibo); ?>
<?= get_form_puntos_medios($id_recibo); ?>
<?= get_form_puntos_medios_avanzado($id_recibo); ?>
