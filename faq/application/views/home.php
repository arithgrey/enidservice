<div class="col-lg-2">
	<?= $this->load->view("../../../view_tema/izquierdo.php") ?>
</div>
<div class='col-lg-10'>
	<?= get_format_menu($in_session, $perfil) ?>
	<?php if ($in_session == 1): ?>
		<div class="tab-pane fade" id="tab2default">
			<?php $this->load->view("secciones_2/form"); ?>
		</div>
	<?php endif; ?>
	<div class="tab-pane fade in active" id="tab1default">
		<?= $this->load->view("secciones_2/principal_faqs") ?>
	</div>

</div>


    



