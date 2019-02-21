<?= div(div("ABRIR SOLICITUD", ["class" => "titulo_enid"]), ["class" => "col-lg-6 col-lg-offset-3"]) ?>
	<div class="col-lg-6 col-lg-offset-3 top_50" >
		<?=get_form_ticket($departamentos)?>
	</div>
<?= place("place_registro_ticket") ?>