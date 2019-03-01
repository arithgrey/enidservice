<?= n_row_12() ?>
	<div class="contenedor_principal_enid">
		<?= div(append_data([
			ul(li("TEMAS DE AYUDA")),
			ul([
				"Realizar pedidos"
				, "Pagos"
				, "Envíos"
				, "Devoluciones"
				, "Uso de nuestro sitio"
				, "Términos y condiciones"
				, "POlítica de privacidad"
				, "Términos y condiciones de uso del sitio"])

		]),
			["class" => "col-lg-3"]) ?>
		
		<div class="col-lg-9">
			<?= heading_enid($titulo) ?>
			<?= $this->load->view($vista); ?>
		</div>
	</div>
<?= end_row() ?>