<div>
	<div class="col-lg-8">
		<?= n_row_12() ?>
		<div class="col-lg-5">
			<div style="position: relative;">
				<?= div(img([
					"src" => "../imgs/index.php/enid/imagen_usuario/" . $id_usuario,
					"onerror" => "this.src='../img_tema/user/user.png'"
				]), ["class" => "imagen_usuario_completa"]) ?>
				<?= anchor_enid("MODIFICAR", ["class" => "editar_imagen_perfil "]) ?>
			</div>
			<?= place("place_form_img") ?>
		</div>
		<?= end_row() ?>
		<?= n_row_12() ?>
		<div class="page-header menu_info_usuario">
			<?= heading_enid("Cuenta", 1, ['class' => 'strong'], 1) ?>
			<?= br() ?>
			<?= addNRow(get_form_nombre($usuario)) ?>
			<?= addNRow(get_form_email($usuario)) ?>
			<?= br() ?>
			<?= addNRow(get_form_telefono($usuario)) ?>
			<?= addNRow(get_form_negocio($usuario)) ?>
		</div>
		<?= end_row() ?>
		<?= div("Mantén la calma esta información será solo será visible si tú lo permites ",
			['class' => 'registro_telefono_usuario_lada_negocio blue_enid_background2 white padding_1'], 1) ?>
	</div>
	<div class="col-lg-4">
		<div class="contenedor_lateral">
			<?= heading_enid("TU CUENTA ENID SERVICE", 3) ?>
			<?= n_row_12() ?>
			<?= get_campo($usuario, "nombre", "Tu Nombre") ?>
			<?= get_campo($usuario, "apellido_paterno", "Tu prime apellido") ?>
			<?= get_campo($usuario, "apellido_materno", "Tu prime apellido") ?>
			<?= end_row() ?>
			<?= addNRow(div(get_campo($usuario, "email", ""), ["class" => "top_20"], 1)) ?>
			<?= addNRow(get_campo($usuario, "tel_contacto", "Tu prime apellido", 1)) ?>
			<?= br() ?>
			<?= anchor_enid("MI DIRECCIÓN" . icon('fa  fa-fighter-jet'),
				["class" => "a_enid_black btn_direccion top_20",
					"href" => "#tab_direccion",
					"data-toggle" => "tab"
				],
				1,
				1) ?>
			<?= hr() ?>
		</div>
	</div>
</div>
