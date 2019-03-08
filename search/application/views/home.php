<?= val_principal_img($q) ?>
<div class='contenedor_anuncios_home'>
    <?= get_format_menu_categorias_destacadas($es_movil, $categorias_destacadas) ?>
</div>
<div class="col-lg-2">
    <?= heading("FILTRA TU BÚSQUEDA", 5) ?>
    <?= div(
        icon("fa fa-search") . $busqueda . "(" . $num_servicios . "PRODUCTOS)",
        ["class" => 'informacion_busqueda_productos_encontrados strong'],
        1
    ) ?>
    <?= get_formar_menu_sugerencias($es_movil, $bloque_busqueda, $busqueda) ?>
</div>
<div class="col-lg-10">
    <?= get_format_filtros_paginacion($filtros, $order, $paginacion, $es_movil) ?>
    <?= div(get_format_listado_productos($lista_productos), ["class" => "bloque_productos"], 1) ?>
    <?= div($paginacion, 1) ?>
</div>
<?= get_btw(
    heading(
        "CATEGORIAS DESTACADAS",
        3
    )
    ,
    div(crea_sub_menu_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas)), 1)
    ,
    "col-lg-10"
) ?>