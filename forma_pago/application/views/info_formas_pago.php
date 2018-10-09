<?=n_row_12()?>
	<div class="col-lg-6 col-lg-offset-3">	
		<?=n_row_12()?>			
			<?=heading("FORMAS DE PAGO ENID SERVICE")?>							
			<?=div("Podrás comprar con tu tarjeta bancaria (tarjeta de crédito o débito). " , 1)?>
			<?=div("Aceptamos pagos con tarjetas de crédito y débito directamente para Visa, MasterCard y American Express a través de PayPal con los mismos tipos de tarjetas.", [] , 1)?>
			<?=div("Adicionalmente aceptamos pagos en tiendas de autoservicio 
					(OXXO y 7Eleven) y transferencia bancaria en línea para los bancos BBVA Bancomer." , 
					[],1)?>
			<?=div("El pago realizado en tiendas de autoservicio tendrá una comisión adicional al monto de la compra por transacción fijada por el proveedor y no es imputable a Enid Service.",1)?>
		<?=end_row()?>
		<hr>
		<?=n_row_12()?>		
			
				<table style="width: 100%;">
					<tr>
						<?=get_td(
							img(
								[
									'class' => "img_pago",
									'src' => "../img_tema/bancos/targetas-de-credito.jpg" 
								]

							))?>
						
						<?=get_td(
							img(
								[
									'class' => "img_pago",
							 		'src' => "../img_tema/bancos/paypal.png"
							 	]
							))?>	
						<?=get_td(
							img(
								[
									'class' => "img_pago",
									'src' => "../img_tema/bancos/1.png"
								]
							))?>		
											
						<?=get_td(
							img(
								[
								'class' => "img_pago",
								'src' => 
								"../img_tema/bancos/3.png" 
								]
							))?>

						<?=get_td(
							img(
								[
								'class' => "img_pago",
								'src' => 
								"../img_tema/bancos/8.png" 
								]
							))?>		
			

						<?=get_td(
							img([
								'class' => "img_pago",
								'src' => 
								"../img_tema/bancos/oxxo-logo.png" 
								]
							))?>		
					</tr>
				</table>			
		<?=end_row()?>
	</div>
<?=end_row()?>