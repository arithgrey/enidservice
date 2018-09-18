<?php 
  $hidden = array(
    "plan"              =>  $id_servicio,
    "extension_dominio" =>  "",
    "ciclo_facturacion" =>  "" ,
    "is_servicio"       =>  $flag_servicio,
    "q2"                =>  $q2 
  );
?>
<form action="../procesar"  id="AddToCartForm" >
  <?=form_hidden($hidden)?>
  <?=form_input([
    "type"=>"hidden", "name"=>"talla", 
    "value"=>"0" , "class"=>"producto_talla" ,"id"=>'productotalla'])?>  
  
  <div class="btn-and-quantity">
    <div class="spinner">
        <?=form_input([
          "type"=>"number", "name"=>"num_ciclos", 
          "value"=>"1" , "min"=>"1", 
          "max"=>valida_maximo_compra($flag_servicio, $existencia),  
          "class"=>"telefono_info_contacto"]);?>      
        <?=form_label(get_text_periodo_compra($flag_servicio) , "" , 
        ["class"=>"numero_piezas"] )?>
    </div>

    <?=guardar( "ORDENAR COMPRA"  , 
    ['id' => 'AddToCart' , 'type' => 'submit'] )?>  
  </div>
<?=form_close()?>                    