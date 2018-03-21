<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
<style type="text/css">
	body{font-family: 'Muli', sans-serif;}
</style>
<?php 	
	$costo_envio_cliente_sistema=  $costo_envio_sistema["costo_envio_cliente"];
	$text_envio_cliente_sistema =  $costo_envio_sistema["text_envio"]["cliente"];


	$recibo =  $recibo[0];  
	/*Información de recibo*/
	$id_forma_pago  =  $recibo["id_forma_pago"];
	$saldo_cubierto  =  $recibo["saldo_cubierto"];
	$fecha_registro  =  $recibo["fecha_registro"];
	$status  =  $recibo["status"];
	$fecha_vencimiento  =  $recibo["fecha_vencimiento"];
	$monto_a_pagar  =  $recibo["monto_a_pagar"];
	$id_proyecto_persona_forma_pago  =  $recibo["id_proyecto_persona_forma_pago"];
	$id_recibo =  $id_proyecto_persona_forma_pago; 
	$num_email_recordatorio  =  $recibo["num_email_recordatorio"];
	$id_usuario_referencia  =  $recibo["id_usuario_referencia"];
	$flag_pago_comision  =  $recibo["flag_pago_comision"];
	$flag_envio_gratis  =  $recibo["flag_envio_gratis"];
	$costo_envio_cliente  =  $recibo["costo_envio_cliente"];
	$id_usuario_venta  =  $recibo["id_usuario_venta"];
	$id_ciclo_facturacion  =  $recibo["id_ciclo_facturacion"];
	$num_ciclos_contratados  =  $recibo["num_ciclos_contratados"];
	$id_usuario  =  $recibo["id_usuario"];
	$precio  =  $recibo["precio"];
	$costo_envio_vendedor  =  $recibo["costo_envio_vendedor"];
	$id_servicio  =  $recibo["id_servicio"];
	$resumen_pedido  =  $recibo["resumen_pedido"];
	
	/*Información del usuario*/
	$usuario =  $usuario[0];
	$id_usuario =  $usuario["id_usuario"]; 
	$nombre =  $usuario["nombre"]; 
	$apellido_paterno =  $usuario["apellido_paterno"]; 
	$apellido_materno=  $usuario["apellido_materno"]; 
	$email =  $usuario["email"]; 
	$url_request =  $url_request;

	$cliente = $nombre." ". $apellido_paterno ." " .$apellido_materno;		
	

	if($costo_envio_cliente_sistema > $costo_envio_vendedor) {
		$costo_envio_cliente =  $costo_envio_cliente_sistema;	
	}
	/*Data extra para oxxo*/
	$saldo_pendiente =  $monto_a_pagar - $saldo_cubierto;
	$saldo_pendiente =  $saldo_pendiente + $costo_envio_cliente;	
	$url_pago_oxxo =$url_request ."orden_pago_oxxo/?q=".$saldo_pendiente."&q2=".$id_recibo;
	$data_oxxo["url_pago_oxxo"] =  $url_pago_oxxo;
	/*Data para notificar el pago*/
	$data_notificacion["id_recibo"] =  $id_recibo;

?>
<?php			

	/**/
	$servicio = $servicio[0];
	$nombre_servicio =  $servicio["nombre_servicio"];	
	/**/	
	$proyecto =  $servicio;		
	$detalles =  $resumen_pedido;	
	/**/
	$ciclo_de_facturacion =  $id_ciclo_facturacion;  
	$num_ciclos_contratados =  $num_ciclos_contratados;  	
	/**/	
	$saldo_cubierto =  $saldo_cubierto;
	$monto_a_pagar =    $monto_a_pagar;

	$primer_registro =  $fecha_registro;	

	$saldo_pendiente =  $monto_a_pagar - $saldo_cubierto;
	if ($saldo_pendiente < 0 ) {
		$saldo_pendiente =0;
	}
	$estado_text ="";
	if ($saldo_cubierto < $monto_a_pagar ){
		$estado_text ="Pendiente";
	}	
	$saldo_pendiente = $costo_envio_cliente + $saldo_pendiente;
	
	$data["saldo_pendiente"] =  $saldo_pendiente;
	$url_pago_paypal ="https://www.paypal.me/eniservice/".$saldo_pendiente;
	$data["url_pago_paypal"] = $url_pago_paypal;
	$data["recibo"] =$recibo;
	
	$data_extra["cliente"] =  $cliente;


?>
	<div style="margin: 0 auto;width: 66%;">
		<?=$this->load->view("cobranza/saludo_inicial" , $data_extra)?>		
		<center>
			<div style="width: 230px;">
				<img src="<?=$url_request?>img_tema/enid_service_logo.jpg" width="100%">
			</div>
		</center>
		<h1>
			<span style="color: black;font-weight: bold;"> 
				#Recibo: 
			</span> 
			<?=$id_recibo;?>
		</h1>
		<div style="background: #f6fafc;padding: 5px;">
			<div>
				<span style="font-size: 1.5em">
					Concepto
				</span>
			</div>
			<p>
				<?=$resumen_pedido;?>
			</p>
			<p>
				<strong>
					# Piezas
				</strong> <?=$num_ciclos_contratados?>
			</p>
			<p>
				<strong>
				Precio $
				</strong><?=$monto_a_pagar;?>       	
			</p>
			<p>
				<?=$text_envio_cliente_sistema?>
			</p>
			<p>	
				<i class="fa fa-check-circle-o"></i>  
		        Ordén de compra
		        <strong>
		         <?=$primer_registro;?>                         		
		        </strong>
		                            	| Límite de pago 
		        <strong>
		         <?=$fecha_vencimiento;?>
		        </strong>
		    </p>		                            
			<p>
				<h2>
	          		Monto total pendiente <?=$saldo_pendiente?> Pesos Mexicanos	
	          	</h2>
	        </p>
		</div>	      
		<hr>
		<div style="margin-top: 10px; ">
			<h2>				
				Formas de pago Enid Service
			</h2>
		</div>		
		<hr>
		<div>
			<strong>					
				** NINGÚN CARGO A TARJETA ES AUTOMÁTICO. 
				SÓLO PUEDE SER PAGADO POR ACCIÓN DEL USUARIO **					
			</strong>
		</div>
		<div style="margin-top: 20px;">
			<?=$this->load->view("cobranza/pago-paypal" , $data)?> 	
		</div>
		<?=$this->load->view("cobranza/pago_oxxo" , $data_oxxo)?> 			

		<div style="margin-top: 30px;">
				<div style="background: #001a30!important;padding: 5px;">
					<div style="background: white;padding: 10px;font-size: 2em;">
						¿ya realizaste tu pago?
					</div>
					<span style="color: white;padding: 4px;font-size: 1.2em;">
						Notifica tu pago para que podamos procesarlo 
					</span>
					<a 
						href="<?=$url_request?>notificar/?recibo=<?=$id_recibo;?>" 
						style="background:white;color: black!important;padding: 5px;">
						dando click aquí. 
					</a>
				</div>

		</div>
		<hr>

	</div>
</div>	