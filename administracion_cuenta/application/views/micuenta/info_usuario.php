<div class="row">
	<div class="col-sm-4">
		<?= place('place_form_img') ?>
		<div class="coach-card">
			<div style="padding: 10px;">
				<?= div(icon("fa fa-pencil editar_imagen_perfil white"), ["class" => "text-left"], 1) ?>
				<?= img([
					"src" => "../imgs/index.php/enid/imagen_usuario/" . $id_usuario,
					"onerror" => "this.src='../img_tema/user/user.png'"
				]) ?>
			</div>
			<div class="row coach-info">
				<?= div(get_resumen_cuenta($info_usuario), ["class" => "col-lg-12"]) ?>
			</div>
		</div>
	</div>
	<?= div("", ["class" => "col-lg-2"]) ?>
	<div class="col-lg-6">
		<?= get_resumen_cuenta($info_usuario) ?>
		<?= p("DETALLES", 1) ?>
		<?= div("Número de Servicios/Productos" . anchor_enid("(" . $num_proyectos . " ) ver", ["href" => "../area_cliente", "class" => "blue_enid strong"]), 1) ?>
		<?= div(anchor_enid("Tickets de soporte:", ["href" => "../area_cliente", "class" => "blue_enid strong"]), [], 1) ?>
		<?= div("Tareas de soporte:" . anchor_enid("(" . $num_proyectos . " ) ver", ["href" => "../area_cliente", "class" => "blue_enid strong"]), 1) ?>
	</div>
</div>
