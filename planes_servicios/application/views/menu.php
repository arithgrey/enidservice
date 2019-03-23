<?= get_menu($is_mobile, $action) ?>
<?php $extra_estilos = ($action == 1) ? "display:none" : ""; ?>
<div class="contenedor_top" style="<?= $extra_estilos ?>">
	<?= heading_enid("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA", 3) ?>
	<?= get_top_ventas($top_servicios) ?>
</div>


