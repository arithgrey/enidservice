<div class="contenedor_footer_iniciar_sesion">
	<table>
		<tr>
			<td style="background: black;padding: 15px;">
				<?= anchor_enid(icon("fa fa-user") . "INICIAR SESIÓN", ["href" => path_enid("login")]) ?>
			</td>
			<td style="background: black;padding: 15px;">
				<?= anchor_enid(icon("fa fa-user") . "CREAR UNA CUENTA", ["href" => path_enid("login", "/?action=nuevo")]) ?>
			</td>
		</tr>
	</table>
</div>
