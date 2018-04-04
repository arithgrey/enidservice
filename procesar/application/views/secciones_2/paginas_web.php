<?php  
  $producto =  create_resumen_servicio($servicio , $info_solicitud_extra);  
  $ciclos_solicitados =  $info_solicitud_extra["num_ciclos"];
  $resumen_producto = $producto["resumen_producto"];
  $resumen_servicio_info = $producto["resumen_servicio_info"];
  $monto_total = floatval($servicio[0]["precio"]) * floatval($ciclos_solicitados);
  


  $costo_envio_cliente= 0;  
  $text_envio ="";
  if($servicio[0]["flag_servicio"] ==  0){
    $costo_envio_cliente= $costo_envio["costo_envio_cliente"];  
    $text_envio =  $costo_envio["text_envio"]["cliente"];
  }
  
  

  $monto_total_con_envio =  $monto_total + $costo_envio_cliente;
?>
  <div class="tab-pane active text-style contenedor_compra" id="tab2">      
      
            <div class="contenedo_compra_info">
              <div class="row">
                <?=n_row_12()?>
                  <div class="col-lg-2">
                  </div>
                  <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-12">
                          <span class="strong "  
                              style="font-size: 1.5em;line-height: .8;">  
                              Su carrito de compras
                          </span>
                        </div>                        
                        <hr style="color:black;height: 1px;
                            border: 0;background-color: black;">                      
                        <div class="col-lg-12">
                          <?=$resumen_producto;?>   
                          <br>
                          <?=$text_envio?> 
                          <input 
                            type="hidden" 
                            name="resumen_producto" 
                            class="resumen_producto"  
                            value="<?=$resumen_servicio_info;?>">
                        </div>

                        <div class="col-lg-12 text-right" style="margin-top: 10px;">                               
                          <div class="row" style="margin-top: 10px;">
                            <span 
                              style="font-size: 1em;
                                    padding: 2px;">
                                    <strong class="text-left">
                                      Monto del pedido:
                                    </strong>
                                    $<?=$monto_total?> MXN                                
                            </span> 
                          </div>
                          
                          <div class="row" style="margin-top: 10px;">
                            <span 
                              style="font-size: 1em;                                    
                                    padding: 2px;">
                                    <strong class="text-left">
                                      Cargos del envío
                                    </strong>
                                    $<?=$costo_envio_cliente?>
                                    MXN                                
                                    
                            </span> 
                          </div>
                             <div class="row" style="margin-top: 10px;">
                            <span style="font-size: 1em;                                    
                                    padding: 2px;
                                    background: green;color: white;">
                                    <strong class="text-left">
                                      Total
                                    </strong>
                                    $<?=$monto_total_con_envio?>
                                    MXN                                
                                    
                            </span> 
                          </div>
                          <br>
                          <div class="row">
                            <span style="font-size: .7em;" class="strong">
                              Precios expresados en Pesos Mexicanos. 
                            </span>          
                            <?php
                              if($in_session == 1){
                                echo "<div>
                                        <button class='btn input-sm btn_procesar_pedido_cliente'>
                                            Ordenar compra
                                            <i class='fa fa-shopping-cart'></i>
                                        </button>
                                      <div>
                                      <div class='place_proceso_compra'>
                                      </div>";
                              }                            
                            ?>
                          </div>
                        </div>
                    </div> 
                    <hr style="color:black;height: 1px;
                        border: 0;
                        background-color: black;">                    

                        <div class="col-lg-12">                                         
                          <?=$this->load->view("secciones_2/form_afiliados");?>
                        </div>                    
                  </div>
                <?=end_row()?>  

              </div>  
            </div>  
        <hr>        
    </div>