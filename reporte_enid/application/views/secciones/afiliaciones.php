<div class="tabbable-panel">
	<div class="tabbable-line">
		<ul class="nav nav-tabs">
			<li class="active">
				<?= anchor_enid("Reporte", ["href" => "#tab_reporte_afiliados", "data-toggle" => "tab"]) ?>
			</li>
			<li>
				<?= anchor_enid("Afiliados productividad",
					["href" => "#tab_reporte_lista_afiliados", "data-toggle" => "tab"]) ?>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_reporte_afiliados">
				<?= n_row_12() ?>
				<form class='form_busqueda_afiliacion'>
					<?= $this->load->view("../../../view_tema/inputs_fecha_busqueda") ?>
				</form>
				<?= end_row() ?>
				<?= place("place_repo_afiliacion") ?>
			</div>
			<div class="tab-pane" id="tab_reporte_lista_afiliados">
				<?= n_row_12() ?>
				<form class='form_busqueda_afiliacion_productividad'>
					<?= $this->load->view("../../../view_tema/inputs_fecha_busqueda") ?>
				</form>
				<?= end_row() ?>
				<?= place("place_repo_afiliacion_productividad") ?>
			</div>
		</div>
	</div>
</div>
			