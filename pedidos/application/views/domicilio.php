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
			<?= get_format_listado_puntos_encuentro($puntos_encuentro, $id_recibo, $domicilio) ?>
		</div>
		<div class="col-md-6 gedf-main">
			<?= br() ?>
			<div class="d-flex justify-content-between align-items-center">
				<div class="d-flex justify-content-between align-items-center">
					<?= get_format_pre_orden($id_servicio, $id_error, $recibo) ?>
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
