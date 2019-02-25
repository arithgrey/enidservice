<div class="contenedor_principal_enid">
	<div class="col-lg-2">
		<nav class="nav-sidebar">
			<?= get_menu($id_usuario); ?>
		</nav>
	</div>
	<div class="col-lg-10">
		<div class="tab-content">
			<div class="tab-pane active" id="tab_mis_datos">
				<?= $this->load->view("micuenta/cuenta"); ?>
			</div>
			<div class="tab-pane " id="tab_privacidad">
				<?= $this->load->view("micuenta/privacidad"); ?>
			</div>
			<div class="tab-pane " id="tab_privacidad_seguridad">
				<?= $this->load->view("micuenta/privacidad_seguridad"); ?>
			</div>
			<div class="tab-pane " id="tab_direccion">
				<?= $this->load->view("micuenta/direccion") ?>
			</div>
		</div>
	</div>
</div>

	