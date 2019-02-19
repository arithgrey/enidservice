<?php
$list = [heading_enid("ASISTENCIA", 4, ["class" => "strong"]), anchor_enid("- Servicio al cliente",
	["class" => 'black ',
		"href" => "../contact/#envio_msj"
	]),
	anchor_enid("-Términos y condiciones", ["class" => 'black ', "href" => "../terminos-y-condiciones"])
];

$list2 = [heading_enid("TEMAS RELACIONADOS", 4, ["class" => "strong"]), anchor_enid("- Temas de ayuda", ["class" => 'black ', "href" => "../faq/"])];
$list3 = [heading_enid("ESPECIALES", 4, ["class" => "strong"]), anchor_enid("- Trabaja en nuestro equipo", ["class" => 'black ', "href" => "../unete_a_nuestro_equipo"])];
$list4 = [heading_enid("ACERCA DE NOSOTROS", 4, ["class" => "strong"]), anchor_enid(img(["src" => "../img_tema/enid_service_logo.jpg"]), ["class" => 'black ', "href" => "../sobre_enidservice"])];
$base = "col-lg-3 col-sm-6 inner";

$list_footer = [
	div(ul($list), ["class" => $base]),
	div(ul($list2), ["class" => $base]),
	div(ul($list3), ["class" => $base]),
	div(ul($list4), ["class" => $base])
];
?>
<?= div("", ["class" => "separador-footer"], 1) ?>
<?= input_hidden([
	"class" => "in_session",
	"value" => $in_session
]) ?>
<?= input_hidden([
	"name" => "titulo_web",
	"class" => "titulo_web",
	"value" => $titulo
]) ?>
<?php if (!is_null($in_session) && $in_session === 0): ?>
	<?php if (!isset($proceso_compra) || $proceso_compra == 0): ?>
		<div class="base_compras">
			<div class='col-lg-4'>
				<div class="row">
					<?= div(icon('fa  fa-fighter-jet'), ['class' => 'col-lg-2']) ?>
					<div class='col-lg-10'>
						<?= div("FACILIDAD DE COMPRA", ['class' => 'strong']) ?>
						<?= div("Compras seguras al momento") ?>
						<?php if (!is_null($id_usuario) && isset($id_usuario)): ?>
							<?= input_hidden([
								"class" => 'id_usuario',
								"value" => $id_usuario
							]) ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class='col-lg-4'>
				<div class="row">
					<?= div(icon('fa fa-clock-o '), ['class' => 'col-lg-2']) ?>
					<?= div(append_data([
						div("+ ENTREGAS PUNTUALES", ['class' => 'strong'], 1),
						div("Recibe lo que deseas en tiempo y forma", 1)
					]), ["class" => 'col-lg-10']) ?>
				</div>
			</div>
			<div class='col-lg-4'>
				<div class="row">
					<?= div(icon('fa fa-lock '), ['class' => 'col-lg-2']) ?>
					<?= div(append_data([
						div(" COMPRAS SEGURAS", ['class' => 'strong']),
						div("Tu dinero se entregará al vendedor hasta que confirmes que recibiste tu pedido!", 1)
					]),
						["class" => 'col-lg-10']) ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>



<?php if ($in_session == 0): ?>
	<?php if (!isset($proceso_compra) || !is_null($proceso_compra) || $proceso_compra == 0): ?>
		<?= div(print_footer($list_footer), ["class" => "base_paginas_extra"], 1) ?>
	<?php endif ?>
	<?= n_row_12() ?>
	<?php if (!is_null($is_mobile) && $is_mobile == 0): ?>
		<?php if (!isset($proceso_compra) || $proceso_compra == 0): ?>
			<?= $this->load->view("../../../view_tema/metodos_pago"); ?>
		<?php endif ?>
	<?php endif ?>
	<?= end_row() ?>
	<?= div("© 2018 ENID SERVICE.", ['class' => 'white footer-enid']) ?>
<?php endif; ?>


<link rel="stylesheet" type="text/css" href="../css_tema/template/main.css?<?= version_enid ?>">
<link href="../css_tema/template/bootstrap.min.css?<?= version_enid ?>"
      rel="stylesheet" id="bootstrap-css">
<?php if (isset($css) && !is_null($css) && is_array($css) && count($css) > 0): ?>
	<?php foreach ($css as $c): $link = "../css_tema/template/" . $c; ?>
		<link rel="stylesheet" type="text/css" href="<?= $link; ?>?<?= version_enid ?>">
	<?php endforeach; ?>
<?php endif; ?>

<?php if (isset($css_external) && !is_null($css_external) && is_array($css_external)): ?>
	<?php foreach ($css_external as $c): ?>
		<link
				rel="stylesheet"
				type="text/css"
				href="<?php echo $c; ?>?<?= version_enid ?>">
	<?php endforeach; ?>
<?php endif; ?>
<script src="../js_tema/js/main.js?<?= version_enid ?>"></script>
<?php if (isset($js) && !is_null($js) && is_array($js)): ?>
	<?php $s = "../js_tema/";
	foreach ($js as $script): ?>
		<script type='text/javascript' src='<?php echo $s . $script; ?>?<?= version_enid ?>'></script>
	<?php endforeach; ?>
<?php endif; ?>

<?php if (isset($js_extra) && !is_null($js_extra) && is_array($js_extra)): ?>
	<?php foreach ($js_extra as $script): ?>
		<script type='text/javascript' src='<?php echo $script; ?>'></script>
	<?php endforeach; ?>
<?php endif; ?>
<link rel="stylesheet" href="../css_tema/font-asome2/css/font-awesome.min.css?<?= version_enid ?>">

</body>
</html>