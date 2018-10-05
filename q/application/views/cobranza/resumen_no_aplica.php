<?php 	

	$costo_envio_cliente_sistema 	=  $costo_envio_sistema["costo_envio_cliente"];
	$recibo 						=  $recibo[0];  
	$id_forma_pago  				=  $recibo["id_forma_pago"];
	$saldo_cubierto  				=  $recibo["saldo_cubierto"];
	$fecha_registro  				=  $recibo["fecha_registro"];
	$status  						=  $recibo["status"];
	$fecha_vencimiento  			=  $recibo["fecha_vencimiento"];
	$monto_a_pagar  				=  $recibo["monto_a_pagar"];
	$id_proyecto_persona_forma_pago =  $recibo["id_proyecto_persona_forma_pago"];
	$id_recibo 						=  $id_proyecto_persona_forma_pago; 
	$num_email_recordatorio  		=  $recibo["num_email_recordatorio"];
	$id_usuario_referencia  		=  $recibo["id_usuario_referencia"];
	$flag_pago_comision  			=  $recibo["flag_pago_comision"];
	$flag_envio_gratis  			=  $recibo["flag_envio_gratis"];
	$costo_envio_cliente  			=  $recibo["costo_envio_cliente"];
	$id_usuario_venta  				=  $recibo["id_usuario_venta"];
	$id_ciclo_facturacion  			=  $recibo["id_ciclo_facturacion"];
	$num_ciclos_contratados  		=  $recibo["num_ciclos_contratados"];
	$id_usuario  					=  $recibo["id_usuario"];
	$precio  						=  $recibo["precio"];
	$costo_envio_vendedor  			=  $recibo["costo_envio_vendedor"];
	$id_servicio  					=  $recibo["id_servicio"];
	$resumen_pedido  				=  $recibo["resumen_pedido"];	
	
	/*Información del usuario*/
	$usuario 						=  $usuario[0];
	$id_usuario 					=  $usuario["id_usuario"]; 
	$nombre 						=  $usuario["nombre"]; 
	$apellido_paterno 				=  $usuario["apellido_paterno"]; 
	$apellido_materno				=  $usuario["apellido_materno"]; 
	$email 							=  $usuario["email"]; 
	$url_request 					=  $url_request;
	$cliente 						= $nombre." ". $apellido_paterno ." " .$apellido_materno;		
	

	if($costo_envio_cliente_sistema > $costo_envio_vendedor) {
		$costo_envio_cliente =  $costo_envio_cliente_sistema;	
	}
	/*Data extra para oxxo*/
	$saldo_pendiente =  ($monto_a_pagar * $num_ciclos_contratados )- $saldo_cubierto;	
	

	$servicio 					= 	$servicio[0];
	$flag_servicio 				=  	$servicio["flag_servicio"];
	$text_envio_cliente_sistema = 	"";
	if($flag_servicio == 0 ){
		$saldo_pendiente 			=  $saldo_pendiente + $costo_envio_cliente;		
		$text_envio_cliente_sistema =  $costo_envio_sistema["text_envio"]["cliente"];
	}
	

	$url_pago_oxxo =
	$url_request ."orden_pago_oxxo/?q=".$saldo_pendiente."&q2=".$id_recibo."&q3=".$id_usuario;
	$data_oxxo["url_pago_oxxo"] =  	$url_pago_oxxo;
	$data_oxxo["id_usuario"] 	= 	$id_usuario;
	/*Data para notificar el pago*/
	$data_notificacion["id_recibo"] =  $id_recibo;

			
	$flag_servicio 				=  	$servicio["flag_servicio"];
	$nombre_servicio 			=  	$servicio["nombre_servicio"];	
	$proyecto 					=  	$servicio;		
	$detalles 					=  	$resumen_pedido;	
	$ciclo_de_facturacion 		=  	$id_ciclo_facturacion;  	
	$saldo_cubierto 			=  	$saldo_cubierto;
	$monto_a_pagar 				=  	$monto_a_pagar;
	$primer_registro 			=  	$fecha_registro;	
	$estado_text 				=  	($saldo_cubierto < $monto_a_pagar ) ? "Pendiente": "";		
	$data["saldo_pendiente"] 	=  	$saldo_pendiente;
	$url_pago_paypal 			=	"https://www.paypal.me/eniservice/".$saldo_pendiente;
	$data["url_pago_paypal"] 	= 	$url_pago_paypal;
	$data["recibo"] =$recibo;
	
	$data_extra["cliente"] 		=  	$cliente;
	$url_logo 					= 	$url_request."img_tema/enid_service_logo.jpg";
	$config_log					=   ['src' => $url_logo  ,'width'	=> '100'];
	$url_cancelacion 			= 	$url_request."msj/index.php/api/emp/salir/format/json/?type=2&id=".$id_proyecto_persona_forma_pago;


?>
	<div style="margin: 0 auto;width: 76%;">
		<?=$this->load->view("cobranza/saludo_inicial" , $data_extra)?>		
		<center>
			<?=div(img($config_log) , [ "style"=> "width: 200px;"] )?>			
		</center>
		<?=heading_enid("#Recibo: " .$id_recibo;)?>

		<div style="background: #fcfcfc;padding: 5px;">
			<?=div("Concepto")?>
			<?=div($resumen_pedido)?>
			<?=div(valida_texto_periodos_contratados($num_ciclos_contratados, $flag_servicio , $id_ciclo_facturacion))?>
			<?=div("Precio $" . $monto_a_pagar)?>
			<?=div($text_envio_cliente_sistema)?>
			<?=div(
				icon('fa fa-check-circle-o'). 
				" Ordén de compra ".$primer_registro."| Límite de pago ".$fecha_vencimiento)?>
			
			<div style="border-style: solid;text-align: right;">
				<?=strong("Monto total pendiente ")?>
	          	<?=span($saldo_pendiente . "Pesos Mexicanos", 
	          	["style"=>"background: green; color:white;padding: 3px;"])?>
	          	
	        </div>
		</div>	      
		<hr>		
		<?=heading_enid("Formas de pago Enid Service" , 2 , ["class" => "top_10"])?>					
		<hr>
		
		<?=div(strong("** NINGÚN CARGO A TARJETA ES AUTOMÁTICO. 
			SÓLO PUEDE SER PAGADO POR ACCIÓN DEL USUARIO **	"), 
			["style" => "background: black; color: white;padding: 5px;"])?>			
			
		<div>
			<?=$this->load->view("cobranza/pago_oxxo" , $data_oxxo)?> 			
		</div>
		<hr>
		<div>
			<?=$this->load->view("cobranza/pago-paypal" , $data)?> 	
		</div>

		
		<div style="background: #001a30!important;padding: 5px;">
			<?=div("¿Ya realizaste tu pago?", 
				[
					"style" =>	"background: white;padding: 10px;font-size: 2em;"
			])?>
				
			<?=span("Notifica tu pago para que podamos procesarlo " , 
				[	
					"style"	=>	"padding: 4px;"
					"class"	=> 	"white"
			])?>
				
			<?=anchor_enid("dando click aquí. ",
				[
					"href" 	=>	"<?=$url_request?>notificar/?recibo=". $id_recibo ,
					"style"	=>	"background:white;color: black!important;padding: 5px;"
			])?>				
		</div>		
		<hr>
		
		<?=div(anchor_enid( 
			"YA NO QUIERO RECIBIR ESTE CORREO" ,  
			[
				'href' 	=> $url_cancelacion ,  
				'style' => 'color:black;font-size:.9em;font-weight:bold'
			])
		)?>		
	</div>
</div>	