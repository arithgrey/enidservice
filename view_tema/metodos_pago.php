<div class="row info_metodos_pago">
	<div class="col-lg-10">
		<div class="col-lg-6 ">
            <table>
				<tr>
					<?= get_td(heading_enid("MÉTODOS DE PAGO", 5, ["class" => "strong"]),
						['colspan' => 7, "class" => "black"]) ?>
				</tr>
				<tr>
					<?= get_td(img([
						'class' => "logo_pago",
						'style' => 'width:95px!important',
						'src' => "../img_tema/bancos/masterDebito.png"])) ?>

					<?= get_td(img([
						'class' => "logo_pago",
						'style' => 'width:65px!important',
						'src' => "../img_tema/bancos/paypal2.png"])) ?>

					<?= get_td(img([
						'class' => "logo_pago",
						'style' => 'width:95px!important',
						'src' => "../img_tema/bancos/visaDebito.png"])) ?>

					<?= get_td(img([
						'class' => "logo_pago",
						'style' => 'width:65px!important',
						'src' => "../img_tema/bancos/oxxo-logo.png"])) ?>

					<?= get_td(img([
						'class' => "logo_pago",
						'style' => 'width:85px!important',
						'src' => "../img_tema/bancos/bancomer2.png"])) ?>

					<?= get_td(img([
						'class' => "logo_pago",
						'style' => 'width:85px!important',
						'src' => "../img_tema/bancos/santander.png"])) ?>


					<?= get_td(img([
						'class' => "logo_pago",
						'style' => 'width:95px!important',
						'src' => "../img_tema/bancos/banamex.png"])) ?>

				</tr>
			</table>

		</div>
	</div>
	<div class="col-lg-2">

		<table class="text-right">
			<tr>
				<?= get_td(heading_enid("MÉTODOS DE ENVÍO", 5, ["class" => "strong"]),
					['colspan' => 2, "class" => "black"]) ?>
			</tr>
			<tr>
				<?= get_td(img([
					'class' => "logo_pago",
					'style' => 'width:75px!important',
					'src' => "../img_tema/bancos/fedex.png"])) ?>

				<?= get_td(img(
					['class' => "logo_pago",
						'style' => 'width:95px!important',
						'src' => "../img_tema/bancos/dhl2.png"])); ?>
			</tr>
		</table>
	</div>
</div>