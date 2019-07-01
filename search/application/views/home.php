<?php
$x = [];
$x[] = get_format_filtros_paginacion($filtros, $order, $paginacion, $is_mobile);
$x[] = append($lista_productos);

?>

<?= val_principal_img($q) ?>
<div class='contenedor_anuncios_home'>
    <?= get_format_menu_categorias_destacadas($is_mobile, $categorias_destacadas) ?>
</div>
<div class="row mt-3">
    <div class="col-lg-3">
        <?php
        $r = [];
        $r[] = heading("FILTRA TU BÚSQUEDA"
            .
            small($busqueda . "(" . $num_servicios . "PRODUCTOS)")
            ,
            3,
            ["class" => "text_filtro bg_black"]);
        $r[] = get_formar_menu_sugerencias($is_mobile, $bloque_busqueda, $busqueda);
        ?>
        <?= div(append($r), 10, 1) ?>
    </div>

    <?= btw(

        div(append($x), 12)
        ,
        div($paginacion, 12)
        ,
        9
    ) ?>

</div>
<div class="row white top_30" style="background:  #080221;;">
    <?= div("", 2) ?>
    <?= div(btw(
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