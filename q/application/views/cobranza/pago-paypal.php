	<div>
		<?=span(
			"2.-" , 
			[	"class"		=> 	"white",
			"style"	=>	"background: black;padding: 4px;color: white;"]
		)?>
		<?=span("Podrás compra en línea de forma segura con tu con tu tarjeta bancaria (tarjeta de crédito o débito) a través de")?>
		<?=anchor_enid("PayPal" , ["href"=>$url_pago_paypal] )?>
		por Internet. 
	</div>
	<?=anchor_enid(img(["src" 	=> $url_request."img_tema/explicacion-pago-en-linea.png", "style" => "width: 100%"]) , ["href" => $url_pago_paypal] , 1)?>
	<?=anchor_enid( "Comprar ahora!", [ "href"=> $url_pago_paypal,  "style" => "background: blue;padding: 15px;color: white!important"] , 1)?>					 	
		
