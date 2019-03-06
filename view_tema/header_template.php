<!DOCTYPE html>
<html lang="es">
<head>
	<?= $this->load->view("../../../view_tema/header_meta_enid") ?>
	<div id="flipkart-navbar">
		<?php $extra_contenedor =  ($in_session > 0 ) ?  " display_flex_enid " : ""; ?>
		<div class="container  <?=$extra_contenedor ?>">
			<?php if ($is_mobile < 1 && $in_session < 1): ?>
				<div class="menu_completo_enid_service display_flex_enid">
					<?= get_logo($is_mobile) ?>
					<?php if ($is_mobile < 1 && !isset($proceso_compra) || (isset($proceso_compra) && $proceso_compra < 1)): ?>
						<?= $this->load->view("../../../view_tema/formularios/form_busqueda_departamentos") ?>
					<?php endif; ?>
					<?= get_menu_session($in_session, $proceso_compra) ?>
				</div>
			<?php elseif ($is_mobile > 0  && $in_session < 1): ?>
				<?= get_logo($is_mobile, $in_session) ?>
			<?php elseif ($is_mobile >  0 && $in_session > 0 ): ?>
				<?= get_logo($is_mobile, $in_session) ?>
					<?= $this->load->view("../../../view_tema/tmp_menu") ?>
			<?php elseif ($is_mobile < 1 && $in_session > 0): ?>
				<?= get_logo($is_mobile, $in_session) ?>
					<?= $this->load->view("../../../view_tema/formularios/form_busqueda_departamentos") ?>
					<?= $this->load->view("../../../view_tema/tmp_menu") ?>
			<?php endif; ?>
		</div>
	</div>
<?= $this->load->view("../../../view_tema/menu_session_movil") ?>