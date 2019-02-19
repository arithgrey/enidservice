<?= n_row_12() ?>
	<div class='contenedor_principal_enid'>
		<div class="col-lg-4 col-lg-offset-4">
			<?= n_row_12() ?>
			<div
					class="jumbotron"
					style="background: #fbfbfb;border-right-style: solid;border-width:.9px;border-left-style: solid;">
				<?= heading("TRANSFERIR FONDOS", 2) ?>
				<div style="width: 80%;margin: 0 auto;margin-top: 20px;">
					<select style="width: 100%" class="form-control">
						<option class="de" id='de' value="1">
							De saldo Enid Service $<?= get_data_saldo($saldo_disponible) ?> MXN
						</option>
					</select>
				</div>
				<div style="width: 80%;margin: 0 auto;margin-top: 20px;">
					<select style="width: 100%" class="form-control"
						<?= valida_siguiente_paso_cuenta_existente($cuentas_gravadas) ?> >
						<?php if ($cuentas_gravadas == 1): ?>
							<?= despliega_cuentas_registradas($cuentas_bancarias) ?>
						<?php else: ?>
							<option value="A">A
							</option>
						<?php endif; ?>
					</select>
				</div>
				<?= div(anchor_enid(agrega_cuentas_existencia($cuentas_gravadas),
					[
						"href" => "?q=transfer&action=1&seleccion=1",
						"class" => "white",
						"style" => "color: white!important;background:#004faa;padding: 3px;"
					]), ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]) ?>

				<?php if ($saldo_disponible > 100): ?>

					<?= div(div("CONTINUAR " . icon("fa fa-chevron-right"),
						[
							"class" => "btn_transfer",
							"style" => "border-radius: 20px;background: black;padding: 10px;color: white;"
						]),
						["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]) ?>

				<?php else: ?>

					<?= div(div("AUN NO CUENTAS CON FONDOS EN TU CUENTA",
						[
							"style" => "border-radius:20px;background: black;padding:10px;color: white;"
						]), ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]) ?>

				<?php endif; ?>
			</div>
			<?= end_row() ?>
		</div>
	</div>
<?= end_row() ?>