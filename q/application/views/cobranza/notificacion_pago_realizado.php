<?php

$saldo_cubierto = get_campo($recibo, "saldo_cubierto");
$costo_envio_cliente = get_campo($recibo, "costo_envio_cliente");
$total_cubierto = $saldo_cubierto + $costo_envio_cliente;
$resumen_pedido = get_campo($recibo, "resumen_pedido");
$cantidad = get_campo($recibo, "num_ciclos_contratados");
$precio = get_campo($recibo, "precio");
$monto_a_pagar = get_campo($recibo, "monto_a_pagar");
$url_seguimiento =  "../pedidos/?seguimiento=".$id_recibo;

?>
<?=validate_format_cancelacion($total_cubierto, $id_recibo, $modalidad)?>
<div style="margin: 0 auto;width: 66%;" class="border padding_10 shadow">
	<?=get_format_transaccion($id_recibo)?>
	<table>
		<tr class='tb_pagos'>
			<?= get_td(heading_enid("Pago enviado a ", 4)) ?>
			<?= get_td(heading_enid("Importe ", 4)) ?>
		</tr>
		<tr>
			<td>
				<?= strtoupper(get_campo($usuario_venta, "nombre")) ?>
				<?= strtoupper(get_campo($usuario_venta, "apellido_materno")) ?>
				<?= strtoupper(get_campo($usuario_venta, "apellido_paterno")) ?>
			</td>
			<?= get_td($total_cubierto . " MXN") ?>
		</tr>
	</table>
	<table>
		<tr>
			<?= get_td("Estado: " . span("COMPLETADO"), ["style" => "border-style: solid;border-color: #000506;padding: 2px;"]) ?>
			<?= get_td() ?>
		</tr>
	</table>
	<hr>
	<table style="width: 100%;margin-top: 20px;" class="padding_10">
		<tr class='tb_pagos'>
			<?= get_td("Detalles del pedido") ?>
			<?= get_td("Cantidad") ?>
			<?= get_td("Precio") ?>
			<?= get_td("Subtotal") ?>
		</tr>
		<tr>
			<?= get_td($resumen_pedido) ?>
			<?= get_td($cantidad) ?>
			<?= get_td("$" . $precio . "MXN") ?>
			<?= get_td("$" . $monto_a_pagar . "MXN") ?>
		</tr>
		<tr>
			<?= get_td() ?>
			<?= get_td() ?>
			<?= get_td("Total de la compra") ?>
			<?= get_td("$" . $monto_a_pagar . "MXN") ?>
		</tr>
	</table>
	<?=guardar("RASTREAR PEDIDO",["href"=> $url_seguimiento , "class"=> "top_50 bottom_50"],1,1,0,$url_seguimiento)?>
</div>

