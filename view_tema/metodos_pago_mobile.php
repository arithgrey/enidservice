<div class="container inner">

	<table style="width: 100%;">
		<tr>
			<?= td("MÉTODOS DE PAGO",
				array('colspan' => 7, "class" => "black")) ?>
		</tr>
		<tr>
			<?= td(img(array(
				'class' => "logo_pago_mb",
				'src' => "../img_tema/bancos/masterDebito.png"))) ?>

			<?= td(img(array(
				'class' => "logo_pago_mb",
				'src' => "../img_tema/bancos/paypal2.png"))) ?>

			<?= td(img(array(
				'class' => "logo_pago_mb",
				'src' => "../img_tema/bancos/visaDebito.png"))) ?>

			<?= td(img(array(
				'class' => "logo_pago_mb",
				'src' => "../img_tema/bancos/oxxo-logo.png"))) ?>

			<?= td(img(array(
				'class' => "logo_pago_mb",
				'src' => "../img_tema/bancos/bancomer2.png"))) ?>

			<?= td(img(array(
				'class' => "logo_pago_mb",
				'src' => "../img_tema/bancos/santander.png"))) ?>


			<?= td(img(array(
				'class' => "logo_pago_mb",
				'src' => "../img_tema/bancos/banamex.png"))) ?>
		</tr>
	</table>

</div>
<div class="container inner">
	<table>
		<tr>
			<?= td("MÉTODOS DE ENVÍO",
				[
					'colspan' => 2,
					"class" => "black"
				]) ?>
		</tr>
		<tr>
			<?= td(img(
				[
					'class' => "logo_pago_mb",
					'src' => "../img_tema/bancos/fedex.png"
				])) ?>
			<?= td(img(
				[
					'class' => "logo_pago_mb",
					'src' => "../img_tema/bancos/dhl2.png"
				])) ?>
		</tr>
	</table>
</div>