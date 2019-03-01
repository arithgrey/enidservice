<?= div(heading_enid("ULTIMOS MOVIMIENTOS", 1, ["class" => "titulo_enid"]), ["class" => "jumbotron"]) ?>
<?= n_row_12(); ?>
<?php if (count($solicitud_saldo) > 0): ?>
	<?= div("SOLICITUDES DE SALDO A TUS AMIGOS", ["class" => 'titulo_enid_sm_sm']) ?>
<?php endif; ?>
<?php foreach ($solicitud_saldo as $row): ?>
	<?= n_row_12(); ?>
	<div class='list-group-item-movimiento '>
		<table style='width:100%'>
			<tr>
				<?= get_td(div("Folio # " . $row["id_solicitud"], ["class" => 'folio']), ["colspan" => "2"]) ?>
			</tr>
			<tr>
				<td>
					<?=
					get_td(
						div(span("SOLICITUD DE SALDO A" . $row["email_solicitado"], ["class" => 'monto_solicitado']),
							[
								"class" => "desc_solicitud"
							])) ?>
				</td>
				<?= get_td($row["monto_solicitado"] . "MXN", ["class" => 'monto_solicitud_text']) ?>
			</tr>
		</table>
	</div>
	<?= end_row(); ?>

<?php endforeach; ?>
<?= end_row(); ?>
