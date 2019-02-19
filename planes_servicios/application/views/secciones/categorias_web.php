<div class="contenedor_categorias_servicios">
	<?= heading_enid("GRUPO AL CUAL PERTENECE TU PRODUCTO", 3) ?>
	<?= anchor_enid(
		"CANCELAR",
		[
			"class" => "cancelar_registro",
			"style" => "color: white!important"
		],
		1); ?>
	<?= hr() ?>
	<?= n_row_12() ?>
	<?= div(place("primer_nivel_seccion"), ["class" => "info_categoria"]) ?>
	<?= div(place("segundo_nivel_seccion"), ["class" => "info_categoria"]) ?>
	<?= div(place("tercer_nivel_seccion"), ["class" => "info_categoria"]) ?>
	<?= div(place("cuarto_nivel_seccion"), ["class" => "info_categoria"]) ?>
	<?= div(place("quinto_nivel_seccion"), ["class" => "info_categoria"]) ?>
	<?= div(place("sexto_nivel_seccion"), ["class" => "info_categoria"]) ?>
	<?= end_row(); ?>
</div>