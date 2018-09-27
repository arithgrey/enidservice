					<div>
						<?=span(
							"2.-" , 
							[	"class"		=> 	"white",
								 "style"	=>	"background: black;padding: 4px;color: white;"]
						)?>
						<?=span("Podrás compra en línea de forma segura
							con tu con tu tarjeta bancaria 
							(tarjeta de crédito o débito) a través de"
						)?>
						<?=anchor_enid("PayPal" , ["href"=>$url_pago_paypal] )?>
						por Internet. 
					 </div>
					<div>
					 	<a href="<?=$url_pago_paypal?>">
					 		<img src="<?=$url_request?>img_tema/explicacion-pago-en-linea.png" 
					 		style="width: 100%">
					 	</a>
					 	<div style="margin-top: 10px;">
						 	<a href="<?=$url_pago_paypal?>" style="background: blue;padding: 15px;color: white!important">
							 		Comprar ahora!
							 	</a>
						 	
					 	</div>
					</div>
		
