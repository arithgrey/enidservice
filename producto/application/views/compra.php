<form action="../producto/?producto=<?=$id_servicio?>&pre=1"  id="AddToCartForm" method="POST" >
  <?=form_hidden( [
    "plan"              =>  $id_servicio,
    "extension_dominio" =>  "",
    "ciclo_facturacion" =>  "" ,
    "is_servicio"       =>  $flag_servicio,
    "q2"                =>  $q2
  ])?>
    <?=div("PIEZAS" .select_cantidad_compra($flag_servicio, $existencia))?>
    <?=br()?>
    <?=guardar("ORDENAR "  ,
        [
            'id' => 'AddToCart'
        ],
        1,
        1)?>
  <?=form_close()?>
  <?=br(2)?>

<?=agregar_lista_deseos(0 , $in_session)?>