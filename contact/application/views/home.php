<section class="imagen_principal">
	<div class="col-lg-3 top_50">
		<div style="background: #000 !important;opacity: .85;padding: .1px;opacity: .8">
			<?= heading_enid(
				"SABER MAS",
				3,
				["class" => "white strong "]
			); ?>
			<?= $this->load->view("../../../view_tema/social_enid") ?>
		</div>
	</div>
    <?=div("",9)?>
</section>
<section style='background:#0012dd !important;'>
	<?= div(format_direccion($ubicacion, $departamentos, $nombre, $email, $telefono), ["class" => "container inner", "id" => "direccion"]) ?>
</section>
<?= input_hidden(["value" => $ubicacion, "class" => "ubicacion"]) ?>