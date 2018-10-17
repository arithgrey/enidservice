<?php 
	
	//$costo_envio_cliente_sistema 	=  $costo_envio_sistema["costo_envio_cliente"];
	$recibo 				=  	$recibo[0]; 
	$id_forma_pago  		=  	$recibo["id_forma_pago"];
	$saldo_cubierto  		=  	$recibo["saldo_cubierto"];
	$fecha_registro  		=  	$recibo["fecha_registro"];
	$status  				=  	$recibo["status"];
	$fecha_vencimiento  	=  	$recibo["fecha_vencimiento"];
	$monto_a_pagar  		=  	$recibo["monto_a_pagar"];
	$id_recibo 				=  	$recibo["id_proyecto_persona_forma_pago"];	
	$num_email_recordatorio =  	$recibo["num_email_recordatorio"];
	$id_usuario_referencia  =  	$recibo["id_usuario_referencia"];
	$flag_pago_comision  	=  	$recibo["flag_pago_comision"];
	$flag_envio_gratis  	=  	$recibo["flag_envio_gratis"];
	$costo_envio_cliente 	=  	$recibo["costo_envio_cliente"];
	$id_usuario_venta  		=  	$recibo["id_usuario_venta"];
	$id_ciclo_facturacion	=  	$recibo["id_ciclo_facturacion"];
	$num_ciclos_contratados =  	$recibo["num_ciclos_contratados"];
	$id_usuario  			=  	$recibo["id_usuario"];
	$precio  				=  	$recibo["precio"];
	$costo_envio_vendedor  	=  	$recibo["costo_envio_vendedor"];
	$id_servicio  			=  	$recibo["id_servicio"];
	$resumen_pedido  		=  	$recibo["resumen_pedido"];
	$servicio 				= 	$servicio[0];
	$flag_servicio 			=  	$servicio["flag_servicio"];

	
	
	$deuda 					=  get_saldo_pendiente($monto_a_pagar,
								$num_ciclos_contratados,
								$saldo_cubierto,
								$flag_servicio,
								$costo_envio_cliente,
								$costo_envio_sistema);

	
	$saldo_pendiente 		= 	$deuda["saldo_pendiente_envio"];   
	$url_pago_oxxo 			= 	get_link_oxxo($url_request,$saldo_pendiente,$id_recibo,$id_usuario_venta);
	$url_pago_saldo_enid 	= 	get_link_saldo_enid($id_usuario_venta , $id_recibo);	
	$url_img_servicio 		=  	link_imagen_servicio($id_servicio);
	$url_pago_paypal 		=	get_link_paypal($saldo_pendiente);	
	$data["url_pago_paypal"]= 	$url_pago_paypal;
	$data["recibo"] 		=	$recibo;
?>
<div class="col-lg-8">
	<hr>		
	<?=heading_enid(icon("fa fa-credit-card") . "Formas de pago" , 3 , ["class" => 'strong' ])?>	
	<hr>

	<?=anchor_enid(
			"Realiza compras con saldo Enid Service" , 
			[
				"href" 	=> 	$url_pago_saldo_enid 				
			], 
			1, 
			1
	)?>
	<?=anchor_enid(
			"Pagos en tiendas de autoservicio (OXXO)",
			[ "href"	=>  $url_pago_oxxo	],
			1,
			1
	)?>
	<?=anchor_enid(
			"Compra através de PayPal",
			["href"	=>  $url_pago_paypal],
			1,
			1
	)?>
	<?=n_row_12()?>				
		
		
		
	
		<?=heading_enid("Dirección de envío" , 3)?>
		
		<div>
			<?php if(count($informacion_envio)>0):?>

				<div style="background:#1F2839;color: white;padding: 10px;">
			    <div class="text-right top_10">
			    	<?=icon("fa fa-pencil" ,  
			    		[			    		
			    		"class"			=> 	"a_enid_blue btn_direccion_envio ",
			        	"id" 			=> 	$id_recibo,
						"href"			=> 	"#tab_mis_pagos",
						"data-toggle"	=> 	"tab"
			    		],
			    		1
			    	)?>
			    </div>
			    <div class='texto_direccion_envio_pedido'>
			        <?=get_campo($informacion_envio , "direccion" )?>
			        <?=get_campo($informacion_envio , "calle" )?>
			        <?=get_campo($informacion_envio , "numero_exterior")?>
			        <?=get_campo($informacion_envio , "numero_interior")?>
			        <?=get_campo($informacion_envio , "entre_calles")?>
			        <?=get_campo($informacion_envio , "cp")?>
			        <?=get_campo($informacion_envio , "asentamiento")?>
			        <?=get_campo($informacion_envio , "municipio")?>
			        <?=get_campo($informacion_envio , "ciudad" )?>
			        <?=get_campo($informacion_envio , "estado" )?>		
			    </div>    
			    <?=div("¿Quíen más puede recibir tu pedido?")?>
			    <?=div(get_campo($informacion_envio , "nombre_receptor" ))?>
			    <?=div(get_campo($informacion_envio , "telefono_receptor" ))?>
			</div>
			<?php else: ?>
				<?=div(
					icon("fa fa-bus")." Agrega la dirección de envío de tu pedido!", 
						[
							"class"				=>	
								"btn_direccion_envio 
								contenedor_agregar_direccion_envio_pedido 
								a_enid_black cursor_pointer",
							"id"				=>	$id_recibo,
							"href"				=>	"#tab_mis_pagos",
							"data-toggle"		=>	"tab"	
						],
						1
				)?>
			<?php endif;?>
		</div>
		<hr>
		


		<?=anchor_enid('CANCELAR COMPRA', 
		[
			"class"		=> 	"cancelar_compra",
			"id"		=> 	 $id_recibo,
			"modalidad"	=> 	'0',
			"style"		=> 	"background: #f00 !important;padding: 10px!important;color:white !important;font-weight: bold !important;"
		])?>		
	<?=end_row()?>	
</div>
<div class="col-lg-4">
	<div style="border-style: solid;padding: 10px;border-width: 1px;">
		<?=heading_enid("#Recibo: ".$id_recibo)?>
		<?=div("Concepto")?>		
		<?=div($resumen_pedido)?>
		<?=valida_texto_periodos_contratados($num_ciclos_contratados, $flag_servicio , $id_ciclo_facturacion)?>
		<?=div("Precio $".$monto_a_pagar)?>
		<?=div($deuda["text_envio"])?>
	</div>
	<div style="border-style: solid;text-align: center;">
		<?=heading_enid("Monto total pendiente-", 3, 	['class' 	=> 'strong'] )?>
	    <?=heading_enid($saldo_pendiente ."MXN", 4 ,   	["class" => 'blue_enid strong'] )?>
	    <?=heading_enid("Pesos Mexicanos" , 4 , 		["class"=> 'strong'])?>
	</div>
	<?=div(img($url_img_servicio), [] , 1)?>	        
</div>

