<div class="contenedor_agregar_servicio_form top_30">
    <?= heading_enid("DA A CONOCER TU PRODUCTO Ó SERVICIO", 3, 1) ?>
    <?= form_open('', ['class' => "form_nombre_producto ", "id" => 'form_nombre_producto']) ?>
    <?= div(
        heading_enid("¿QUÉ DESEAS ANUNCIAR?", 4, 1)
        .
        div(get_btw(

            anchor_enid('UN PRODUCTO',
                [
                    "class" => "tipo_promocion tipo_producto easy_select_enid mr-1",
                    "id" => "0",
                    "style" => "color: blue;"
                ]),


            anchor_enid(
                "UN SERVICIO",
                [
                    "class" => "tipo_promocion tipo_servicio",
                    "id" => "1"
                ])

            ,
            "display_flex_enid"
        )
        ,1)
        ,
        [
            "class" => " col-lg-3 top_30"
        ]
    ) ?>


    <?= get_btw(

        heading_enid(
            icon('fa fa-shopping-bag') . " ARTÍCULO",
            4,
            1
        )
        ,

        input(
            [
                "id" => "nombre_producto",
                "name" => "nombre",
                "class" => "input  nuevo_producto_nombre top_10",
                "type" => "text",
                "onkeyup" => "transforma_mayusculas(this)",
                "required" => true
            ],
            1
        )
        , "col-lg-3 seccion_menu_tipo_servicio top_30"


    ) ?>
    <?= div(


        append_data([
            heading_enid(
                "CICLO DE FACTURACIÓN",
                "4",
                [
                    'title' => "¿Qué vendes?"
                ], 1)
            ,
            create_select($ciclo_facturacion,
                "ciclo",
                "form-control ciclo_facturacion ci_facturacion top_10",
                "ciclo",
                "ciclo",
                "id_ciclo_facturacion",
                1)

        ])

        ,
        [
            "class" => "col-lg-3 contenedor_ciclo_facturacion seccion_menu_tipo_servicio top_30 ",
            "style" => "display: none;"
        ]) ?>

    <?= div(
        append_data([

            heading_enid(
                icon('fa fa-money') . " PRECIO", 4,
                [

                ],
                1
            )
            ,

            input(
                [
                    "id" => "costo",
                    "class" => "form-control input-sm costo precio top_10",
                    "name" => "costo",
                    "required" => true,
                    "step" => "any",
                    "type" => "number"
                ], 1
            )
            ,
            div($error_registro, ["class" => "extra_precio"], 1)

        ])
        ,
        ["class" => "col-lg-3 contenedor_precio seccion_menu_tipo_servicio top_30"]
    ) ?>
    <?= div(guardar("SIGUIENTE", ["class" => "btn_siguiente_registrar_servicio "]),
        ["class" => 'seccion_menu_tipo_servicio col-lg-3 siguiente_btn top_50']); ?>
    <?= form_close() ?>
</div>
<?= get_selector_categoria($is_mobile) ?>