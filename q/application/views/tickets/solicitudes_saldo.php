<?= div(heading_enid("ULTIMOS MOVIMIENTOS", 1, ["class" => "titulo_enid"]), ["class" => "jumbotron"]) ?>
<?php if (count($solicitud_saldo) > 0): ?>
	<?= div("SOLICITUDES DE SALDO A TUS AMIGOS", 'titulo_enid_sm_sm' ) ?>
<?php endif; ?>
<?php foreach ($solicitud_saldo as $row): ?>
	<div class='list-group-item-movimiento '>
		<table>
			<tr>
				<?= get_td(div("Folio # " . $row["id_solicitud"], ["class" => 'folio']), ["colspan" => "2"]) ?>
			</tr>
			<tr>
				<td>
					<?=
					get_td(
						div(
						        span("SOLICITUD DE SALDO A" . $row["email_solicitado"], 'monto_solicitado' )
                                ,
                                "desc_solicitud"
                        )
                    ) ?>
				</td>
				<?= get_td($row["monto_solicitado"] . "MXN", ["class" => 'monto_solicitud_text']) ?>
			</tr>
		</table>
	</div>
<?php endforeach; ?>