<div>
	<?=span("1.- " , ["style"=>"background: black;padding: 5px;color: white;"])?>
	<?=span("Aceptamos pagos en tiendas de autoservicio ")?>
	<?=span("(OXXO) " , ["class" => "strong"])?>
	<?=span("y transferencia bancaria en línea para bancos  " )?>
	<?=span("BBVA Bancomer.  " , ["class" => "strong"])?>
</div>
<div>
	<?=anchor_enid(img(["src"=> $url_request."img_tema/pago-oxxo.jpeg"]) , ["href" => $url_pago_oxxo])?>
	<?=anchor_enid(icon('fa fa-print') . "Imprimir órden de pago" , ["href"=>$url_pago_oxxo,  "style"=>"background-color: #005780 !important; color: white!important;padding: 15px;"])?>
</div>
					 
