<?php 
  
  $info_persona = $info_persona[0];
  $tmp_razon_social = $info_persona["nombre"]." ".$info_persona["a_paterno"]." ".$info_persona["a_materno"];
  $RFC =  $info_persona["RFC"];
  $domicilio_fiscal = $info_persona["domicilio_fiscal"]; 
  $modulo =  $info_enviada["modulo"];

?>

<?=n_row_12()?>
  <div class="col-lg-12">
    <form class='formulario_cliente_liberado' id='formulario_cliente_liberado'>      
      <div class='row'>
          <div class="col-lg-12">            
              <input type="hidden" 
                name="id_persona" 
                value='<?=$info_persona['id_persona']?>'>
              <input type="hidden" 
                name="usuario_venta" 
                value='<?=$info_persona['id_usuario']?>'>
              <input type="hidden" 
                name="usuario_validacion"  
                value="<?=$info_enviada['usuario_validacion']?>">

              <input type="hidden" 
                name="renovacion" 
                value="0">            
          </div>
      </div>
      <div class='row'>                          
          <div class='col-lg-6'>              
              <span style="font-size: .8em;">
                Proyecto
              </span>
              <input 
              id="nombre_proyecto" 
              name="nombre_proyecto" 
              class="input-sm form-control" 
              placeholder="Nombre del proyecto" 
              required="" 
              value="<?=$info_persona["dominio_deseado"]?>"
              type="text">                    
          </div>
          <div class='col-lg-6'>
              <span style="font-size: .8em;">
                Dominio 
              </span>
              <input 
              id="url" 
              name="url" 
              value="<?=$info_persona["dominio_deseado"]?>" 
              class="input-sm" 
              placeholder="Url del proyecto" 
              type="url">                   
          </div>  
      </div>    
      <div class='row'>                
        <div class="col-lg-3">                    
            <span style="font-size: .8em;" >
              Precio
            </span>                        
            <?=create_select($precios , 
                "precio" , 
                "form-control input-sm precios_form" , 
                "precios", 
                "precio" , 
                "id_ciclo_facturacion"
            );?>          
        </div>
        <div class="col-lg-3">          
          <span style="font-size: .8em;">
              Ciclo de facturación
          </span>                        
          <span class='place_ciclo_facturacion'>              
          </span>                    
        </div>        
        <div class="col-lg-3 num_meses_seccion" style="display: none;">          
            <span style="font-size: .8em;">
              Número de Meses
            </span>                        
            <div class="place_meses_form">                
            </div>
        </div>
        <div class="col-lg-3">                    
          <span style="font-size: .8em;" >
              Total
          </span>                        
          <div class='place_text_total'>              
          </div>          
        </div>
        <div class="col-lg-3">                    
            <span style="font-size: .8em;" >
              IVA
            </span>                        
            <div class='place_text_iva'>              
            </div>          
        </div>
        <div class="col-lg-3">          
            
            <span style="font-size: .8em;" class="text_saldo_orden_pago">              
              Saldo cubierto
            </span>            
            
              <input 
                class=' form-control input-sm saldo_cubierto' 
                step="any"
                type="number" 
                name="saldo_cubierto">                                     
        </div>
        <div class="col-lg-3">          
            <span style="font-size: .8em;">
              Siguiente vencimiento 
            </span>            
            <div class='place_siguiente_vencimiento'>              
            </div>            
            <input type="hidden" 
                   id="vyear" value='<?=$precios[0]["fecha_actual_mas_1_year"]?>'>
            <input type="hidden" 
                   id="vmonth" 
                   value='<?=$precios[0]["fecha_actual_mas_1_mes"]?>'>
            <input type="hidden" 
                   id="vweek" 
                   value='<?=$precios[0]["fecha_actual_mas_1_semana"]?>'>
        </div>
        <div class="col-lg-3">
          
            <span style="font-size: .8em;">
              Forma de pago
            </span>                                    
            <?=create_select_selected(
                $formas_de_pago , 
                "id_forma_pago", 
                "forma_pago" , 
                "3" , 
                "forma_pago" ,  
                "form-control input-sm forma_pago" );?>                            
        </div>
        <div class="col-lg-3">
            <span style="font-size: .8em;">
              ¿Requiere factura?
            </span>            
            <select 
              class='form-control select_opcion_facturacion' 
              id='select_opcion_facturacion' 
              name='facturar_servicio'>                
              <option value="0">
                   NO
              </option>
              <option value="1">
                   SI
              </option>
            </select>
        </div>
        <div style="display: none;" class='seccion_facturacion'>                  
            <div class="col-lg-4">              
                <span style="font-size: .8em;">
                  Razón social
                </span>            
                <input 
                  class='input-sm' 
                  type="text" 
                  value='<?=$tmp_razon_social;?>'
                  name="razon_social"> 
            </div>
            <div class="col-lg-4">              
                <span style="font-size: .8em;">
                  RFC
                </span>            
                <input 
                  class=' form-control input-sm' 
                  type="text" 
                  name="RFC"
                  value="<?=$RFC?>">                 
            </div>
            <div class="col-lg-4">
              
                <span style="font-size: .8em;">
                    Domicilio fiscal
                </span>            
                    <input 
                    value="<?=$domicilio_fiscal;?>" 
                    class=' form-control input-sm' 
                    type="text" 
                    name="domicilio_fiscal"> 
              
            </div>
            <div class="col-lg-4">
              <div>
                <span style="font-size: .8em;">
                    Saldo cubierto (texto)
                </span>            
                <div>              
                  <div>
                    <input 
                      class='form-control input-sm' 
                      type="text"                     
                      name="saldo_cubierto_texto"> 
                  </div>
                </div>
               </div>          
            </div>
        </div>  
      </div>    
      <div class='row'>        
        <div class="col-lg-12">
          <span style="font-size: .8em;">
            Concepto
          </span>
          <div>            
            <textarea name='detalles_servicio' 
            class='concepto_servicio' 
            rows="1">              
            </textarea>
          </div>          
        </div>
      </div>                      
      <button class='btn input-sm' style="background: black!important;">
        Generar órden de compra
      </button>     
      <?=n_row_12()?>
        <div class="place_liberar_servicio">          
        </div>
      <?=end_row()?>
    </form>  
  </div>
<?=end_row()?>