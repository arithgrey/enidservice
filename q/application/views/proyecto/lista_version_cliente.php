<?= get_text_modalidad_compra($modalidad, $ordenes) ?>
<?= get_numero_articulos_en_venta_usuario($modalidad, $numero_articulos_en_venta) ?>
<?= get_mensaje_compra($modalidad, $ordenes) ?>
<?= evalua_texto_envios_compras($modalidad, count($ordenes), $status) ?>



<?php

if (is_array($ordenes)) {
	foreach ($ordenes as $row) {

		$id_recibo = $row["id_proyecto_persona_forma_pago"];
		$resumen_pedido = ($row["resumen_pedido"] !== null) ? $row["resumen_pedido"] : "";
		$id_servicio = $row["id_servicio"];
		$estado = $row["status"];
		$monto_a_pagar = $row["monto_a_pagar"];
		$costo_envio_cliente = $row["costo_envio_cliente"];
		$saldo_cubierto = $row["saldo_cubierto"];
		$direccion_registrada = $row["direccion_registrada"];
		$num_ciclos_contratados = $row["num_ciclos_contratados"];
		$estado_envio = $row["estado_envio"];
		$url_servicio = "../producto/?producto=" . $id_servicio;
		$monto_a_liquidar = monto_pendiente_cliente(
			$monto_a_pagar,
			$saldo_cubierto,
			$costo_envio_cliente,
			$num_ciclos_contratados
		);

		$url_imagen_servicio = "../imgs/index.php/enid/imagen_servicio/" . $id_servicio;
		$url_imagen_error = '../img_tema/portafolio/producto.png';
		$lista_info_attr = " info_proyecto= '" . $resumen_pedido . "'  info_status =  '" . $estado . "' ";

		$id_error = "imagen_" . $id_servicio;
		?>
		<?= n_row_12() ?>
		<div class="contenedor_articulo">

			<?= div(
				anchor_enid(
					img([
						"src" => $url_imagen_servicio,
						"onerror" => "reloload_img( '" . $id_error . "','" . $url_imagen_servicio . "');",
						"class" => 'imagen_articulo',
						"id" => $id_error
					]),
					["href" => $url_servicio]
				),
				["class" => "col-lg-3"]
			) ?>

			<?= div(div(
					div(carga_estado_compra($monto_a_liquidar, $id_recibo, $estado, $status_enid_service, $modalidad), ["class" => "btn_estado_cuenta"]
					),
					["class" => "contenedor_articulo_text"]
				)
				, ["class" => "col-lg-9"]
			) ?>
		
		
		</div>
		<?= end_row() ?>

	<?php }
} ?>
<?= evalua_acciones_modalidad($en_proceso, $modalidad) ?>
<?= evalua_acciones_modalidad_anteriores($anteriores, $modalidad) ?>
<?= place("contenedor_ventas_compras_anteriores") ?>
