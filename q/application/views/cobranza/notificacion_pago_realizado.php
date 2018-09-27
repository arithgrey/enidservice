<?php 
	
	$saldo_cubierto =  entrega_data_campo($recibo , "saldo_cubierto");
	$costo_envio_cliente =  entrega_data_campo($recibo , "costo_envio_cliente");
	$total_cubierto =  $saldo_cubierto + $costo_envio_cliente;
	$resumen_pedido =  entrega_data_campo($recibo , "resumen_pedido");
	$cantidad =  entrega_data_campo($recibo , "num_ciclos_contratados");
	$precio =  entrega_data_campo($recibo , "precio");
	$monto_a_pagar = entrega_data_campo($recibo , "monto_a_pagar");
	

?>

	<?php if ($modalidad ==  1):?>
		<?=anchor_enid("CANCELAR VENTA", 
			[
				"class"			=>	"cancelar_compra" ,
				"id"			=>	$id_recibo,
				"modalidad" 	=> 	$modalidad,
				"style"			=> 	"background: #f00 !important;padding: 10px!important;color:white !important;font-weight: bold !important;"
			],
			1
		)?>
	<?php endif;?>
	<div style="margin: 0 auto;width: 66%;">		
		<?=div(img_enid(), ["style"=>"width: 200px;"])?>
		<?=heading_enid("Detalles de la transacción" , 2)?>
		<?=heading_enid("#Recibo: ".$id_recibo , 3)?>
		<hr>
		<table>
			<tr class='tb_pagos'>
				<?=get_td(heading_enid("Pago enviado a " , 4))?>
				<?=get_td(heading_enid("Importe " , 4))?>
			</tr>
			<tr>
				<td>
					<?=strtoupper(entrega_data_campo($usuario_venta , "nombre" ))?>
					<?=strtoupper(entrega_data_campo($usuario_venta , "apellido_materno" ))?>
					<?=strtoupper(entrega_data_campo($usuario_venta , "apellido_paterno" ))?>			
				</td>
				<?=get_td($total_cubierto." MXN")?>
			</tr>
		</table>
		<table>
			<tr>
				<?=get_td("Estado: " . span("COMPLETADO") , ["style" => "border-style: solid;border-color: #000506;padding: 2px;"])?>
				<?=get_td()?>
			</tr>
		</table>
		<hr>
		<table style="width: 100%;padding: 10px;margin-top: 20px;">
			<tr class='tb_pagos'>
				<?=get_td("Detalles del pedido")?>
				<?=get_td("Cantidad")?>
				<?=get_td("Precio")?>				
				<?=get_td("Subtotal")?>				
			</tr>
			<tr>
				<?=get_td($resumen_pedido)?>
				<?=get_td($cantidad)?>
				<?=get_td("$".$precio."MXN")?>
				<?=get_td("$".$monto_a_pagar."MXN")?>
			</tr>
			<tr>
				<?=get_td()?>
				<?=get_td()?>
				<?=get_td("Total de la compra")?>
				<?=get_td("$".$monto_a_pagar."MXN")?>
			</tr>
		</table>
	</div>
</div>	
