<?php
$num_servicios_encontrados = $servicios["num_servicios"];
$servicios = $servicios["servicios"];
if ($es_movil == 0) {

	$primer_nivel = $bloque_busqueda["primer_nivel"];
	$segundo_nivel = $bloque_busqueda["segundo_nivel"];
	$tercer_nivel = $bloque_busqueda["tercer_nivel"];
	$cuarto_nivel = $bloque_busqueda["cuarto_nivel"];
	$quinto_nivel = $bloque_busqueda["quinto_nivel"];

	$bloque_primer_nivel = crea_seccion_de_busqueda_extra($primer_nivel, $busqueda);
	$bloque_segundo_nivel = crea_seccion_de_busqueda_extra($segundo_nivel, $busqueda);
	$bloque_tercer_nivel = crea_seccion_de_busqueda_extra($tercer_nivel, $busqueda);
	$bloque_cuarto_nivel = crea_seccion_de_busqueda_extra($cuarto_nivel, $busqueda);
	$bloque_quinto_nivel = crea_seccion_de_busqueda_extra($quinto_nivel, $busqueda);
}

$categorias_destacadas_orden = sub_categorias_destacadas($categorias_destacadas);


$url_anunciar =
	($in_session == 1) ? "../../planes_servicios" : "../../login?action=nuevo";

$anunciar = anchor_enid('ANUNCIA TUS ARTÍCULOS AQUÍ',
	[
		"src" => $url_anunciar,
		'class' => 'anuncia_articulos'
	]);


?>

<?php if (strlen(trim($q)) == 0): ?>
	<?= place("contenedor_img_principal") ?>
<?php endif; ?>

<div class='contenedor_anuncios_home'>
	<div class='contenedor_anunciate'>
		<?php if ($es_movil == 0): ?>
			<?php
			foreach (crea_menu_principal_web($categorias_destacadas) as $row): ?>

				<?= anchor_enid(mayus($row["nombre_clasificacion"]),
					[
						"href" => "?q=&q2=" . $row['primer_nivel'],
						"class" => 'categorias_mas_vistas'
					]); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>


<div class="col-lg-2">

	<?php if ($es_movil == 0): ?>
		<?= heading("FILTRA TU BÚSQUEDA", 5) ?>
	<?php endif; ?>
	<?= div(
		icon("fa fa-search") . $busqueda . "(" . $num_servicios . "PRODUCTOS)",
		["class" => 'informacion_busqueda_productos_encontrados strong'],
		1
	) ?>
	<div class='contenedor_menu_productos_sugeridos'>
		<?php
		if ($es_movil < 1) {

			$r = [];
			if ($bloque_primer_nivel["num_categorias"] > 0) {
				$r[] = $bloque_primer_nivel["html"];
			}
			if ($bloque_segundo_nivel["num_categorias"] > 0) {
				$r[] = hr();
				$r[] = $bloque_segundo_nivel["html"];
			}
			if ($bloque_tercer_nivel["num_categorias"] > 0) {
				$r[] = hr();
				$r[] = $bloque_tercer_nivel["html"];
			}
			if ($bloque_cuarto_nivel["num_categorias"] > 0) {
				$r[] = hr();
				$r[] = $bloque_cuarto_nivel["html"];
			}
			if ($bloque_quinto_nivel["num_categorias"] > 0) {
				$r[] = hr();
				$r[] = $bloque_quinto_nivel["html"];
			}
			echo div(append_data($r), ["class" => "contenedor_sub_categorias"]);
		}

		?>
	</div>
</div>


<div class="col-lg-10">
	<?= br() ?>
	<div class="col-lg-3">
		<select class="form-control order" name="order" id="order">
			<?php $a = 0;
			foreach ($filtros as $row): ?>
				<?php if ($a == $order): ?>
					<option value="<?= $a ?>" selected>
						<?= $row ?>
					</option>
				<?php else: ?>
					<option value="<?= $a ?>">
						<?= $row ?>
					</option>
				<?php endif; ?>
				<?php $a++;endforeach; ?>
		</select>
	</div>

	<?= div(div($paginacion, ['class' => "pull-right"]), ["class" => "col-lg-9"]) ?>

	<?= br() ?>
	<?php
	$list = "";
	$flag = 0;
	$extra = "";
	$b = 0;
	foreach ($lista_productos as $row) {
		if ($b > 0) {
			$extra = "margin-top:30px;";
		}
		echo div(div(div($row, ["class" => 'row'])), ["class" => 'col-lg-3', "style" => $extra]);
		$flag++;
		if ($flag == 4) {
			$flag = 0;
			echo hr();
			$b++;
		}
	} ?>
	<?php if (count($lista_productos) > 8): ?>
		<?= div($paginacion, 1) ?>
	<?php endif; ?>
</div>


<?= br() ?>

<?= div("", ["class" => "col-lg-2"]) ?>
<div class="col-lg-10">
	<?= heading(
		"CATEGORIAS DESTACADAS",
		3
	) ?>
	<?= div(crea_sub_menu_categorias_destacadas($categorias_destacadas_orden), 1) ?>
</div>
