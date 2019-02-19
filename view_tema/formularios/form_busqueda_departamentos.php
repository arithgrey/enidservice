<div class="col-lg-8 contenedor_busqueda_global_enid_service">
	<form action="../search" class="search_principal_form">
		<?= div($clasificaciones_departamentos, ["class" => "col-lg-4"]) ?>
		<?= input(
			[
				"class" => "col-lg-7 input_busqueda_producto input_enid",
				"type" => "text",
				"style" => "margin-top: 5px;",
				"placeholder" => "Búsqueda",
				"name" => "q",
				"onKeyup" => "evita_basura();"
			]) ?>
		<?= guardar(icon("fa fa-search "),
			[
				"class" => "col-lg-1 button_busqueda_producto  flipkart-navbar-button"],
			0,
			0) ?>
	</form>
</div>