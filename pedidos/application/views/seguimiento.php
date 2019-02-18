<div class="col-lg-8">
	<div class="page-section ">
	  <div class="wrapper">
	  	<?=heading_enid("RASTREAR PAQUETE " .icon("fa fa-map-signs") ,  3)?>    	  	
        <?=div(create_linea_tiempo($recibo , $domicilio), ["class"=>"timeline"])?>
	  </div>
	</div>	
</div>
<div class="col-lg-4">
	<div class="page-section ">
        <?=heading("ORDEN #".$recibo[0]["id_proyecto_persona_forma_pago"])?>
        <?=img(["src" => link_imagen_servicio($recibo[0]["id_servicio"])])?>
	</div>
</div>
<?=input_hidden(["value" => $notificacion_pago  ,  "class" => "notificacion_pago"])?>
<?=input_hidden(["value" => $orden  ,  "class" => "orden"])?>