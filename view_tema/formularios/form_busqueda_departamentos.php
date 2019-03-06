<div class="contenedor_busqueda_global_enid_service">
	<form action="../search" class="search_principal_form top_10">
		<?= $clasificaciones_departamentos ?>
		<?= input(
			[
				"class" => "input_busqueda_producto input-sm",
				"type" => "text",
				"placeholder" => "Búsqueda",
				"name" => "q",
				"onKeyup" => "evita_basura();"
			]) ?>
		<?= guardar(icon("fa fa-search "),
			[
				"class" => " button_busqueda_producto  flipkart-navbar-button"],
			0,
			0) ?>
	<?=form_close()?>
</div>