<?= n_row_12() ?>
	<div class="col-lg-6 col-lg-offset-3">
		<?= addNRow(append_data([
			heading("FORMAS DE PAGO ENID SERVICE"),
			div("Podrás comprar con tu tarjeta bancaria (tarjeta de crédito o débito). ", 1),
			div("Aceptamos pagos con tarjetas de crédito y débito directamente para Visa, MasterCard y American Express a través de PayPal con los mismos tipos de tarjetas.", 1),
			div("Adicionalmente aceptamos pagos en tiendas de autoservicio (OXXO y 7Eleven) y transferencia bancaria en línea para los bancos BBVA Bancomer.", 1),
			div("El pago realizado en tiendas de autoservicio tendrá una comisión adicional al monto de la compra por transacción fijada por el proveedor y no es imputable a Enid Service.", 1)
		])) ?>
		<?= hr() ?>
        <?=get_img_pago()?>
	</div>
<?= end_row() ?>