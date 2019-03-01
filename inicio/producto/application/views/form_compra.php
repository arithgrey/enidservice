<?php if ($flag_servicio == 0): ?>
	<?php if ($existencia > 0): ?>
		<?=get_form_compra($id_servicio , $flag_servicio , $existencia , $in_session,$q2)?>
	<?php endif; ?>
<?php else: ?>
	<?php if ($precio > 0 && $id_ciclo_facturacion != 9): ?>
		<?=get_form_compra($id_servicio , $flag_servicio , $existencia , $in_session,$q2)?>
	<?php endif; ?>
<?php endif; ?>
