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
		<?= div(get_forms($id_recibo, $lista_direcciones), ["class" => "col-md-3"]) ?>
		<?= div(get_format_listado_puntos_encuentro($puntos_encuentro, $id_recibo, $domicilio), ["class" => "col-md-3"]) ?>
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
<?= get_forms($id_recibo , $lista_direcciones) ?>
