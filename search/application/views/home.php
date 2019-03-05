<?= val_principal_img($q) ?>
    <div class='contenedor_anuncios_home'>
        <div class='contenedor_anunciate'>
            <?= get_format_menu_categorias_destacadas($es_movil, $categorias_destacadas) ?>
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
            <?= get_formar_menu_sugerencias($es_movil, $bloque_busqueda, $busqueda) ?>
        </div>
    </div>
    <div class="col-lg-10">
        <?= div(get_format_filtro($filtros, $order), ["class" => "col-lg-3"]) ?>
        <?= div(div($paginacion, ['class' => "pull-right"]), ["class" => "col-lg-9"]) ?>
        <?= get_format_listado_productos($lista_productos) ?>
        <?= div($paginacion, 1) ?>
    </div>
<?= br() ?>
<?= div("", ["class" => "col-lg-2"]) ?>
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