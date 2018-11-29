<?php 
  $hidden = array(
    "plan"              =>  $id_servicio,
    "extension_dominio" =>  "",
    "ciclo_facturacion" =>  "" ,
    "is_servicio"       =>  $flag_servicio,
    "q2"                =>  $q2 
  );
?>
<form action="../producto/?producto=<?=$id_servicio?>&pre=1"  id="AddToCartForm" method="POST" >  
  <?=form_hidden($hidden)?> 
  <div class="btn-and-quantity">
    <div class="spinner">        
        PIEZAS <?=select_cantidad_compra($flag_servicio, $existencia)?>    
        <?=form_label(get_text_periodo_compra($flag_servicio) , "" , ["class"=>"numero_piezas"] )?>
    </div>
    <?=guardar("ORDENAR "  , 
              [
                'id' => 'AddToCart'                 
              ],
              1,
              1)?>  
    <br>
    <?=agregar_lista_deseos(0 , $in_session)?>
  </div>
<?=form_close()?>                    