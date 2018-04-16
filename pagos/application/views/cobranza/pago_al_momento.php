<?php 
	
	$costo_envio_cliente_sistema=  $costo_envio_sistema["costo_envio_cliente"];
	$recibo =  $recibo[0]; 
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
	$saldo_pendiente =  ($monto_a_pagar * $num_ciclos_contratados )- $saldo_cubierto;	


	$servicio = $servicio[0];
	$flag_servicio =  $servicio["flag_servicio"];
	$text_envio_cliente_sistema = "";
	if($flag_servicio == 0 ){
		$saldo_pendiente =  $saldo_pendiente + $costo_envio_cliente;		
		$text_envio_cliente_sistema =  $costo_envio_sistema["text_envio"]["cliente"];
	}

	$url_pago_oxxo =$url_request ."orden_pago_oxxo/?q=".$saldo_pendiente."&q2=".$id_recibo.
	"&q3=".$id_usuario_venta;
	
	/**/
	$url_pago_saldo_enid = 
	"../movimientos/?q=transfer&action=8&operacion=".$id_usuario_venta."&recibo=".$id_recibo;

	$data_oxxo["url_pago_oxxo"] =  $url_pago_oxxo;
	/*Data para notificar el pago*/
	$data_notificacion["id_recibo"] =  $id_recibo;
	$url_img_servicio =  "../imgs/index.php/enid/imagen_servicio/$id_servicio";

	$url_pago_paypal ="https://www.paypal.me/eniservice/".$saldo_pendiente;
	$data["url_pago_paypal"] = $url_pago_paypal;
	$data["recibo"] =$recibo;
?>

<div class="col-lg-8">
		
		<hr>
		<div style="margin-top: 10px; ">
			<h3>
				<span style="color: black;font-weight: bold;"> 	
					<i class="fa fa-credit-card "></i> Formas de pago
				</span>
			</h3>
		</div>		
		<hr>
	<?=n_row_12()?>		
		<?=n_row_12()?>
		<a href="<?=$url_pago_saldo_enid?>">
			<div class="contenedor_tipo_pago">
				Realiza compras con saldo Enid Service
			</div>
		</a>
		<?=end_row()?>
		<?=n_row_12()?>
			<a href="<?=$url_pago_oxxo?>">
				<div class="contenedor_tipo_pago">
					Pagos en tiendas de autoservicio (OXXO)
				</div>
			</a>
		<?=end_row()?>
		<?=n_row_12()?>
			<a href="<?=$url_pago_paypal?>">
				<div class="contenedor_tipo_pago">
					Compra através de PayPal	
				</div>
			</a>
		<?=end_row()?>
	
	
	
		<div style="margin-top: 10px; ">
			<h3>
				<span style="color: black;font-weight: bold;"> 	
					Dirección de envío
				</span>
			</h3>
		</div>		
		<div>
			<?php if(count($informacion_envio)>0):?>
				<div style="background:#1F2839;color: white;padding: 10px;">
			    <div style="margin-top: 10px;" class="text-right">
			        <div 	
			        	class="a_enid_blue btn_direccion_envio fa fa-pencil"  
			        	id='<?=$id_recibo?>'						
						href="#tab_mis_pagos"			        	
						data-toggle="tab"
			        	style="color: white!important">
			            
			        </div>
			    </div>


			    <div class='texto_direccion_envio_pedido'>

			        <?=entrega_data_campo($informacion_envio , "direccion" )?>
			        <?=entrega_data_campo($informacion_envio , "calle" )?>
			        <?=entrega_data_campo($informacion_envio , "numero_exterior")?>
			        <?=entrega_data_campo($informacion_envio , "numero_interior")?>
			        <?=entrega_data_campo($informacion_envio , "entre_calles")?>
			        <?=entrega_data_campo($informacion_envio , "cp")?>
			        <?=entrega_data_campo($informacion_envio , "asentamiento")?>
			        <?=entrega_data_campo($informacion_envio , "municipio")?>
			        <?=entrega_data_campo($informacion_envio , "ciudad" )?>
			        <?=entrega_data_campo($informacion_envio , "estado" )?>		
			        <br>
			    </div>    
			    <div>
			    	<div>
			    		¿Quíen más puede recibir tu pedido?
			    	</div>
			    	<div>
			    		<?=entrega_data_campo($informacion_envio , "nombre_receptor" )?>
			    	</div>
			    	<div>
			    		<?=entrega_data_campo($informacion_envio , "telefono_receptor" )?>
			    	</div>
			    </div>
			</div>
			<?php else: ?>
				<?=n_row_12()?>
					<div class="btn_direccion_envio contenedor_agregar_direccion_envio_pedido" 
						id='<?=$id_recibo?>'
						href="#tab_mis_pagos"			        	
						data-toggle="tab">						
						<i class="fa fa-bus ">
						</i> 
						Agrega la dirección de envío de tu pedido!
						
					</div>
				<?=end_row()?>
			<?php endif;?>
		</div>
		<hr>
		
		
		
		<?=n_row_12()?>
			<div style="margin-top: 30px;">
				<a 	class="cancelar_compra"
					id="<?=$id_recibo?>" 
					modalidad='0'
					style="background: #f00 !important;padding: 10px!important;color:white !important;font-weight: bold !important;">
					CANCELAR COMPRA
				</a>
			</div>
		<?=end_row()?>


		
	<?=end_row()?>	
</div>

<div class="col-lg-4">
			<div style="border-style: solid;padding: 10px;border-width: 1px;">
				<h1>	
					<span style="color: black;font-weight: bold;"> 
						#Recibo: <?=$id_recibo;?>
					</span> 
					
				</h1>			
				<div>
					<span style="font-size: 1.5em;font-weight:bold;background: black;color: white;">
						Concepto
					</span>
				</div>
				<p>
					<?=$resumen_pedido;?>
				</p>
				<p>
					<strong>
						<?=valida_texto_periodos_contratados(
							$num_ciclos_contratados, 
							$flag_servicio , 
							$id_ciclo_facturacion
							)?>
					</strong>
				</p>
				<p>
					<strong>
					Precio $
					</strong><?=$monto_a_pagar;?>       	
				</p>
				<p>
					<?=$text_envio_cliente_sistema?>
				</p>
			</div>
			<div style="border-style: solid;font-size: 1.5em;text-align: center;">
				<?=n_row_12()?>
				<strong>
	          		Monto total pendiente 
	          	</strong>
	          	<?=end_row()?>
	          	<?=n_row_12()?>
	          	<span style="background: #0162e0; color:white;padding: 3px;">
	          		<?=$saldo_pendiente?> Pesos Mexicanos	
	          	</span>
	          	<?=end_row()?>
	        </div>
	        <?=n_row_12()?>
	        	<img src="<?=$url_img_servicio?>" style="width: 100%">
	        <?=end_row()?>
		      
</div>

<style type="text/css">
	.contenedor_tipo_pago{
		padding: 10px;
		border-style: solid;
		border-width: 1px;
		margin-top: 10px;
		font-size: 1.2em;
		background: #02235c;
		color: white;
	}
	.contenedor_tipo_pago:hover{
		cursor: pointer;
		background: #005dff;
	}
	.contenedor_agregar_direccion_envio_pedido{
	
		background: #005dff;
		padding: 10px;
		border-style: solid;
		border-width: 1px;
		margin-top: 10px;
		font-size: 1.2em;		
		color: white;
	}
	.contenedor_agregar_direccion_envio_pedido:hover{
		cursor: pointer;
		background: #0057cc;
		padding: 10px;
		border-style: solid;
		border-width: 1px;
		margin-top: 10px;
		font-size: 1.2em;		
		color: white;
	}
	.texto_direccion_envio_pedido{
		font-size: .9em;
		text-transform: uppercase;
	}
</style>