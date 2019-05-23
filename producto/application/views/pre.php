<?= div(heading_enid("¿CÓMO PREFIERES TU ENTREGA?", 3, "titulo_preferencia text-center border-bottom padding_10" ), 4, 1,1) ?>

<?= get_btw(

    get_format_eleccion_mensajeria($id_servicio, $orden_pedido)
    ,
    get_format_eleccion_contra_entrega($id_servicio, $orden_pedido)
    ,

    8, 1 ,1
) ?>

<?= div(
    get_seccion_pre_pedido(
        $url_imagen_servicio,
        $orden_pedido,
        $plan,
        $extension_dominio,
        $ciclo_facturacion,
        $is_servicio,
        $q2,
        $num_ciclos,
        $id_servicio,
        $carro_compras,
        $id_carro_compras
    )
    ,
    2,
    1,
    1
) ?>

