<?php 
	
	$saldo_cubierto =  entrega_data_campo($recibo , "saldo_cubierto");
	$costo_envio_cliente =  entrega_data_campo($recibo , "costo_envio_cliente");
	$total_cubierto =  $saldo_cubierto + $costo_envio_cliente;
	$resumen_pedido =  entrega_data_campo($recibo , "resumen_pedido");
	$cantidad =  entrega_data_campo($recibo , "num_ciclos_contratados");
	$precio =  entrega_data_campo($recibo , "precio");
	$monto_a_pagar = entrega_data_campo($recibo , "monto_a_pagar");
	

?>
<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
<style type="text/css">
	body{font-family: 'Muli', sans-serif;}
</style>

	<div style="margin: 0 auto;width: 66%;">		
		<center>
			<div style="width: 200px;">
				<img src="<?=$url_request?>img_tema/enid_service_logo.jpg" width="100%">
			</div>
		</center>
		<h2>
			<span style="color: black;font-weight: bold;"> 
				Detalles de la transacción
			</span> 		
		</h2>
		<h3>
			#Recibo: <?=$id_recibo;?>
		</h3>
		<hr>
		<table  style="width: 100%;padding: 10px;">

			<tr class='tb_pagos'>
				<td>
					<h4>
						Pago enviado a 
					</h4>
				</td>
				<td>
									
					<h4>
						Importe 
					</h4>
				</td>
			</tr>
			<tr>
				<td>
					<?=strtoupper(entrega_data_campo($usuario_venta , "nombre" ))?>
					<?=strtoupper(entrega_data_campo($usuario_venta , "apellido_materno" ))?>
					<?=strtoupper(entrega_data_campo($usuario_venta , "apellido_paterno" ))?>			
				</td>
				<td>
					<?=$total_cubierto?>MXN
				</td>
			</tr>
		</table>


		<table style="width: 100%;margin-top: 20px;">
			<tr >
				<td style="font-weight: bold;">
					Estado: 
					<span style="border-style: solid;border-color: #000506;padding: 2px;">  
						COMPLETADO
					</span>
				</td>
				<td></td>
			</tr>
		</table>
		<hr>
		<table style="width: 100%;padding: 10px;margin-top: 20px;">
			<tr class='tb_pagos'>
				<td style="font-weight: bold;">
					Detalles del pedido
				</td>
				<td style="font-weight: bold;">
					Cantidad
				</td>
				<td style="font-weight: bold;">
					Precio
				</td>
				<td style="font-weight: bold;">
					Subtotal
				</td>
			</tr>
			<tr>
				<td>
					<?=$resumen_pedido?>			
				</td>
				<td class="tex-center">
					<?=$cantidad?>
				</td>
				<td>
					$<?=$precio?>MXN
				</td>
				<td>
					$<?=$monto_a_pagar?>MXN
				</td>
			</tr>
			<tr>
				<td>
				
				</td>
				<td>
				
				</td>
				<td>
					<strong>
						Total de la compra
					</strong>
				</td>
				<td>
					$<?=$monto_a_pagar?>MXN
				</td>
			</tr>
			
		</table>
	</div>
</div>	
<style type="text/css">
	.tb_pagos{
		background: #023460;
		color: white;
		text-align: center;
	}
	table{
		text-align: center;
	}

</style>