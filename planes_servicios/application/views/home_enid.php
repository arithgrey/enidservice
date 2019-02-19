<?= n_row_12() ?>
	<div class='contenedor_principal_enid'>
		<div class='col-lg-2'>
			<?= $this->load->view("menu") ?>
		</div>
		<div class='col-lg-10'>
			<div class="tab-content">
				<div
						class="tab-pane 
                    <?= valida_active_tab(0, $action, $considera_segundo) ?>"
						id='tab_servicios'>
					<?= $this->load->view("secciones/servicios"); ?>
				</div>
				<div
						class="tab-pane <?= valida_active_tab(1, $action) ?>"
						id='tab_form_servicio'>
					<?= $this->load->view("secciones/form_servicios") ?>
				</div>
			</div>
		</div>
		<div class="col-lg-2">
			<?php if (count($top_servicios) > 0 && $is_mobile == 1): ?>
				<div class="card row contenedor_articulos_mobil">
					<div class="card">
						<?= heading_enid("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA", 2) ?>
						<div class="card-body">
							<ul class="list-unstyled mt-3 mb-4">
								<?php foreach ($top_servicios as $row): ?>
									<a href="../producto/?producto=<?= $row['id_servicio'] ?>">
										<li>
											<?= icon("fa fa-angle-right") ?>
											<?php
											$articulo =
												(trim(strlen($row["nombre_servicio"])) > 22) ?
													substr($row["nombre_servicio"], 0, 22) . "..." :
													strlen($row["nombre_servicio"]);
											?>
											<?= $articulo ?>
											<?= div(span($row["vistas"],
												["class" => "a_enid_black_sm_sm"]),
												[
													"class" => "pull-right",
													"title" =>
														"Personas que han visualizado este  producto"]) ?>
										</li>
									</a>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?= end_row() ?>
<?= input_hidden(
	[

		"name" => "version_movil",
		"value" => $is_mobile,
		"class" => 'es_movil'
	]
); ?>
<?= input_hidden(
	[

		"value" => $action,
		"class" => "q_action"
	]
); ?>
<?= input_hidden(
	[

		"value" => $extra_servicio,
		"class" => "extra_servicio"
	]
); ?>