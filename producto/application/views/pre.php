<?=br(3)?>
<?= d(h("SELECCIONA TU TIPO DE ENTREGA", 3 , "text-center"), "col-lg-4 col-lg-offset-4 mb-5",1) ?>
<?= btw(

    get_format_eleccion_mensajeria($id_servicio, $orden_pedido)
    ,
    get_format_eleccion_contra_entrega($id_servicio, $orden_pedido)
    ,

    8, 1 ,1
) ?>

<?= d(
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
<?=br(4)?>
