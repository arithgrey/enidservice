<?= val_principal_img($q) ?>
<div class='contenedor_anuncios_home'>
	<?= get_format_menu_categorias_destacadas($es_movil, $categorias_destacadas) ?>
</div>
<div class="row top_30">
	<div class="col-lg-3">


		<div class="col-lg-12">
			<?= heading("FILTRA TU BÚSQUEDA"
				.
				small($busqueda . "(" . $num_servicios . "PRODUCTOS)")
				,
				3,
				["class"=> "text_filtro"]) ?>

			<div class="border-right padding_10">
			<?= get_formar_menu_sugerencias($es_movil, $bloque_busqueda, $busqueda) ?>
			</div>
		</div>
	</div>
	<div class="col-lg-9">
		<?= get_format_filtros_paginacion($filtros, $order, $paginacion, $es_movil) ?>
		<?= div(get_format_listado_productos($lista_productos), ["class" => "bloque_productos"], 1) ?>
		<?= div($paginacion, 1) ?>
	</div>
</div>


<div class="row white top_30" style="background:  #080221;;">
	<div class="col-lg-2"></div>
	<div  class="col-lg-10">
		<?= get_btw(
			heading(
				"CATEGORIAS DESTACADAS",
				3
			)
			,
			div(crea_sub_menu_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas)), 1)
			,
			""
		) ?>
	</div>
</div>