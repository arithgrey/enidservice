<?= val_principal_img($q) ?>
<div class='contenedor_anuncios_home'>
    <?= get_format_menu_categorias_destacadas($es_movil, $categorias_destacadas) ?>
</div>
<div class="row mt-3">
    <div class="col-lg-3">
        <?php
        $r[] = heading("FILTRA TU BÚSQUEDA"
            .
            small($busqueda . "(" . $num_servicios . "PRODUCTOS)")
            ,
            3,
            ["class" => "text_filtro bg_black"]);
        $r[] = get_formar_menu_sugerencias($es_movil, $bloque_busqueda, $busqueda);
        ?>
        <?= div(append_data($r), 10, 1) ?>
    </div>
    <div class="col-lg-9">
        <?php
        $x[] = get_format_filtros_paginacion($filtros, $order, $paginacion, $es_movil);
        $x[] = get_format_listado_productos($lista_productos);
        ?>
        <?= div(append_data($x), 12) ?>
        <?= div($paginacion, 12) ?>
    </div>
</div>


<div class="row white top_30" style="background:  #080221;;">

    <?= div("", 2) ?>
    <?= div(get_btw(
        heading(
            "CATEGORIAS DESTACADAS",
            3
        )
        ,
        div(crea_sub_menu_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas)), 1)
        ,
        ""
    ), 10) ?>

</div>
