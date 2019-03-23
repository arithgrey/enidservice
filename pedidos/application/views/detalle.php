<?= br() ?>
<div class="col-lg-10 col-lg-offset-1">
	<div class="col-lg-8">
		<?= div(heading_enid("# ORDEN " . $orden, 2, ["class" => "strong"]), ["class" => "numero_orden encabezado_numero_orden"]) ?>

		<?= div(icon("fa fa-pencil"),
			[
				"class" => "text-right editar_estado",
				"id" => $orden
			]) ?>

		<?= div(crea_estado_venta($status_ventas, $recibo), 1) ?>
		<div class="selector_estados_ventas top_20 bottom_20">
			<?= div(strong("STATUS DE LA COMPRA")) ?>
			<?= create_select(
				$status_ventas,
				"status_venta",
				"status_venta form-control ",
				"status_venta",
				"text_vendedor",
				"id_estatus_enid_service",
				1,
				1,
				0,
				"-"
			) ?>
			<?= place("place_tipificaciones") ?>

			<div class="form_cantidad_post_venta top_20">
				<?= div(strong("SALDO CUBIERTO"), 1) ?>
				<?= div(input(
					[
						"class" => "form-control saldo_cubierto_pos_venta",
						"id" => "saldo_cubierto_pos_venta",
						"type" => "number",
						"step" => "any",
						"required" => "true",
						"name" => "saldo_cubierto",
						"value" => $recibo[0]["saldo_cubierto"]

					]),
					["class" => "col-lg-10"]) ?>
				<?= div("MXN", ["class" => "mxn col-lg-2"]) ?>
			</div>
			<?= place("mensaje_saldo_cubierto_post_venta") ?>
			<?= get_form_cantidad($recibo, $orden) ?>
		</div>
		<?= div("REGISTRO " . $recibo[0]["fecha_registro"], ["class" => "fecha_registro"], 1) ?>
		<?= div(crea_fecha_entrega($recibo)) ?>
		<?= crea_seccion_productos($recibo) ?>
		<?= br(2) ?>
		<?= create_fecha_contra_entrega($recibo, $domicilio) ?>
		<?= notificacion_por_cambio_fecha($recibo, $num_compras, $recibo[0]["saldo_cubierto"]); ?>
		<?= br() ?>
		<?= addNRow(crea_seccion_recordatorios($recordatorios, $tipo_recortario)) ?>
		<?= br() ?>
		<?= addNRow(create_seccion_tipificaciones($tipificaciones)) ?>
		<?= br() ?>
		<?= addNRow(get_form_nota($id_recibo)) ?>
		<?= br() ?>
		<?= addNRow(create_seccion_comentarios($comentarios, $id_recibo)) ?>
	</div>
	<div class="col-lg-4">
	<?=get_format_resumen_cliente_compra($recibo, $tipos_entregas,$domicilio,$num_compras,$usuario,$id_recibo)?>
	</div>

</div>
<?= get_hiddens_detalle($recibo) ?>
