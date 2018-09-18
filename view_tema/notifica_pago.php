<div class="col-lg-8 col-lg-offset-2">
	<?=div("¿ya realizaste tu pago?" )?>
	<?=anchor_enid("Dando click aquí." ,  
		["href"=>	$url_request."notificar/?recibo=" .$id_recibo])?>			
</div>
<hr>