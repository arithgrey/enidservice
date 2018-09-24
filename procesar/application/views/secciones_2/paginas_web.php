<?php  
  
  $producto               =  
  create_resumen_servicio($servicio , $info_solicitud_extra);  
  $ciclos_solicitados     =  $info_solicitud_extra["num_ciclos"];
  $resumen_producto       = $producto["resumen_producto"];
  $resumen_servicio_info  = $producto["resumen_servicio_info"];
  $monto_total            = floatval($servicio[0]["precio"]) * floatval($ciclos_solicitados);
  
  


  $costo_envio_cliente= 0;  
  $text_envio ="";
  if($servicio[0]["flag_servicio"] ==  0){
    $costo_envio_cliente= $costo_envio["costo_envio_cliente"];  
    $text_envio =  $costo_envio["text_envio"]["cliente"];
  }
  
  $monto_total_con_envio =  $monto_total + $costo_envio_cliente;
?>
<div class="contenedor_compra">      
  <div class="contenedo_compra_info">
    <div class="col-lg-10 col-lg-offset-1">
      <?=n_row_12()?>                 
        <?=heading_enid(
          'TU CARRITO DE COMPRAS'.icon("fa fa-shopping-bag")
          , 
          2,
          ['class' => 'strong']
           )?>
        <?=div($resumen_producto , [], 1)?>      
        <?=div($text_envio)?>
        <?=input_hidden([
          "name"    =>  "resumen_producto" ,
          "class"   =>  "resumen_producto"  ,
          "value"   =>  $resumen_servicio_info
        ])?>
      
      <?=n_row_12()?>
      <div class="text-right">
        <?=heading_enid("MONTO DEL PEDIDO $".$monto_total."MXN", 4)?>      
        <?=heading_enid("CARGOS DE ENVÍO $".$costo_envio_cliente."MXN", 4)?>
        <?=heading_enid("TOTAL $".$monto_total_con_envio."MXN", 3 )?>
        <?=p("Precios expresados en Pesos Mexicanos.")?>
      </div>
      <?=end_row()?>
      <?=n_row_12()?>
        <?php if($in_session == 1): ?>
          <?=guardar("Ordenar compra" .icon("fa fa-shopping-cart") , 
          ['class' => 'btn_procesar_pedido_cliente']  )?>
          <?=place('place_proceso_compra')?>        
        <?php endif; ?>
      <?=end_row()?>
      <hr>
      <?=$this->load->view("secciones_2/form_afiliados");?>
    </div>
    <?=end_row()?>  
  </div>  
</div>  
<hr>        