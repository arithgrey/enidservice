<div class="image-container set-full-height">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<?= div(anchor_enid(icon("fa fa-print") . "Imprimir",
					["class" => "btn-orden"]),
					["class" => "text-right"]
				) ?>
			</div>
			<div class="col-sm-8 col-sm-offset-2">
				<div class="info_orden_compra" style="box-shadow: 0 16px 24px 2px;">
					<?= div("Orden de pago", 1) ?>
					<?= div(img(
						["src" => "../img_tema/portafolio/oxxo-logo.png",
							"style" => "width: 100px;"
						]),
						1) ?>
					<?= div("Servicios Enid Service Folio #" . $info_pago["q2"],
						["style" => "background: #0000f5;padding: 5px;color: white;"]) ?>

					<div style="margin-top:20px; ">
						<div style="width: 80%;margin: 0 auto;">
							<?= get_form_monto_pago($info_pago) ?>
						</div>
					</div>

					<div style="width: 80%;margin: 0 auto;">
						<?= div(img([
							"src" => "../img_tema/portafolio/logo-bbv.png",
							"style" => "width: 200px"
						]),
							1) ?>
						<?= heading("4152 3131 0230 5609", 5) ?>
					</div>
					<?= get_instrucciones() ?>
				</div>
			</div>
		</div>
	</div>
</div> 
  